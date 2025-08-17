<?php

namespace App\Utils;

use App\Utils\File;
use Illuminate\Http\UploadedFile;

class Category extends File
{
    protected string $model = \App\Models\Category::class;
    protected string $file_path_db_field = 'img_path';

    /*
     * Saves category preview image and returns its path relative to the public storage
     *
     * @param UploadedFile $image
     *
     * @return string - Saved image's path
     *
     * */
    public function saveImage(UploadedFile $image): string
    {
        return $this->save($image, 'images');
    }
}
