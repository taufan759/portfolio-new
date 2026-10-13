<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Privacy-friendly visit log: no IP address and no cookie. "visitor" is a daily salted hash.
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);
            $table->string('locale', 2)->nullable();
            $table->string('visitor', 64);
            $table->string('referrer', 120)->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->index('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
