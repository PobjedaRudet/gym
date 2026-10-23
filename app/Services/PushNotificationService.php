<?php

namespace App\Services;

use App\Models\Obavijest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

/**
 * Push notifikacije na mobilnu aplikaciju preko Firebase Cloud Messaging-a (HTTP v1 API).
 *
 * Aplikacija se nakon prijave pretplati na topic (services.fcm.topic), pa jedna
 * poruka stigne na telefone svih prijavljenih clanova. Kljuc je service account
 * JSON iz Firebase konzole (services.fcm.credentials); bez njega se nista ne salje.
 */
class PushNotificationService
{
    private const SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';

    /** Isti ID kanala kao u Android aplikaciji (res/values/strings.xml). */
    private const ANDROID_CHANNEL = 'obavijesti';

    /** Starije obavijesti (npr. stare objave uvezene sa Facebooka) ne salju push. */
    private const MAX_AGE_HOURS = 24;

    public function sendAnnouncement(Obavijest $obavijest): bool
    {
        if ($obavijest->created_at && $obavijest->created_at->lt(now()->subHours(self::MAX_AGE_HOURS))) {
            return false;
        }

        return $this->sendToTopic(
            Str::limit($obavijest->naslov, 100),
            Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($obavijest->sadrzaj))), 200),
            ['type' => 'announcement', 'id' => (string) $obavijest->id]
        );
    }

    /**
     * Greske se samo loguju: obavijest je tada vec snimljena i ne smije pasti
     * zbog problema sa Firebase-om.
     */
    public function sendToTopic(string $title, string $body, array $data = []): bool
    {
        try {
            $credentials = $this->credentials();
            if (!$credentials) {
                return false;
            }

            $response = Http::timeout(10)
                ->withToken($this->accessToken($credentials))
                ->post("https://fcm.googleapis.com/v1/projects/{$credentials['project_id']}/messages:send", [
                    'message' => [
                        'topic' => config('services.fcm.topic'),
                        'notification' => ['title' => $title, 'body' => $body],
                        // FCM trazi objekat; prazan PHP niz bi otisao kao JSON lista.
                        'data' => (object) $data,
                        'android' => [
                            'priority' => 'high',
                            'notification' => ['channel_id' => self::ANDROID_CHANNEL],
                        ],
                        'apns' => ['payload' => ['aps' => ['sound' => 'default']]],
                    ],
                ]);

            if (!$response->successful()) {
                Log::channel('daily')->error('[Push] FCM greska ' . $response->status() . ': ' . $response->body());
                return false;
            }

            return true;
        } catch (Throwable $e) {
            Log::channel('daily')->error('[Push] Slanje nije uspjelo: ' . $e->getMessage());
            return false;
        }
    }

    private function credentials(): ?array
    {
        $path = config('services.fcm.credentials');
        if (empty($path)) {
            return null;
        }

        // Relativna putanja je u odnosu na korijen projekta.
        if (!preg_match('#^([A-Za-z]:)?[\\\\/]#', $path)) {
            $path = base_path($path);
        }

        if (!is_file($path)) {
            throw new RuntimeException('FCM kljuc ne postoji: ' . $path);
        }

        $credentials = json_decode(file_get_contents($path), true);
        foreach (['project_id', 'client_email', 'private_key', 'token_uri'] as $key) {
            if (empty($credentials[$key])) {
                throw new RuntimeException("FCM kljuc nema polje {$key}: " . $path);
            }
        }

        return $credentials;
    }

    /**
     * OAuth token vrijedi sat vremena, pa se cuva u kesu da se ne trazi za svaku poruku.
     */
    private function accessToken(array $credentials): string
    {
        return Cache::remember('fcm_access_token_' . md5($credentials['client_email']), now()->addMinutes(50), function () use ($credentials) {
            $response = Http::asForm()->timeout(10)->post($credentials['token_uri'], [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->signedJwt($credentials),
            ]);

            if (!$response->successful() || !$response->json('access_token')) {
                throw new RuntimeException('Google OAuth greska ' . $response->status() . ': ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    private function signedJwt(array $credentials): string
    {
        $now = time();
        $segments = [
            $this->base64Url(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])),
            $this->base64Url(json_encode([
                'iss' => $credentials['client_email'],
                'scope' => self::SCOPE,
                'aud' => $credentials['token_uri'],
                'iat' => $now,
                'exp' => $now + 3600,
            ])),
        ];

        $key = openssl_pkey_get_private($credentials['private_key']);
        if (!$key || !openssl_sign(implode('.', $segments), $signature, $key, OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('FCM kljuc ima neispravan private_key.');
        }

        $segments[] = $this->base64Url($signature);

        return implode('.', $segments);
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
