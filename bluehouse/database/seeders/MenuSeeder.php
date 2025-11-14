<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Menu::insert([
        [
            'name' => 'PORTUGAL 2',
            'description' => 'Paket untuk 1 orang',
            'price' => 28000,
            'image' => 'images/menu/portugal2.jpg'
        ],
        [
            'name' => 'PASUTRI 1',
            'description' => 'Paket Untuk 2 Orang',
            'price' => 52000,
            'image' => 'images/menu/pasutri1.jpg'
        ],
        [
            'name' => 'PORTUGAL 3',
            'description' => 'Paket 1 orang',
            'price' => 46000,
            'image' => 'images/menu/portugal3.jpg'
        ],
        [
            'name' => 'KELUARGA 1',
            'description' => 'Paket Untuk 4 Orang',
            'price' => 105000,
            'image' => 'images/menu/keluarga1.jpg'
        ],
    ]);
}

}
