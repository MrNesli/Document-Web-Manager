<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Document
{
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
     * Saves uploaded file and returns its path relative to the public storage
     *
     * @param UploadedFile $file
     *
     * @return string - Saved file's path
     *
     * */
    public function save(UploadedFile $file): string
    {
        $path = "documents/".$this->generateUniqueFileName($file);
        while (\App\Models\Document::where('file_path', $path)->exists())
        {
            $path = "documents/".$this->generateUniqueFileName($file);
        }

        $file_real_path = \Illuminate\Support\Facades\File::get($file->getRealPath());

        // Saving document to the public storage
        Storage::disk('public')->put($path, $file_real_path);

        return $path;
    }
}
