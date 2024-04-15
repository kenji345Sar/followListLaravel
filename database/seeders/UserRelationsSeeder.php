<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // この行が非常に重要です

class UserRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('user_relations')->insert([
            ['user_id' => 10, 'target_user_id' => 11, 'is_blocking' => 0],
            ['user_id' => 12, 'target_user_id' => 10, 'is_blocking' => 0],
            ['user_id' => 10, 'target_user_id' => 13, 'is_blocking' => 0],
            ['user_id' => 13, 'target_user_id' => 10, 'is_blocking' => 0],
            ['user_id' => 10, 'target_user_id' => 14, 'is_blocking' => 1],
            ['user_id' => 15, 'target_user_id' => 10, 'is_blocking' => 1],
            ['user_id' => 10, 'target_user_id' => 16, 'is_blocking' => 1],
            ['user_id' => 16, 'target_user_id' => 10, 'is_blocking' => 1],
            ['user_id' => 10, 'target_user_id' => 17, 'is_blocking' => 0],
            ['user_id' => 17, 'target_user_id' => 10, 'is_blocking' => 1],
            ['user_id' => 10, 'target_user_id' => 18, 'is_blocking' => 1],
            ['user_id' => 18, 'target_user_id' => 10, 'is_blocking' => 0],
        ]);
    }
}
