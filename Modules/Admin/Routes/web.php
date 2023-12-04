<?php

use Illuminate\Support\Facades\Route;

use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\User\RoleController;
use Modules\Admin\Http\Controllers\User\UserController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\User\PositionController;
use Modules\Admin\Http\Controllers\User\PermissionController;
use Modules\Admin\Http\Controllers\Settings\SettingController;

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

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');

Route::middleware('auth:admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::namespace('User')->as('user.')->prefix('user')->group(function () {

        // Users
        Route::resource('user', UserController::class);

        // Roles
        Route::resource('role', RoleController::class);

        // Positions
        Route::resource('position', PositionController::class);

        // Permissions
        Route::resource('permission', PermissionController::class);

        Route::post('role/update-permission', [RoleController::class, 'updateRolePermission'])
            ->name('role.update-permission');
    });

    Route::namespace('Ecommerce')->as('ecommerce.')->prefix('ecommerce')->group(function () {

        // Brand
        Route::resource('brand', 'BrandController');

        // Category
        Route::resource('category', 'CategoryController');

        // Tags
        Route::resource('tags', 'TagsController');

        // DestinationController
        Route::resource('destinations', 'DestinationController');

        // FacilityController
        Route::resource('facilities', 'FacilityController');

        // PlaceController
        Route::resource('places', 'PlaceController');

        // TourController
        Route::resource('tours', 'TourController');

        // RentController
        Route::resource('rents', 'RentController');

        // RegionGroupController
        Route::resource('region-groups', 'RegionGroupController');
    });


    Route::namespace('Warehouse')->as('warehouse.')->prefix('warehouse')->group(function () {

        Route::resource('offices', 'OfficeController');
    });


    Route::namespace('Content')->as('content.')->prefix('content')->group(function () {

        // Partners
        Route::resource('partner', 'PartnerController');

        // Banners
        Route::resource('banner', 'BannerController');

        // Banner Types
        Route::resource('banner-type', 'BannerTypeController');

        // Menu
        Route::resource('menu', 'MenuController');

        // Menu Types
        Route::resource('menu-type', 'MenuTypeController');

        // Feature
        Route::resource('features', 'FeaturesController');

        // Faqs
        Route::resource('faqs', 'FaqController');

        // Pages
        Route::resource('pages', 'PageController');

        // Posts
        Route::resource('posts', 'PostController');
    });

    Route::namespace('Localization')->as('localization.')->prefix('localization')->group(function () {

        // Language
        Route::resource('language', 'LanguageController');
    });

    Route::namespace('Filemanager')->as('filemanager.')->prefix('filemanager')->group(function () {

        // Language
        Route::resource('filemanager', 'FilemanagerController');
    });

    Route::namespace('Settings')->as('settings.')->prefix('settings')->group(function () {
        Route::resource('general', SettingController::class);
    });
});
