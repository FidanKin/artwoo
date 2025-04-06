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
        Schema::create('resume_workplaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resume_id');
            $table->text('organization_name');
            $table->string('position', 120)->nullable(false)->comment('Должность');
            $table->text('duties')->comment('Обязанности');
            $table->date('date_employment')->nullable();
            $table->date('date_dismissal')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('resume_workplaces', function (Blueprint $table) {
            $table->foreign('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_workplaces');
    }
};
