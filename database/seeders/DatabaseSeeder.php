<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'administrator',
            ],
            [
                'name' => 'owner'
            ],
            [
                'name' => 'instructor'
            ],
            [
                'name' => 'user'
            ],
        ]);

//        for($i=0;$i<5;$i++){
//            DB::table('announcements')->insert([
//                'user_id' => sprintf("%01d", mt_rand(1, 2)),
//                'title' => Str::random(10),
//                'description' => Str::random(10),
//                'status' => sprintf("%01d", mt_rand(1, 2)),
//                'created_at' => '2021-09-05 00:00:00',
//                'updated_at' => '2021-09-05 00:00:00'
//            ]);
//        }
    }
}
