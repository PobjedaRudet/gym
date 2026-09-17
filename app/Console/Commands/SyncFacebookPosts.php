<?php

namespace App\Console\Commands;

use App\Models\Moderator;
use App\Models\Obavijest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SyncFacebookPosts extends Command
{
    protected $signature = 'facebook:sync-posts';

    protected $description = 'Preuzima najnovije objave sa Facebook stranice i kreira javne obavijesti na naslovnoj';

    /**
     * Email sistemskog moderatora koji "vlasnik" automatski uvezenih obavijesti.
     * Ovaj zapis se kreira u migraciji koja dodaje fb_post_id/javno kolone.
     */
    private const SYSTEM_MODERATOR_EMAIL = 'facebook-sync@begsfit.ba';

    private const GRAPH_API_VERSION = 'v19.0';

    public function handle(): int
    {
        $pageId = config('services.facebook.page_id');
        $accessToken = config('services.facebook.access_token');

        if (empty($pageId) || empty($accessToken)) {
            $this->warn('Facebook sinhronizacija preskocena: FACEBOOK_PAGE_ID / FACEBOOK_PAGE_ACCESS_TOKEN nisu podeseni u .env.');
            Log::channel('daily')->warning('[FacebookSync] Preskoceno - nedostaju kredencijali u .env.');
            return self::SUCCESS;
        }

        $response = Http::timeout(20)->get("https://graph.facebook.com/" . self::GRAPH_API_VERSION . "/{$pageId}/posts", [
            'fields' => 'id,message,created_time,permalink_url,full_picture',
            'limit' => 10,
            'access_token' => $accessToken,
        ]);

        if (!$response->successful()) {
            $this->error('Facebook API greska: ' . $response->status() . ' ' . $response->body());
            Log::channel('daily')->error('[FacebookSync] API greska ' . $response->status() . ': ' . $response->body());
            return self::FAILURE;
        }

        $posts = $response->json('data', []);

        if (empty($posts)) {
            $this->info('Nema novih objava na Facebook stranici.');
            return self::SUCCESS;
        }

        $moderator = Moderator::firstOrCreate(
            ['email' => self::SYSTEM_MODERATOR_EMAIL],
            [
                'name' => 'Facebook Sync',
                'password' => Hash::make(Str::random(32)),
            ]
        );

        $created = 0;

        foreach ($posts as $post) {
            try {
                $fbId = $post['id'] ?? null;
                $message = trim($post['message'] ?? '');

                if (!$fbId || $message === '') {
                    // Preskoci objave bez teksta (npr. samo slika/link bez opisa) - obavijest zahtijeva sadrzaj.
                    continue;
                }

                if (Obavijest::where('fb_post_id', $fbId)->exists()) {
                    continue;
                }

                $prvaLinija = trim(strtok($message, "\n"));
                $naslov = Str::limit($prvaLinija !== '' ? $prvaLinija : $message, 100);

                $slikaPath = null;
                if (!empty($post['full_picture'])) {
                    $slikaPath = $this->preuzmiSliku($post['full_picture'], $fbId);
                }

                $obavijest = Obavijest::create([
                    'moderator_id' => $moderator->id,
                    'fb_post_id' => $fbId,
                    'naslov' => $naslov,
                    'sadrzaj' => $message,
                    'tip' => 'info',
                    'slika' => $slikaPath,
                    'javno' => true,
                ]);

                // created_at/updated_at nisu u $fillable (mass-assignment zastita), pa se
                // datum objave sa Facebooka postavlja posebno preko forceFill().
                if (!empty($post['created_time'])) {
                    $obavijest->forceFill([
                        'created_at' => Carbon::parse($post['created_time']),
                    ])->save();
                }

                $created++;
            } catch (\Throwable $e) {
                Log::channel('daily')->error('[FacebookSync] Greska pri obradi objave ' . ($post['id'] ?? '?') . ': ' . $e->getMessage());
                continue;
            }
        }

        $message = "Facebook sinhronizacija zavrsena. Novih obavijesti: {$created}";
        $this->info($message);
        Log::channel('daily')->info('[FacebookSync] ' . $message);

        return self::SUCCESS;
    }

    private function preuzmiSliku(string $url, string $fbId): ?string
    {
        try {
            $imgResponse = Http::timeout(20)->get($url);

            if (!$imgResponse->successful()) {
                return null;
            }

            $filename = 'fb_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $fbId) . '.jpg';
            $destination = public_path('images/obavijesti/' . $filename);

            if (!is_dir(dirname($destination))) {
                mkdir(dirname($destination), 0755, true);
            }

            file_put_contents($destination, $imgResponse->body());

            return $filename;
        } catch (\Throwable $e) {
            Log::channel('daily')->warning('[FacebookSync] Neuspjelo preuzimanje slike za ' . $fbId . ': ' . $e->getMessage());
            return null;
        }
    }
}
