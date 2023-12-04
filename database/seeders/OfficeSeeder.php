<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Office::truncate();

        $offices = [
            [
                "name" => "Main Office",
                "address" => "Hüseyn Cavid 91",
                "lat" => "40.3837291",
                "lng" => "49.8125103",
                "status" => 1,
                "sort" => 1
            ]
        ];

        Office::insert($offices);
    }
}
