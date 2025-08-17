<?php

namespace App\Utils;

use App\Utils\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Document extends File
{
    protected string $model = \App\Models\Document::class;
    protected string $file_path_db_field = 'file_path';

    /*
     * Saves document file and returns its path relative to the public storage
     *
     * @param UploadedFile $file
     *
     * @return string - Saved file's path
     *
     * */
    public function saveFile(UploadedFile $file): string
    {
        return $this->save($file, 'documents');
    }
}
