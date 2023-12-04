<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\File;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Slider Banner Seed
        $sliderBanners = Banner::factory()->count(1)->create(['type_id' => 1])->toArray();

        foreach ($sliderBanners as $sliderBanner) {

            $file = File::factory()->count(1)->create();

            $updateBanner = Banner::findOrFail($sliderBanner['id']);

            $updateBanner->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }

        // Slider Bottom Banner Seed
        $sliderBottomBanners = Banner::factory()->count(4)->create(['type_id' => 2])->toArray();

        foreach ($sliderBottomBanners as $sliderBottomBanner) {

            $file = File::factory()->count(1)->create();

            $updateBanner = Banner::findOrFail($sliderBottomBanner['id']);

            $updateBanner->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }


        // Special Offer Banner Seed
        $specialOffersBanners = Banner::factory()->count(1)->create(['type_id' => 3])->toArray();

        foreach ($specialOffersBanners as $specialOffersBanner) {

            $file = File::factory()->count(1)->create();

            $updateBanner = Banner::findOrFail($specialOffersBanner['id']);

            $updateBanner->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }

        // News Letter Banner Seed
        $newsLetterBanners = Banner::factory()->count(1)->create(['type_id' => 4])->toArray();

        foreach ($newsLetterBanners as $newsLetterBanner) {

            $file = File::factory()->count(1)->create();

            $updateBanner = Banner::findOrFail($newsLetterBanner['id']);

            $updateBanner->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }

        // Travel Tips Banner Seed
        $travelTipsBanners = Banner::factory()->count(1)->create(['type_id' => 5])->toArray();

        foreach ($travelTipsBanners as $travelTipsBanner) {

            $file = File::factory()->count(1)->create();

            $updateBanner = Banner::findOrFail($travelTipsBanner['id']);

            $updateBanner->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }
    }
}
