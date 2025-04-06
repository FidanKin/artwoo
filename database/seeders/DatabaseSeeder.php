<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Source\Entity\Reference\Models\Reference;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
           UserSeeder::class,
           UserFieldsSeeder::class,
           Chat::class,
           ArtworkSeeder::class,
           ReferenceSeeder::class,
        ]);
    }
}
