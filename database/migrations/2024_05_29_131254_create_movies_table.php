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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('movie_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview');
            $table->string('cover');
            $table->string('release_date');
            $table->string('genre');
            $table->string('vote');
            $table->string('movie');
            $table->string('trailer');
            $table->integer('type');
            $table->integer('watched')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
