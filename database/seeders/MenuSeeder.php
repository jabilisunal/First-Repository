<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuTranslation;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        Menu::truncate();
        MenuTranslation::truncate();

        DB::unprepared(File::get(base_path('database/seeders/sql/menu.sql')));
        DB::unprepared(File::get(base_path('database/seeders/sql/menu_translations.sql')));
    }
}
