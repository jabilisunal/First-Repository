<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Feature;
use App\Models\Partner;
use App\Models\Place;
use App\Models\Post;
use App\Models\Product;
use App\Models\BannerType;
use App\Models\RegionGroup;
use App\Models\RentCar;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use function Clue\StreamFilter\fun;

class HomeController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): View|Factory|Application
    {

        $features = Feature::with(['files'])
            ->where(['status' => 1])
            ->orderByDesc('sort')
            ->get();

        $sliderBanner = Banner::with(['files'])
            ->where(['type_id' => BannerType::SLIDER, 'status' => 1])
            ->orderByDesc('sort')
            ->first();

        $sliderBottomBanners = Banner::with(['files'])
            ->where(['type_id' => BannerType::SLIDER_BOTTOM, 'status' => 1])
            ->orderByDesc('sort')
            ->limit(4)
            ->get();

        $specialOfferBanner = Banner::with(['files'])
            ->where(['type_id' => BannerType::SPECIAL_OFFER, 'status' => 1])
            ->orderByDesc('sort')
            ->first();

        $newsLetterBanner = Banner::with(['files'])
            ->where(['type_id' => BannerType::NEWS_LETTER, 'status' => 1])
            ->orderByDesc('sort')
            ->first();

        $travelTipsBanner = Banner::with(['files'])
            ->where(['type_id' => BannerType::TRAVEL_TIPS, 'status' => 1])
            ->orderByDesc('sort')
            ->first();

        $partners = Partner::with(['files'])
            ->where(['status' => 1])
            ->orderByDesc('sort')
            ->get();

        $categories = Category::where(['status' => 1])->get();

        /**
         * @var Post $cuffPost
         */
        $cuffPost = Post::with(['files'])
            ->where(['status' => 1])
            ->orderByDesc('sort')
            ->first();

        $posts = Post::with(['files'])
            ->where(['status' => 1])
            ->when($cuffPost, function ($query) use ($cuffPost) {
                $query->where('id', '!=', $cuffPost->id);
            })
            ->orderByDesc('sort')
            ->limit(3)
            ->get();

        $regionGroupIds = [];
        $destinationIds = [];
        $categoryDestinations = [];
        $categoryRegionGroups = [];

        foreach ($categories as $category) {

            if (in_array($category->id, [
                Category::HOTEl,
                Category::APARTMENT,
                Category::RESTAURANT
            ])) {
                //    $destinationIds[$category->slug] = array_unique(
                //        (Place::where(['category_id' => $category->id, 'status' => 1])->get())
                //            ->pluck('destination_id')
                //            ->toArray()
                //    );
                //
                //    $categoryDestinations[$category->slug] = Destination::where(['status' => 1])
                //        ->whereIn('id', $destinationIds[$category->slug])->get();

                $regionGroupIds[$category->slug] = array_unique(
                    (Place::where(['category_id' => $category->id, 'status' => 1])->get())
                        ->pluck('region_group_id')
                        ->toArray()
                );

                $categoryRegionGroups[$category->slug] = RegionGroup::where(['status' => 1])
                    ->whereIn('id', $regionGroupIds[$category->slug])->get();


            }

            if ($category->id === Category::TOUR) {
                //    $destinationIds[$category->slug] = array_unique(
                //        (Tour::where(['category_id' => $category->id, 'status' => 1])->get())
                //            ->pluck('destination_id')
                //            ->toArray()
                //    );
                //
                //    $categoryDestinations[$category->slug] = Destination::where(['status' => 1])
                //        ->whereIn('id', $destinationIds[$category->slug])->get();

                $regionGroupIds[$category->slug] = array_unique(
                    (Tour::where(['category_id' => $category->id, 'status' => 1])->get())
                        ->pluck('region_group_id')
                        ->toArray()
                );

                $categoryRegionGroups[$category->slug] = RegionGroup::where(['status' => 1])
                    ->whereIn('id', $regionGroupIds[$category->slug])->get();
            }

            if ($category->id === Category::RENT_CAR) {
                //    $destinationIds[$category->slug] = array_unique(
                //        (RentCar::where(['category_id' => $category->id, 'status' => 1])->get())
                //            ->pluck('destination_id')
                //            ->toArray()
                //    );
                //
                //    $categoryDestinations[$category->slug] = Destination::where(['status' => 1])
                //        ->whereIn('id', $destinationIds[$category->slug])->get();

                $regionGroupIds[$category->slug] = array_unique(
                    (RentCar::where(['category_id' => $category->id, 'status' => 1])->get())
                        ->pluck('region_group_id')
                        ->toArray()
                );

                $categoryRegionGroups[$category->slug] = RegionGroup::where(['status' => 1])
                    ->whereIn('id', $regionGroupIds[$category->slug])->get();
            }
        }

        $popularHotels = Place::with([
            'category',
            'address',
            'destination',
            'reviews',
            'tags',
            'facilities'
        ])
            ->where([
                'category_id' => Category::HOTEl,
                'status' => 1,
                'is_popular' => 1
            ])
            ->limit(8)
            ->get();


        $popularTours = Tour::with([
            'category',
            'address',
            'destination',
            'reviews',
            'tags',
            'facilities'
        ])
            ->where([
                'category_id' => Category::TOUR,
                'status' => 1,
                'is_popular' => 1
            ])
            ->limit(8)
            ->get();

        return view('pages.home.index', [
            'posts' => $posts,
            'partners' => $partners,
            'cuffPost' => $cuffPost,
            'features' => $features,
            'categories' => $categories,
            'sliderBanner' => $sliderBanner,
            'sliderBottomBanners' => $sliderBottomBanners,
            'specialOfferBanner' => $specialOfferBanner,
            'newsLetterBanner' => $newsLetterBanner,
            'travelTipsBanner' => $travelTipsBanner,
            'popularHotels' => $popularHotels,
            'popularTours' => $popularTours,
            'categoryDestinations' => $categoryDestinations,
            'categoryRegionGroups' => $categoryRegionGroups,
        ]);
    }
}
