<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Images
{
    /**
     * Store an uploaded image as a resized WebP file under public/images/uploads.
     * Returns the path relative to public/, e.g. images/uploads/abc.webp
     */
    public static function storeWebp(UploadedFile $file, int $maxWidth = 1400, int $quality = 78): string
    {
        $dir = public_path('images/uploads');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = Str::random(20);
        $source = match ($file->getMimeType()) {
            'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'image/png' => @imagecreatefrompng($file->getRealPath()),
            'image/webp' => @imagecreatefromwebp($file->getRealPath()),
            default => false,
        };

        if (! $source) {
            abort(422, 'Unsupported or corrupt image. Use JPG, PNG or WebP.');
        }

        $width = imagesx($source);
        if ($width > $maxWidth) {
            $source = imagescale($source, $maxWidth);
        }

        imagepalettetotruecolor($source);
        imagealphablending($source, true);
        imagesavealpha($source, true);
        imagewebp($source, "{$dir}/{$name}.webp", $quality);
        imagedestroy($source);

        return "images/uploads/{$name}.webp";
    }

    /**
     * Same as storeWebp() but from raw image bytes (used when importing remote images).
     * Returns the path relative to public/, or null when the data is not a usable image.
     */
    public static function storeWebpFromString(string $binary, int $maxWidth = 1400, int $quality = 78): ?string
    {
        $source = @imagecreatefromstring($binary);

        if (! $source) {
            return null;
        }

        $dir = public_path('images/uploads');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (imagesx($source) > $maxWidth) {
            $source = imagescale($source, $maxWidth);
        }

        imagepalettetotruecolor($source);
        imagealphablending($source, true);
        imagesavealpha($source, true);

        $name = Str::random(20);
        imagewebp($source, "{$dir}/{$name}.webp", $quality);
        imagedestroy($source);

        return "images/uploads/{$name}.webp";
    }
}
