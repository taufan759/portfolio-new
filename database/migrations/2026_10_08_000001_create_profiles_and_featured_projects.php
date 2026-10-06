<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One editable row with the personal copy. Empty fields fall back to the defaults in lang/*/site.php.
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('headline')->nullable();
            $table->string('headline_id')->nullable();
            $table->text('intro')->nullable();
            $table->text('intro_id')->nullable();
            $table->text('summary')->nullable();
            $table->text('summary_id')->nullable();
            $table->longText('story')->nullable();
            $table->longText('story_id')->nullable();
            $table->string('location')->nullable();
            $table->string('location_id')->nullable();
            $table->string('education')->nullable();
            $table->string('education_id')->nullable();
            $table->string('availability')->nullable();
            $table->string('availability_id')->nullable();
            $table->json('skills')->nullable();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_published')->index();
        });

        // Start with the first four projects featured on the home page.
        $ids = DB::table('projects')->orderBy('sort')->orderBy('id')->limit(4)->pluck('id');
        DB::table('projects')->whereIn('id', $ids)->update(['is_featured' => true]);
    }

    public function down(): void
    {
        Schema::table('projects', fn (Blueprint $t) => $t->dropColumn('is_featured'));
        Schema::dropIfExists('profiles');
    }
};
