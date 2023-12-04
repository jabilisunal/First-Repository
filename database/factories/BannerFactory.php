<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'position' => 'center',
            'status' => 1,
            'effect' => 'bonuce',
            'sort' => 1,
            'duration' => '1s',
        ];

        $languages = Language::where(['status' => 1])->get();

        foreach ($languages as $language) {
            $data[$language->code] = [
                'title' => $this->faker->name(),
                'description' => $this->faker->text(),
                'button_title' => 'Get Now',
                'button_url' => '/'.$language->code,
                'button_icon' => null,
            ];
        }

        return $data;
    }
}
