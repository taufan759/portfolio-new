<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

/**
 * Starting list of workplaces and collaborations (the logo slider on the home page).
 * firstOrCreate on the name, so running it again never overwrites edits made in admin.
 */
class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // [name, kind, role (en), role (id), logo slug]   kind: work = workplace, collab = collaboration / client / program / school
        $partners = [
            ['Lunaray Beauty Factory', 'work', 'Software Engineer', 'Software Engineer', 'lunaray-beauty-factory'],
            ['Dermond', 'collab', null, null, 'dermond'],
            ['Beautylatory', 'collab', null, null, 'beautylatory'],
            ['Cantik AI', 'collab', null, null, 'cantik-ai'],
            ['Labcos', 'collab', null, null, 'labcos'],
            ['Universitas Padjadjaran', 'collab', null, null, 'universitas-padjadjaran'],
            ['Farmasi UNPAD', 'collab', null, null, 'farmasi-unpad'],
            ['Universitas Bina Sarana Informatika', 'collab', null, null, 'bsi'],
            ['GreatEdu', 'collab', null, null, 'greatedu'],
            ['DBS Foundation', 'collab', null, null, 'dbs-foundation'],
            ['Dicoding Indonesia', 'collab', null, null, 'dicoding'],
            ['MiemieBrownie', 'collab', null, null, 'miemiebrownie'],
            ['Adaptable Consulting', 'collab', null, null, 'adaptable-consulting'],
            ['Kementerian Agama', 'collab', null, null, 'kemenag'],
            ['Pemkab Timor Tengah Utara', 'collab', null, null, 'pemkab-timor-tengah-utara'],
        ];

        foreach ($partners as $i => [$name, $kind, $role, $roleId, $logo]) {
            Partner::firstOrCreate(['name' => $name], [
                'kind' => $kind,
                'role' => $role,
                'role_id' => $roleId,
                'logo' => $logo ? "images/partners/{$logo}.webp" : null,
                'sort' => $i,
                'is_published' => true,
            ]);
        }
    }
}
