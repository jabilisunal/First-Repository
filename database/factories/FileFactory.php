<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File as Files;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<File>
 */
class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filepath = storage_path('app/images');

        if(!Files::exists($filepath)){
            Files::makeDirectory($filepath);
        }

        $file = $this->faker->image($filepath,400,300, null, false);

        $fileSize = Storage::size('images/'.$file);
        $fileMime = Storage::mimeType('images/'.$file);


        $array = explode('.', $file);

        return [
            'disk' => config('filesystems.default'),
            'filename' => $file,
            'path' => 'images/'.$file,
            'extension' => end($array),
            'mime' => $fileMime,
            'size' => $fileSize,
        ];
    }
}
