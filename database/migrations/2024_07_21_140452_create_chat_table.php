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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable()->default(null);
            // тип чата: приватный или комната
            // private - это общение двух пользователей
            // group - общение двух и более пользователей (группа)
            $table->string('type', 120)->default("private");
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('admin_id')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign("admin_id")->references("id")->on("users")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
