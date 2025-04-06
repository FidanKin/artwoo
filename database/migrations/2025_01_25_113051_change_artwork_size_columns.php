<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Source\Entity\Artwork\Models\Artwork;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artworks_temporary', function (Blueprint $table) {
            $table->temporary();
            $table->integer('id')->unique();
            $table->text('size');
        });

        Artwork::query()->chunk(100, function($artworks) {
            foreach ($artworks as $artwork) {
                $size = [];
                $size['width'] = $artwork->width;
                $size['height'] = $artwork->height;
                $size['depth'] = $artwork->depth;
                $sizeJson = json_encode([$size]);
                DB::table('artworks_temporary')->insert(['id' => $artwork->id, 'size' => $sizeJson]);
            }
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('depth');
            $table->text('size')->after('topic');
            // количество составных частей. Если 1, значит работа не составная
            $table->tinyInteger('number_components', false, true)->after('size')
                ->default(1);
        });

        DB::table('artworks_temporary')->orderBy('id')->chunk(100, function($artworkSizes) {
            foreach ($artworkSizes as $artworkSize) {
                $a = Artwork::find($artworkSize->id);
                $a->fill(['size' => $artworkSize->size]);
                $a->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
