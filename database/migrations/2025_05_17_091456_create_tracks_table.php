<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->foreignId('genre_id')
                ->nullable()
                ->constrained('genres')
                ->onDelete('set null');
            $table->string('file_path');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_public')->default(true);
            $table->unsignedBigInteger('plays')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
