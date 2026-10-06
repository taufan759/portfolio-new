<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// English columns stay the main content; *_id columns hold the Indonesian translation.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('description_id')->nullable()->after('description');
            $table->longText('details')->nullable()->after('description_id');
            $table->longText('details_id')->nullable()->after('details');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_id')->nullable()->after('title');
            $table->text('excerpt_id')->nullable()->after('excerpt');
            $table->longText('body_id')->nullable()->after('body');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->text('notes_id')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('projects', fn (Blueprint $t) => $t->dropColumn(['description_id', 'details', 'details_id']));
        Schema::table('posts', fn (Blueprint $t) => $t->dropColumn(['title_id', 'excerpt_id', 'body_id']));
        Schema::table('books', fn (Blueprint $t) => $t->dropColumn('notes_id'));
    }
};
