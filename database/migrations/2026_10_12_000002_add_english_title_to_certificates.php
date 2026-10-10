<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Some certificates carry official Indonesian course names; the English pages show an English equivalent.
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
        });

        $names = [
            'Belajar Dasar AI' => 'Learn AI Fundamentals',
            'Front-End Web untuk Pemula' => 'Front-End Web Development for Beginners',
            'Dasar Git dengan GitHub' => 'Git Fundamentals with GitHub',
            'Data Science dengan Microsoft Fabric' => 'Data Science with Microsoft Fabric',
            'Gen AI dengan Microsoft Azure' => 'Generative AI with Microsoft Azure',
            'Pengembangan Web Intermediate' => 'Intermediate Web Development',
        ];

        foreach ($names as $id => $en) {
            DB::table('certificates')->where('title', $id)->update(['title_en' => $en]);
        }

        // Event organizers are proper names, shown as they are in both languages.
        DB::table('events')->where('organizer', 'Pertamina and Danantara')->update(['organizer' => 'Pertamina & Danantara']);
    }

    public function down(): void
    {
        Schema::table('certificates', fn (Blueprint $t) => $t->dropColumn('title_en'));
    }
};
