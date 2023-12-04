<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Customer::truncate();

        $customers = [
            [
                'name' => 'Beycan',
                'surname' => 'Beycanov',
                'locale' => 'az',
                'country_code' => 'AZ',
                'timezone' => 'Asia/Baku',
                'phone' => '+994508051242',
                'email' => 'bbeycanov@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]
        ];

        Customer::insert($customers);
    }
}
