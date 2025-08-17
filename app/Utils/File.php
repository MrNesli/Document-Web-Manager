<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

// Document::saveFile()
// Category::saveImage()
//
// Document extends File => saveFile()
// Category extends File => saveImage()

class File
{
    /* Fields to be defined in child classes */

    /* @type \Illuminate\Eloquent\Database\Model */
    protected string $model;

    /* @type string */
    protected string $file_path_db_field;

    /*
     * Generates a unique file name
     *
     * @param UploadedFile $file
     *
     * @return string - Generated file name
     *
     * */
    private function generateUniqueFileName(UploadedFile $file): string
    {
        return uniqid() . '.' . $file->getClientOriginalExtension();
    }

    /*
     * Joins paths passed as function arguments
     *
     * @return string - Joined paths string
     *
     * */
    private function pathJoin(): string
    {
        $args = func_get_args();
        $paths = [];

        foreach($args as $arg)
        {
            $paths[] = trim($arg, DIRECTORY_SEPARATOR);
        }

        return join(DIRECTORY_SEPARATOR, $paths);
    }

    /*
     * Verifies if the file path is unique on Model
     * It's unique if it doesn't exist
     *
     * @return bool
     *
     * */
    private function pathIsUnique(string $path): bool
    {
        return !$this->model::where($this->file_path_db_field, $path)->exists();
    }

    /*
     * Saves uploaded file and returns its path relative to the public storage
     *
     * @param UploadedFile $file
     * @param string $file_path - path relative to the public storage to save the file in
     *
     * @return string - Saved file's path
     *
     * */
    protected function save(UploadedFile $file, string $file_path): string
    {
        $path = $this->pathJoin($file_path, $this->generateUniqueFileName($file));

        while (!$this->pathIsUnique($path))
        {
            $path = $this->pathJoin($file_path, $this->generateUniqueFileName($file));
        }

        $file_real_path = \Illuminate\Support\Facades\File::get($file->getRealPath());

        // Saving document to the public storage
        Storage::disk('public')->put($path, $file_real_path);

        return $path;
    }
}
