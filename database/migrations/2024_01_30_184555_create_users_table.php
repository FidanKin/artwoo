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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role')->nullable(false);
            $table->string('login', 255)->unique();
            $table->string('email', 255)->unique();
            // пока номер телефона не используем, делаем null, но пусть остается
            $table->string('phone', 20)->nullable()->unique();
            $table->string('password', 255);
            $table->boolean('policyagreed')->default(0);
            $table->date('birthday')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('creativity_type', 52)->nullable();
            $table->boolean('freelance')->default(0);
            $table->text('about', 100)->nullable();
            $table->string('status', 42);
            $table->string('auth', 60);
            $table->boolean('show_socials')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // добавляем связи
        Schema::table('users', function(Blueprint $table) {
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
