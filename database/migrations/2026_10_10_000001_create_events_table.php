<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Events, expos and talks taken part in (shown on the About page).
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_id')->nullable();
            $table->string('organizer')->nullable();
            $table->string('location')->nullable();
            $table->string('role')->nullable();
            $table->string('role_id')->nullable();
            $table->text('description')->nullable();
            $table->text('description_id')->nullable();
            $table->date('held_at')->nullable();
            $table->unsignedSmallInteger('year')->nullable()->index();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
