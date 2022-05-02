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
        \DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('admin'),
                'admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'test',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('test'),
                'admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
