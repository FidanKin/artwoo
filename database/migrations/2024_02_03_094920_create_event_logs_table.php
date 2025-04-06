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
        Schema::create('event_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_name')
                ->comment('Full event class name');
            $table->string('component', 100)
                ->comment('some entity name or subsystem name ');
            $table->string('action', 100)
                ->comment('last word in class name');
            $table->string('object_table', 50)
                ->nullable()
                ->comment('Database table name which represents the event object to the best. Never use a
                relationship table here');
            $table->bigInteger('object_id', unsigned: true)
                ->nullable()
                ->comment('Id of the object record from object_table');
            $table->string('crud', 1)
                ->comment('One of [crud] letters - indicating create, read, update or delete operation');
            $table->unsignedBigInteger('user_id')
                ->comment('User ID, or 0 when not logged in, or -1 when other (System, CLI, Cron, ...)');
            $table->unsignedBigInteger('related_user_id')
                ->nullable()
                ->comment('Is this action related to some user? This could be used for some personal timeline view.');
            $table->longText('other')
                ->nullable()
                ->comment('Any other fields needed for event description - scalars or arrays, must be
                serialisable using json_encode(). Floating point numbers cannot be used');
            $table->string('ip', 45)
                ->nullable()
                ->comment('user ip addres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_logs');
    }
};
