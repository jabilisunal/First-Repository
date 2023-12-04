<?php

namespace Database\Seeders;

use App\Models\BannerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        BannerType::truncate();

        $bannerTypes = [
            [
                'name' => 'Slider (1920x800)'
            ],
            [
                'name' => 'Slider Bottom (330x450)'
            ],
            [
                'name' => 'Special Offers (690x530)'
            ],
            [
                'name' => 'News letter (330x530)'
            ],
            [
                'name' => 'Travel tips (330x530)'
            ]
        ];

        BannerType::insert($bannerTypes);
    }
}
