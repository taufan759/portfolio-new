<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ContentSeeder::class);
        $this->call(ProjectShowcaseSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostTranslationSeeder::class);
    }
}
