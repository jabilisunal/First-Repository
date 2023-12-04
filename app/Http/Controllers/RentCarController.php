<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\RentCar;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;

class RentCarController extends Controller
{
    /**
     * @param Request $request
     * @param string $locale
     * @return Factory|View|Application
     */
    public function index(Request $request, string $locale): Factory|View|Application
    {
        /**
         * @var Facility $facilities
         */
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
            ->categoryFind(Category::RENT_CAR)
            ->paginate($request->input('per_page', 10));

        return view('pages.rent-cars.index', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'rents' => $rents,
            'facilities' => $facilities,
            'page' => $request->input('per_page', 10)
        ]);
    }

    /**
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function show(string $locale, string $slug): Factory|View|Application
    {
        $rent = RentCar::where(['category_id' => Category::RENT_CAR, 'slug' => $slug, 'status' => 1])->first();

        abort_if(!$rent, Response::HTTP_NOT_FOUND);

        $relatedRentCars = Place::where([
            'category_id' => Category::RENT_CAR,
            'destination_id' => $rent->destination_id,
            'status' => 1
        ])
            ->where('id', '!=', $rent->id)
            ->limit(10)
            ->get();

        return view('pages.rent-cars.show', [
            'rent' => $rent,
            'relatedRentCars' => $relatedRentCars
        ]);
    }
}
