<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_info_field')->insert(
            [
                [
                    'shortname' => 'vk_username',
                    'name' => 'vk account',
                    'data_type' => 'text',
                ],
                [
                    'shortname' => 'telegram_username',
                    'name' => 'telegram account',
                    'data_type' => 'text',
                ]
            ]
        );
    }
}
