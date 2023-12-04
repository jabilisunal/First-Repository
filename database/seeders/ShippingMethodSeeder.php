<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ShippingMethod::truncate();

        $shippingMethods = [
            [
                "name" => "Pulsuz çatdırılma",
                "status" => 1,
                "sort" => 1
            ],
        ];

        ShippingMethod::insert($shippingMethods);
    }
}
