<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        (new SettingSeeder())->run();

        (new PermissionSeeder())->run();

        (new RoleSeeder())->run();

        (new OfficeSeeder())->run();

        (new WorkerPositionSeeder())->run();

        (new UserSeeder())->run();

        (new CustomerSeeder())->run();

        (new LanguageSeeder())->run();

        (new CurrencySeeder())->run();

        (new OrderStatusSeeder())->run();

        (new MenuTypeSeeder())->run();

        (new BannerTypeSeeder())->run();

        (new ShippingMethodSeeder())->run();

        (new PaymentMethodSeeder())->run();

        (new CategorySeeder())->run();

        (new DestinationSeeder())->run();

        (new TagSeeder())->run();

        (new PostSeeder())->run();

        (new BannerSeeder())->run();

        (new MenuSeeder())->run();
    }
}
