<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Таблица модерации контента
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_moderation', function (Blueprint $table) {
            $table->id();
            $table->string('component', 100); // название компонента
            $table->unsignedBigInteger('object_id'); // id задействованной таблицы
            $table->unsignedBigInteger('target_user'); // id пользователя, над которым совершаем действие
            $table->unsignedBigInteger('moderator')->nullable(); // id пользователя модератора
            $table->text('other'); // какая - то техническая информация (может быть json объекта)
            $table->text('comment'); // комментарий
            $table->timestamps();
        });

        Schema::table('content_moderation', function (Blueprint $table) {
            $table->foreign('moderator')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_moderation');
    }
};
