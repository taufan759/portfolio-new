<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A project can belong to more than one category (for example web development and AI integration).
        // "category" stays the primary one; "categories" lists all of them.
        Schema::table('projects', function (Blueprint $table) {
            $table->json('categories')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('projects', fn (Blueprint $t) => $t->dropColumn('categories'));
    }
};
