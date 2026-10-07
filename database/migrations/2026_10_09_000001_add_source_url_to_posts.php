<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Posts imported from elsewhere (e.g. Medium) keep a link to the original,
        // and an article may exist in one language only, so the English title is optional.
        Schema::table('posts', function (Blueprint $table) {
            $table->string('source_url')->nullable()->after('cover')->index();
            $table->string('title')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('source_url');
            $table->string('title')->nullable(false)->change();
        });
    }
};
