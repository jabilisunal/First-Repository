<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Post;
use App\Models\PostTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PostSeeder extends Seeder
{
    /**
     * @var string $connection
     */
    protected string $connection = 'mysql';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::connection($this->connection)->disableForeignKeyConstraints();

        DB::connection($this->connection)->statement('SET FOREIGN_KEY_CHECKS=0;');

        Post::truncate();

        PostTranslation::truncate();

        $posts = Post::factory()->count(10)->create()->toArray();

        foreach ($posts as $post) {

            $file = File::factory()->count(1)->create();

            $updatePost = Post::findOrFail($post['id']);

            $updatePost->syncFiles(['base_image' => $file->pluck('id')->toArray()]);
        }
    }
}
