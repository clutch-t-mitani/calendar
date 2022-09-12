<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('menus')->insert([
            [
                'id' => 1,
                'name' => 'カット',
                'time' => '00:30:00',
                'price' => 2700,
                'information' => '1番シンプルなメニューです',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'カット＋シャンプー',
                'time' => '01:00:00',
                'price' => 3000,
                'information' => 'さっぱりしたい方にオススメ！',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'カット＋シェービング',
                'time' => '01:00:00',
                'price' => 3500,
                'information' => '床屋の醍醐味シェービングを体感してください',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'カット＋シャンプー＋シェービング',
                'time' => '01:30:00',
                'price' => 3800,
                'information' => 'おすすめです！最終セットでガチガチにします',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
