<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageUploder
{
    public static function upload($image , $path , $disk = 'public_storage')
    {

        Storage::disk($disk)->put($path , File::get($image));
    }

    public static function multipleUpload($images , $path , $disk = 'public_storage')
    {
        $uploadedImages = [];

        foreach ($images as $key => $image) {

            $fullPath = $path . $key .'_'.  $image->getClientOriginalName();
            
            self::upload($image , $fullPath , $disk);

            $uploadedImages += [$key => $fullPath];
        }

        return $uploadedImages;
    }
}