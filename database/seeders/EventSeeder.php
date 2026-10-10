<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

/**
 * Events taken part in. firstOrCreate on the title, so running it again never overwrites edits made in admin.
 * Add exact dates, photos and more events in admin (Events / Gallery).
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Cosmobeauty with Lunaray Beauty Factory',
                'title_id' => 'Cosmobeauty bersama Lunaray Beauty Factory',
                'organizer' => 'Lunaray Beauty Factory', 'location' => null, 'year' => 2026, 'sort' => 0,
                'role' => 'Representing the IT team', 'role_id' => 'Mewakili tim IT',
                'description' => 'Introduced Cantik.ai, a set of AI employees for experts (such as AI R&D and AI for brand experts), together with an AI-based skin analyzer and wellness tools.',
                'description_id' => 'Memperkenalkan Cantik.ai, kumpulan AI employee untuk para ahli (seperti AI R&D dan AI untuk brand expert), bersama skin analyzer berbasis AI dan alat wellness.',
            ],
            [
                'title' => 'Unpad Innovation Days 2026',
                'title_id' => 'Unpad Innovation Days 2026',
                'organizer' => 'Universitas Padjadjaran', 'location' => null, 'year' => 2026, 'sort' => 1,
                'role' => 'Part of the skincare booth', 'role_id' => 'Bagian dari booth skincare',
                'description' => 'Took part in the skincare booth together with the Faculty of Pharmacy, Universitas Padjadjaran.',
                'description_id' => 'Terlibat di booth skincare bersama Fakultas Farmasi Universitas Padjadjaran.',
            ],
            [
                'title' => 'ICI 2026 with LABCOS Unpad',
                'title_id' => 'ICI 2026 bersama LABCOS Unpad',
                'organizer' => 'LABCOS Universitas Padjadjaran', 'location' => 'JIExpo Kemayoran, Jakarta', 'year' => 2026, 'sort' => 2,
                'role' => 'Participant', 'role_id' => 'Peserta',
                'description' => 'Joined LABCOS Unpad at ICI 2026 at JIExpo Kemayoran.',
                'description_id' => 'Mengikuti ICI 2026 bersama LABCOS Unpad di JIExpo Kemayoran.',
            ],
            [
                'title' => 'Pertamina workshop with Danantara',
                'title_id' => 'Workshop Pertamina bersama Danantara',
                'organizer' => 'Pertamina & Danantara', 'location' => 'CX 100', 'year' => 2026, 'sort' => 3,
                'role' => 'Participant', 'role_id' => 'Peserta',
                'description' => 'Attended the Pertamina workshop together with Danantara at CX 100.',
                'description_id' => 'Mengikuti workshop Pertamina bersama Danantara di CX 100.',
            ],
        ];

        foreach ($events as $e) {
            Event::firstOrCreate(['title' => $e['title']], $e + ['is_published' => true]);
        }
    }
}
