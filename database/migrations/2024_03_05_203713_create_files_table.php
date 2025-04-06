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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('contenthash', 40);
            $table->string('pathnamehash', 64)->comment('file id for get it');
            $table->string('component', config('app.artwoo.component.max_name_length'));
            $table->string('filearea', 50);
            $table->integer('item_id')->nullable()->comment('object id from component model (store)');
            $table->string('filename', 255);
            $table->bigInteger('filesize');
            $table->string('mimetype', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('author', 255)->nullable();
            $table->string('status', 32)->comment('file status, in this field, we determine if
                everything is fine with the file, file can be worst, so we can mark it.
                 Statuses: ok, reject, moderation, unverified');
            $table->smallInteger('sort_order')->default(0)->comment('if we have few files for one instance of component
                we can determine sort order for files which will display in view');
            $table->timestamps();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->unique('pathnamehash');
            $table->index(['user_id', 'component', 'item_id', 'contenthash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
