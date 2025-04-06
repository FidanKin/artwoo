<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Source\Entity\Reference\Models\Folder;
use Source\Entity\Reference\Models\Reference;

class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Folder::factory()->count(10)->has(Reference::factory()->count(40))->create();
    }
}
