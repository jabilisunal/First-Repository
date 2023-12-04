<?php

namespace Database\Seeders;

use App\Models\MenuType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        MenuType::truncate();

        $menuTypes = [
            [
                'title' => 'Top Menu'
            ],
            [
                'title' => 'Bottom Menu'
            ]
        ];

        MenuType::insert($menuTypes);
    }
}
