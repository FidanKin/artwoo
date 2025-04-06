<?php

/**
 * Таблица кастомных полей пользователя, т.е. это дополнительные поля, которыми можно управлять
 * Поле может быть как обязательно задано, так и не необязательно
 * Примеры полей: логины в других социальных сетях, различный статус пользователя, инфомрация об образовании и т.п.
 */

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
        Schema::create('user_info_field', function (Blueprint $table) {
            $table->id();
            $table->string('shortname')
                ->comment('unique name')
                ->unique();
            $table->string('name')
                ->comment('field visible name')
                ->nullable();
            $table->string('data_type')
                ->comment('Type of data held in this field');
            $table->text('description')
                ->nullable();
            $table->boolean('required')
                ->default(0)
                ->comment('Field required');
            $table->boolean('locked')
                ->default(0)
                ->comment('Field locked; Is user can set value to the fields');
            $table->boolean('active')
                ->default(1)
                ->comment('can we use this field in system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_info_field');
    }
};
