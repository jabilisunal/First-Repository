<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CropService {

    /**
     * @param $file
     * @param $path
     */
    public static function crop($file, $path): void
    {
        $img600 = Image::make($file->getRealPath());

        $img600->crop(25, 25);

        $img600->stream();

        Storage::disk('local')->put('icons/'.$path, $img600, 'public');


        $img600 = Image::make($file->getRealPath());

        $img600->crop(145, 145);

        $img600->stream();

        Storage::disk('local')->put('smalls/'.$path, $img600, 'public');


        $img800 = Image::make($file->getRealPath());

        $img800->crop(450, 450);

        $img800->stream();

        Storage::disk('local')->put('medium/'.$path, $img800, 'public');


        $img1200 = Image::make($file->getRealPath());

        $img1200->crop(1200, 1200);

        $img1200->stream();

        Storage::disk('local')->put('large/'.$path, $img1200, 'public');

    }

}
