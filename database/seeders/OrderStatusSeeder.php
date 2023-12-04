<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        OrderStatus::truncate();

        $ordersStatuses = [
            [
                //"name" => "Cancelled"
                "name" => "Ləğv edildi"
            ],
            [
                //"name" => "Completed"
                "name" => "Tamamlandı"
            ],
            [
                //"name" => "Delivered"
                "name" => "Kuryerdə"
            ],
            [
                //"name" => "Waiting"
                "name" => "Təsdiq gözlənilir"
            ],
            [
                //"name" => "Payment Waiting"
                "name" => "Ödəniş Gözləyir"
            ],
            [
                //"name" => "Processing"
                "name" => "Hazırlanır"
            ],
            [
                //"name" => "Returned"
                "name" => "Geri Qaytarıldı"
            ]
        ];

        OrderStatus::insert($ordersStatuses);
    }
}
