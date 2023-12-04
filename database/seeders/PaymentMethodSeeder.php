<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        PaymentMethod::truncate();

        $paymentMethods = [
            [
                "name" => "Qapıda nəğd",
                'payment_system_id' => null,
                "description" => "Çatdırılma zamanı nağd ödəyin.",
                "status" => 1,
                "sort" => 1
            ],
            [
                "name" => "Bank Cart",
                'payment_system_id' => 1,
                "description" => "Bank kartı ilə ödəniş; Bank Kartınız varsa kredit kartınızla ödəyə bilərsiniz",
                "status" => 1,
                "sort" => 1
            ],
        ];

        PaymentMethod::insert($paymentMethods);
    }
}
