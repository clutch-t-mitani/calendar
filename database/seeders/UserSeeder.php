<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('users')->insert([
        //     [
        //         'name' => 'manager',
        //         'email' => 'manager@example.com',
        //         'email_verified_at' => now(),
        //         'password' => \Hash::make('manager'),
        //         'role' => 5,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],[
        //         'name' => 'test',
        //         'email' => 'test@example.com',
        //         'email_verified_at' => now(),
        //         'password' => \Hash::make('test'),
        //         'role' => 9,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],[
        //         'name' => 'test2',
        //         'email' => 'test2@example.com',
        //         'email_verified_at' => now(),
        //         'password' => \Hash::make('test2'),
        //         'role' => 9,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]
        // ]);
        User::factory()->count(1)->create();
    }
}
