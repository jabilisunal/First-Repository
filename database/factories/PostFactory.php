<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $data = [
            'status' => 1,
            'is_popular' => 1,
            'slug' => $this->faker->unique()->slug(),
            'sort' => 1
         ];

         $languages = Language::where(['status' => 1])->get();

         foreach ($languages as $language) {
             $data[$language->code] = [
                 'title' => $this->faker->paragraph,
                 'description' => $this->faker->text()
             ];
         }

        return $data;
    }
}
