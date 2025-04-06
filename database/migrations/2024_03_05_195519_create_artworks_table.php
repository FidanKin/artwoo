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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description');
            $table->string('category', 32);
            $table->string('topic', 32);
            $table->smallInteger('width', false, true);
            $table->smallInteger('height', false, true);
            $table->smallInteger('depth', false, true)->nullable();
            $table->integer('price')->default(0)->nullable();
            $table->smallInteger('created_year')->nullable();
            $table->string('status', 42)->default(\Source\Entity\Artwork\Dictionaries\ArtworkStatus::DRAFT->value);
            $table->timestamps();
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
