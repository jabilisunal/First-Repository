<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        CategoryTranslation::truncate();

        $categories = [
            [
                'parent_id' => null,
                'slug' => 'hotels',
                'color' => null,
                'status' => 1,
                'sort' => 1,
                'translation' => [
                    'en' => [
                        'lang_id' => 1,
                        'title' => 'Hotels',
                        'description' => ''
                    ],
                    'az' => [
                        'lang_id' => 2,
                        'title' => 'Otellər',
                        'description' => ''
                    ],
                    'ru' => [
                        'lang_id' => 3,
                        'title' => 'Отели',
                        'description' => ''
                    ],
                    'ar' => [
                        'lang_id' => 4,
                        'title' => 'الفنادق',
                        'description' => ''
                    ]
                ]
            ],
            [
                'parent_id' => null,
                'slug' => 'apartments',
                'color' => null,
                'status' => 1,
                'sort' => 1,
                'translation' => [
                    'en' => [
                        'lang_id' => 1,
                        'title' => 'Apartments',
                        'description' => ''
                    ],
                    'az' => [
                        'lang_id' => 2,
                        'title' => 'Mənzillər',
                        'description' => ''
                    ],
                    'ru' => [
                        'lang_id' => 3,
                        'title' => 'Квартиры',
                        'description' => ''
                    ],
                    'ar' => [
                        'lang_id' => 4,
                        'title' => 'شقق سكنية',
                        'description' => ''
                    ]
                ]
            ],
            [
                'parent_id' => null,
                'slug' => 'restaurants',
                'color' => null,
                'status' => 1,
                'sort' => 1,
                'translation' => [
                    'en' => [
                        'lang_id' => 1,
                        'title' => 'Restaurants',
                        'description' => ''
                    ],
                    'az' => [
                        'lang_id' => 2,
                        'title' => 'Restoranlar',
                        'description' => ''
                    ],
                    'ru' => [
                        'lang_id' => 3,
                        'title' => 'Рестораны',
                        'description' => ''
                    ],
                    'ar' => [
                        'lang_id' => 4,
                        'title' => 'مطاعم',
                        'description' => ''
                    ]
                ]
            ],
            [
                'parent_id' => null,
                'slug' => 'tours',
                'color' => null,
                'status' => 1,
                'sort' => 1,
                'translation' => [
                    'en' => [
                        'lang_id' => 1,
                        'title' => 'Tours',
                        'description' => ''
                    ],
                    'az' => [
                        'lang_id' => 2,
                        'title' => 'Turlar',
                        'description' => ''
                    ],
                    'ru' => [
                        'lang_id' => 3,
                        'title' => 'Туры',
                        'description' => ''
                    ],
                    'ar' => [
                        'lang_id' => 4,
                        'title' => 'جولات',
                        'description' => ''
                    ]
                ]
            ],
            [
                'parent_id' => null,
                'slug' => 'rent-cars',
                'color' => null,
                'status' => 1,
                'sort' => 1,
                'translation' => [
                    'en' => [
                        'lang_id' => 1,
                        'title' => 'Rent Cars',
                        'description' => ''
                    ],
                    'az' => [
                        'lang_id' => 2,
                        'title' => 'Kirayə Avtomobillər',
                        'description' => ''
                    ],
                    'ru' => [
                        'lang_id' => 3,
                        'title' => 'Прокат автомобилей',
                        'description' => ''
                    ],
                    'ar' => [
                        'lang_id' => 4,
                        'title' => 'تأجير سيارات',
                        'description' => ''
                    ]
                ]
            ]
        ];

        foreach ($categories as $category) {

            $categoryValue = [
                'parent_id' => $category['parent_id'],
                'slug' => $category['slug'],
                'color' => $category['color'],
                'status' => $category['status'],
                'sort' => $category['sort'],
            ];

            $categoryData = Category::create($categoryValue);

            foreach ($category['translation'] as $key => $value) {

                $translateValue = [
                    'category_id' => $categoryData->id,
                    'locale' => $key,
                    'title' => $value['title'],
                    'description' => $value['description'],
                ];

                CategoryTranslation::create($translateValue);
            }
        }
    }
}
