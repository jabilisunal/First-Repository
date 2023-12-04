<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Language::truncate();

        $languages = [
            [
                'name' => 'Azerbaijani',
                'short_name' => 'AZE',
                'code' => 'az',
                'style' => 'ltr',
                'status' => 1,
            ],
            [
                'name' => 'English',
                'short_name' => 'ENG',
                'code' => 'en',
                'style' => 'ltr',
                'status' => 1,
            ],
            [
                'name' => 'Russian',
                'short_name' => 'RUS',
                'code' => 'ru',
                'style' => 'ltr',
                'status' => 1,
            ],
            [
                'name' => 'Arabic',
                'short_name' => 'ARA',
                'code' => 'ar',
                'style' => 'rtl',
                'status' => 1,
            ]
        ];

        Language::insert($languages);
    }
}
