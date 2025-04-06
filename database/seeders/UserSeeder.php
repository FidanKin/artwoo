<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Source\Entity\User\Models\CreativityType;
use Source\Entity\User\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'email' => 'monolog@email.ru',
            'login' => 'monolog',
            'birthday' => '1999-12-31',
            'password' => Hash::make('monolog111'),
            'policyagreed' => 1,
            'role' => 3,
            'creativity_type' => CreativityType::CREATIVITY_DEFAULT,
            'auth' => 'manual',
            'status' => 'draft',
        ],
        [
            'email' => 'monolog2@email.ru',
            'login' => 'monolog2',
            'birthday' => '2000-12-31',
            'password' => Hash::make('monolog222'),
            'policyagreed' => 1,
            'role' => 3,
            'creativity_type' => CreativityType::CREATIVITY_DEFAULT,
            'auth' => 'manual',
            'status' => 'draft',
        ],
        [
            'email' => 'admin@admin.ru',
            'login' => 'admin',
            'birthday' => '2000-12-31',
            'password' => Hash::make('admin111'),
            'policyagreed' => 1,
            'role' => 1,
            'creativity_type' => CreativityType::CREATIVITY_DEFAULT,
            'auth' => 'manual',
            'status' => 'draft',
        ]
        ]);

        User::factory()->count(60)->create();
    }
}
