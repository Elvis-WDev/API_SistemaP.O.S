<?php

namespace App\Http\Controllers\assets;

use Intervention\Image\Facades\Image;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ResizeStorageImage extends Controller
{
    static public function resizeAndStoreImage($file, $pathDestination, $width, $height)
    {
        $filename = md5(uniqid() . microtime()) . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file);
        $image->resize($width, $height);

        if (!Storage::exists('public/images/' . $pathDestination . '/')) {
            Storage::makeDirectory('/public/images/' . $pathDestination . '/');
        }
        $image->save(storage_path('app/public/images/' . $pathDestination . '/' . $filename));

        $url = asset('storage/images/' . $pathDestination . '/' . $filename);

        return $url;
    }
}
