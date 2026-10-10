<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

/**
 * Event photos (public/images/gallery, WebP). firstOrCreate on the image path, so running it again never
 * overwrites captions or order edited in admin. Add more photos from Admin > Gallery.
 */
class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['cosmobeauty-1', 'Cosmobeauty with Lunaray', 'Cosmobeauty bersama Lunaray', null, 2026],
            ['cosmobeauty-2', 'Cosmobeauty with Lunaray', 'Cosmobeauty bersama Lunaray', null, 2026],
            ['ici-2026-1', 'ICI 2026 with LABCOS Unpad', 'ICI 2026 bersama LABCOS Unpad', 'JIExpo Kemayoran, Jakarta', 2026],
            ['ici-2026-2', 'ICI 2026 with LABCOS Unpad', 'ICI 2026 bersama LABCOS Unpad', 'JIExpo Kemayoran, Jakarta', 2026],
            ['ici-2026-3', 'ICI 2026 with LABCOS Unpad', 'ICI 2026 bersama LABCOS Unpad', 'JIExpo Kemayoran, Jakarta', 2026],
            ['pertamina-danantara-workshop', 'Pertamina workshop with Danantara', 'Workshop Pertamina bersama Danantara', 'CX 100', 2026],
            ['unpad-innovation-days', 'Unpad Innovation Days 2026', 'Unpad Innovation Days 2026', null, 2026],
            ['unpad-pharmacy', 'Skincare booth with Pharmacy Unpad', 'Booth skincare bersama Farmasi Unpad', null, 2026],
            ['programmer-ai-bandung', 'Programmer & AI community, Bandung', 'Komunitas Programmer & AI Bandung', 'Bandung', 2026],
        ];

        foreach ($photos as $i => [$file, $en, $id, $location, $year]) {
            GalleryItem::firstOrCreate(
                ['image' => "images/gallery/{$file}.webp"],
                ['title' => $en, 'title_id' => $id, 'location' => $location, 'taken_at' => "{$year}-01-01", 'sort' => $i, 'is_published' => true],
            );
        }
    }
}
