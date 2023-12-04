<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Menu;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\Storefront\MenuResource;
use App\Http\Resources\Storefront\CategoryResource;
use Mockery\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        Paginator::defaultSimpleView('vendor.pagination.bootstrap-4');

        Schema::defaultStringLength(191);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }

        try {
            View::share('current_language', Language::where(['code' => $_SESSION['locale'] ?? 'az'])->first());
        } catch (Exception $exception) {
            View::share('current_language', collect([
                'code' => 'az'
            ]));
        }

        try {
            View::share('languages', Language::where(['status' => 1])->get());
        } catch (Exception $exception) {
            View::share('languages', []);
        }

        try {
            View::share('currencies', Currency::where(['status' => 1])->get());
        } catch (Exception $exception) {
            View::share('currencies', []);
        }

        try {
            View::share('top_menus', MenuResource::collection(Menu::where(['menu_type_id' => 1])->orderBy('sort', 'ASC')->get()->nest()));
        } catch (Exception $exception) {
            View::share('top_menus', []);
        }

        try {
            View::share('bottom_menus', MenuResource::collection(Menu::where(['menu_type_id' => 2])->get()->nest()));
        } catch (Exception $exception) {
            View::share('bottom_menus', []);
        }

        try {
            View::share('parent_categories', CategoryResource::collection(Category::where(['status' => 1])->whereNull('parent_id')->get()->nest()));
        } catch (Exception $exception) {
            View::share('parent_categories', []);
        }

        try {
            View::share('categories', CategoryResource::collection(Category::where(['status' => 1])->get()->nest()) ?? []);
        } catch (Exception $exception) {
            View::share('categories', []);
        }

    }
}
