<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use RuntimeException;
use Throwable;

/**
 * Obrada profilne slike, ista kao MemberPortalController::updatePhoto():
 * ispravljena orijentacija, 600x600, JPG, najvise 1 MB, ime member_{id}_{time}.jpg
 * u public/images.
 */
class ProfilePhotoService
{
    private const MAX_FILE_SIZE = 1048576;

    /**
     * @throws RuntimeException sa porukom za korisnika
     */
    public function store(Member $member, UploadedFile $file): string
    {
        if (!function_exists('finfo_open') || !function_exists('finfo_buffer')) {
            Log::error('ProfilePhotoService - fileinfo ekstenzija nije dostupna na serveru.');
            throw new RuntimeException('Server nema omogućenu PHP fileinfo ekstenziju. Kontaktirajte administratora.');
        }

        $path = public_path('images');
        if (!is_dir($path) && !mkdir($path, 0755, true)) {
            Log::error('ProfilePhotoService - ne mogu kreirati direktorij: ' . $path);
            throw new RuntimeException('Direktorij za slike nije dostupan. Kontaktirajte administratora.');
        }

        $filename = 'member_' . $member->id . '_' . time() . '.jpg';
        $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

        try {
            $img = Image::make($file->getRealPath())->orientate();
            $img->fit(600, 600, function ($constraint) {
                $constraint->upsize();
            });

            $quality = 90;
            $img->save($fullPath, $quality, 'jpg');
            @chmod($fullPath, 0644);

            while (file_exists($fullPath) && filesize($fullPath) > self::MAX_FILE_SIZE && $quality > 45) {
                $quality -= 10;
                $img->save($fullPath, $quality, 'jpg');
            }

            while (file_exists($fullPath) && filesize($fullPath) > self::MAX_FILE_SIZE && $img->width() > 220) {
                $img->resize((int) round($img->width() * 0.85), (int) round($img->height() * 0.85));
                $img->save($fullPath, $quality, 'jpg');
            }
        } catch (Throwable $e) {
            Log::error('ProfilePhotoService - greška pri obradi slike: ' . $e->getMessage());
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
            throw new RuntimeException('Greška pri obradi slike.');
        }

        if (!file_exists($fullPath) || filesize($fullPath) === 0) {
            throw new RuntimeException('Slika nije mogla biti sačuvana na serveru. Kontaktirajte administratora.');
        }

        if (filesize($fullPath) > self::MAX_FILE_SIZE) {
            @unlink($fullPath);
            throw new RuntimeException('Slika nije mogla biti umanjena ispod 1 MB. Odaberite manju sliku.');
        }

        $member->image_path = $filename;
        $member->save();

        return $filename;
    }
}
