<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'title',
        'file_path',
        'category_id',
    ];

    private function bytesToReadableFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;

        if ($bytes <= $kb)
        {
            return $bytes . 'B';
        }
        else if ($bytes <= $mb)
        {
            return bcdiv($bytes / $kb, 1, 2) . "KB";
        }
        else if ($bytes <= $gb)
        {
            return bcdiv($bytes / $mb, 1, 2) . "MB";
        }
        else
        {
            return bcdiv($bytes / $gb, 1, 2) . "GB";
        }
    }

    public function getFileSize()
    {
        $file_type = $this->getFileType($this->file_path);

        if ($file_type == 'image')
        {
            return $this->getImageDimensionsString($this->file_path);
        }
        else if ($file_type == 'pdf')
        {
            $bytes = Storage::disk('public')->size($this->file_path);
            return $this->bytesToReadableFormat($bytes);
        }
    }

    public function getFileType()
    {
        return $this->documentFileType();
    }

    public function getFileName()
    {
        return basename($this->file_path);
    }

    private function getImageDimensionsString()
    {
        if (Storage::disk('public')->exists($this->file_path))
        {
            $full_file_path = Storage::disk('public')->path($this->file_path);
            $image_size = getimagesize($full_file_path);
            return $image_size[0] . 'px' . ' X ' . $image_size[1] . 'px';
        }

        return '0 X 0 (Image non trouvée)';
    }

    private function documentFileType()
    {
        if (is_null($this->file_path)) return 'Unknown';

        $file_extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
        return match ($file_extension)
        {
            'jpg', 'jpeg', 'png' => 'image',
            'pdf'                => 'pdf',
            default              => 'unknown',
        };
    }
}
