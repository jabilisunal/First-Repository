<?php

namespace App\Http\Controllers;

use App\Models\RegionGroup;
use App\Models\Tour;
use App\Models\Place;
use App\Models\RentCar;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;

class DestinationController extends Controller
{
    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function hotels(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $regionGroup = RegionGroup::where(['slug' => $slug])->first();

        abort_if(!$regionGroup, Response::HTTP_NOT_FOUND);

        $facilities = Facility::where(['type' => Facility::HOTEl, 'status' => 1])->get();

        /**
         * @var Place $places
         */
        $places = Place::query()
            ->with([
                'category',
                'destination',
                'reviews',
                'facilities',
                'tags',
                'address',
            ])
            ->titleSearch($request->input('title'))
            ->betweenPrice([
                $request->input('min_price'),
                $request->input('max_price')
            ])
            ->filterFacilities($request->input('facilities', []))
            ->regionGroupFind($regionGroup->id)
            ->categoryFind(Category::HOTEl)
            ->paginate($request->input('per_page', 10));

        return view('pages.destinations.hotels', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'places' => $places,
            'regionGroup' => $regionGroup,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function apartments(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $regionGroup = RegionGroup::where(['slug' => $slug])->first();

        abort_if(!$regionGroup, Response::HTTP_NOT_FOUND);

        $facilities = Facility::where(['type' => Facility::APARTMENT, 'status' => 1])->get();

        /**
         * @var Place $places
         */
        $places = Place::query()
            ->with([
                'category',
                'destination',
                'reviews',
                'facilities',
                'tags',
                'address',
            ])
            ->titleSearch($request->input('title'))
            ->betweenPrice([
                $request->input('min_price'),
                $request->input('max_price')
            ])
            ->filterFacilities($request->input('facilities', []))
            ->regionGroupFind($regionGroup->id)
            ->categoryFind(Category::APARTMENT)
            ->paginate($request->input('per_page', 10));

        return view('pages.destinations.apartments', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'places' => $places,
            'regionGroup' => $regionGroup,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function restaurants(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $regionGroup = RegionGroup::where(['slug' => $slug])->first();

        abort_if(!$regionGroup, Response::HTTP_NOT_FOUND);

        $facilities = Facility::where(['type' => Facility::RESTAURANT, 'status' => 1])->get();

        /**
         * @var Place $places
         */
        $places = Place::query()
            ->with([
                'category',
                'destination',
                'reviews',
                'facilities',
                'tags',
                'address',
            ])
            ->titleSearch($request->input('title'))
            ->betweenPrice([
                $request->input('min_price'),
                $request->input('max_price')
            ])
            ->filterFacilities($request->input('facilities', []))
            ->regionGroupFind($regionGroup->id)
            ->categoryFind(Category::RESTAURANT)
            ->paginate($request->input('per_page', 10));

        return view('pages.destinations.restaurants', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'places' => $places,
            'regionGroup' => $regionGroup,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function tours(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $regionGroup = RegionGroup::where(['slug' => $slug])->first();

        abort_if(!$regionGroup, Response::HTTP_NOT_FOUND);

        $facilities = Facility::where(['type' => Facility::TOUR, 'status' => 1])->get();

        /**
         * @var Tour $tours
         */
        $tours = Tour::query()
            ->with([
                'category',
                'destination',
                'reviews',
                'facilities',
                'tags',
                'address',
            ])
            ->titleSearch($request->input('title'))
            ->betweenPrice([
                $request->input('min_price'),
                $request->input('max_price')
            ])
            ->filterFacilities($request->input('facilities', []))
            ->regionGroupFind($regionGroup->id)
            ->categoryFind(Category::TOUR)
            ->paginate($request->input('per_page', 10));

        return view('pages.destinations.tours', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'tours' => $tours,
            'regionGroup' => $regionGroup,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function rentCars(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $regionGroup = RegionGroup::where(['slug' => $slug])->first();

        abort_if(!$regionGroup, Response::HTTP_NOT_FOUND);

        $facilities = Facility::where(['type' => Facility::RENT_CAR, 'status' => 1])->get();

        /**
         * @var RentCar $rents
         */
        $rents = RentCar::query()
            ->with([
                'brand',
                'category',
                'destination',
                'facilities',
                'tags',
                'address',
            ])
            ->titleSearch($request->input('title'))
            ->betweenPrice([
                $request->input('min_price'),
                $request->input('max_price')
            ])
            ->filterFacilities($request->input('facilities', []))
            ->regionGroupFind($regionGroup->id)
            ->categoryFind(Category::RENT_CAR)
            ->paginate($request->input('per_page', 10));

        return view('pages.destinations.rent-cars', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'rents' => $rents,
            'regionGroup' => $regionGroup,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }
}
