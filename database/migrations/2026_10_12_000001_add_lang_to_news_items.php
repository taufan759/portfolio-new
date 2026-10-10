<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Each headline belongs to one language version of the site. Existing rows come from Indonesian sources.
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('lang', 2)->default('id')->after('source')->index();
        });
    }

    public function down(): void
    {
        Schema::table('news_items', fn (Blueprint $t) => $t->dropColumn('lang'));
    }
};
