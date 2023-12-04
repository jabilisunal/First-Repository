<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Tour;
use App\Models\Facility;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;

class TourController extends Controller
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
            ->categoryFind(Category::TOUR)
            ->paginate($request->input('per_page', 10));

        return view('pages.tours.index', [
            'title' => $request->input('title'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'facilitiesArray' => $request->input('facilities', []),
            'tours' => $tours,
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
        $tour = Tour::where(['category_id' => Category::TOUR, 'slug' => $slug, 'status' => 1])->first();

        abort_if(!$tour, Response::HTTP_NOT_FOUND);

        $relatedTours = Tour::where([
            'category_id' => Category::TOUR,
            'destination_id' => $tour->destination_id,
            'status' => 1
        ])
            ->where('id', '!=', $tour->id)
            ->limit(10)
            ->get();

        return view('pages.tours.show', [
            'tour' => $tour,
            'relatedTours' => $relatedTours
        ]);
    }
}
