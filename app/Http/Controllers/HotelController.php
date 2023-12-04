<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;

class HotelController extends Controller
{
    /**
     * @param Request $request
     * @param string $locale
     * @return Factory|View|Application
     */
    public function index(Request $request, string $locale): Factory|View|Application
    {
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
            ->categoryFind(Category::HOTEl)
            ->paginate($request->input('per_page', 10));

        return view('pages.hotels.index', [
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
        $hotel = Place::where(['category_id' => Category::HOTEl, 'slug' => $slug, 'status' => 1])->first();

        abort_if(!$hotel, Response::HTTP_NOT_FOUND);

        $relatedHotels = Place::where([
            'category_id' => Category::HOTEl,
            'destination_id' => $hotel->destination_id,
            'status' => 1
        ])
            ->where('id', '!=', $hotel->id)
            ->limit(10)
            ->get();

        return view('pages.hotels.show', [
            'hotel' => $hotel,
            'relatedHotels' => $relatedHotels
        ]);
    }
}
