<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentCarController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static function () {
    return redirect($_SESSION['locale'] ?? 'az');
});

Route::get('/home', static function () {
    return redirect($_SESSION['locale'] ?? 'az');
});

Route::get('language/{locale}', static function ($locale) {
    app()->setLocale($locale);
    $_SESSION['locale'] = $locale;
    $getPath = getRedirectUrlRealPath();
    $url = url(implode("/", [$locale, $getPath]));
    return redirect()->to($url);
})->name('changeLocale');

Route::get('currency/{code}', static function ($code) {
    $_SESSION['currency'] = $code;
    return redirect()->route('home', [app()->getLocale()]);
})->name('changeCurrency');

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'setLocale'], static function() {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/faqs', [SharedController::class, 'faqs'])->name('faqs');
    Route::get('/contact', [SharedController::class, 'contact'])->name('contact');
    Route::get('/pages/{slug}', [SharedController::class, 'pages'])->name('pages');

    Route::post('/book-now', [SharedController::class, 'bookNow'])->name('bookNow');
    Route::post('/review', [SharedController::class, 'storeReview'])->name('storeReview');

    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news-show');

    Route::get('/destinations/{slug}/tours', [DestinationController::class, 'tours'])->name('tours');
    Route::get('/destinations/{slug}/hotels', [DestinationController::class, 'hotels'])->name('hotels');
    Route::get('/destinations/{slug}/rent-cars', [DestinationController::class, 'rentCars'])->name('rent-cars');
    Route::get('/destinations/{slug}/apartments', [DestinationController::class, 'apartments'])->name('apartments');
    Route::get('/destinations/{slug}/restaurants', [DestinationController::class, 'restaurants'])->name('restaurants');

    Route::get('/tours', [TourController::class, 'index'])->name('tours-all');
    Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours-show');

    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels-all');
    Route::get('/hotels/{slug}', [HotelController::class, 'show'])->name('hotels-show');

    Route::get('/rent-cars', [RentCarController::class, 'index'])->name('rent-cars-all');
    Route::get('/rent-cars/{slug}', [RentCarController::class, 'show'])->name('rent-cars-show');

    Route::get('/apartments', [ApartmentController::class, 'index'])->name('apartments-all');
    Route::get('/apartments/{slug}', [ApartmentController::class, 'show'])->name('apartments-show');

    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants-all');
    Route::get('/restaurants/{slug}', [RestaurantController::class, 'show'])->name('restaurants-show');
});

