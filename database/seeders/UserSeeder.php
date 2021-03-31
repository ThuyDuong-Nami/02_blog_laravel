<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'username' => 'user01',
//            'email'    => 'h2tbff@gmail.com',
//            'password' => bcrypt('123456'),
//        ]);
        User::factory()->count(3)->create();
    }
}
