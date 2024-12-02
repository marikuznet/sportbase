<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function changeSizeEmployees(Request $request)
    {
      /*  $files = Storage::files('public/deal');
        if ($files) {
            foreach ($files as $image) {
                $imageOrig = storage_path('app/' . $image);
                $info = pathinfo($image);

                $thumbnailDirectory = 'public/employees';

                $thumbnailPath = $thumbnailDirectory . '/' . $info['filename'] . '.' . $info['extension'];
                Image::make($imageOrig)->resize(230, 230, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/' . $thumbnailPath));
            }
        }*/
    }
}
