<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Facility;
use App\Models\Place;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApartmentController extends Controller
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
            ->categoryFind(Category::APARTMENT)
            ->paginate($request->input('per_page', 10));

        return view('pages.apartments.index', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'places' => $places,
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
        $apartment = Place::where(['category_id' => Category::APARTMENT, 'slug' => $slug, 'status' => 1])->first();

        abort_if(!$apartment, Response::HTTP_NOT_FOUND);

        $relatedApartments = Place::where([
            'category_id' => Category::APARTMENT,
            'destination_id' => $apartment->destination_id,
            'status' => 1
        ])
            ->where('id', '!=', $apartment->id)
            ->limit(10)
            ->get();

        return view('pages.apartments.show', [
            'apartment' => $apartment,
            'relatedApartments' => $relatedApartments
        ]);
    }
}
