<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropDatabaseSeeder extends Seeder
{
    /**
     * @var string $connection
     */
    protected string $connection = 'mysql';

    /**
     * @var string $connectionMongo
     */
    protected string $connectionMongo = 'mongodb';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::connection($this->connection)->disableForeignKeyConstraints();

        DB::connection($this->connection)->statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::connection($this->connection)->dropIfExists('users');
        Schema::connection($this->connection)->dropIfExists('offices');
        Schema::connection($this->connection)->dropIfExists('worker_positions');
        Schema::connection($this->connection)->dropIfExists('failed_jobs');
        Schema::connection($this->connection)->dropIfExists('migrations');
        Schema::connection($this->connection)->dropIfExists('password_resets');
        Schema::connection($this->connection)->dropIfExists('personal_access_tokens');

        Schema::connection($this->connection)->dropIfExists('sessions');
        Schema::connection($this->connection)->dropIfExists('permissions');
        Schema::connection($this->connection)->dropIfExists('roles');
        Schema::connection($this->connection)->dropIfExists('model_has_permissions');
        Schema::connection($this->connection)->dropIfExists('model_has_roles');
        Schema::connection($this->connection)->dropIfExists('role_has_permissions');

        Schema::connection($this->connection)->dropIfExists('settings');
        Schema::connection($this->connection)->dropIfExists('languages');
        Schema::connection($this->connection)->dropIfExists('currencies');

        Schema::connection($this->connection)->dropIfExists('files');
        Schema::connection($this->connection)->dropIfExists('entity_files');

        Schema::connection($this->connection)->dropIfExists('offices');

        Schema::connection($this->connection)->dropIfExists('pages');
        Schema::connection($this->connection)->dropIfExists('page_translations');

        Schema::connection($this->connection)->dropIfExists('features');
        Schema::connection($this->connection)->dropIfExists('feature_translations');

        Schema::connection($this->connection)->dropIfExists('banner_types');

        Schema::connection($this->connection)->dropIfExists('banners');
        Schema::connection($this->connection)->dropIfExists('banner_translations');

        Schema::connection($this->connection)->dropIfExists('partners');

        Schema::connection($this->connection)->dropIfExists('posts');
        Schema::connection($this->connection)->dropIfExists('post_translations');

        Schema::connection($this->connection)->dropIfExists('categories');
        Schema::connection($this->connection)->dropIfExists('category_translations');

        Schema::connection($this->connection)->dropIfExists('brands');
        Schema::connection($this->connection)->dropIfExists('brand_translations');

        Schema::connection($this->connection)->dropIfExists('menu_types');
        Schema::connection($this->connection)->dropIfExists('menus');
        Schema::connection($this->connection)->dropIfExists('menu_translations');

        Schema::connection($this->connection)->dropIfExists('faqs');
        Schema::connection($this->connection)->dropIfExists('faq_translations');

        Schema::connection($this->connection)->dropIfExists('wishlists');

        Schema::connection($this->connection)->dropIfExists('shipping_methods');

        Schema::connection($this->connection)->dropIfExists('payments');
        Schema::connection($this->connection)->dropIfExists('payment_methods');
        Schema::connection($this->connection)->dropIfExists('payment_systems');
        Schema::connection($this->connection)->dropIfExists('payriff_payments');
        Schema::connection($this->connection)->dropIfExists('transactions');

        Schema::connection($this->connection)->dropIfExists('orders');
        Schema::connection($this->connection)->dropIfExists('order_statuses');
        Schema::connection($this->connection)->dropIfExists('order_requests');

        Schema::connection($this->connection)->dropIfExists('customers');
        Schema::connection($this->connection)->dropIfExists('customer_addresses');

        Schema::connection($this->connection)->dropIfExists('addresses');

        Schema::connection($this->connection)->dropIfExists('places');
        Schema::connection($this->connection)->dropIfExists('place_translations');
        Schema::connection($this->connection)->dropIfExists('place_facilities');
        Schema::connection($this->connection)->dropIfExists('place_tags');

        Schema::connection($this->connection)->dropIfExists('tours');
        Schema::connection($this->connection)->dropIfExists('tour_translations');
        Schema::connection($this->connection)->dropIfExists('tour_facilities');
        Schema::connection($this->connection)->dropIfExists('tour_tags');

        Schema::connection($this->connection)->dropIfExists('rent_cars');
        Schema::connection($this->connection)->dropIfExists('rent_car_translations');
        Schema::connection($this->connection)->dropIfExists('rent_car_facilities');
        Schema::connection($this->connection)->dropIfExists('rent_car_tags');

        Schema::connection($this->connection)->dropIfExists('region_groups');
        Schema::connection($this->connection)->dropIfExists('region_group_translations');
        Schema::connection($this->connection)->dropIfExists('region_group_destinations');
        Schema::connection($this->connection)->dropIfExists('destinations');
        Schema::connection($this->connection)->dropIfExists('destination_translations');

        Schema::connection($this->connection)->dropIfExists('tags');
        Schema::connection($this->connection)->dropIfExists('reviews');

        Schema::connection($this->connection)->dropIfExists('facilities');
        Schema::connection($this->connection)->dropIfExists('facility_translations');
    }
}
