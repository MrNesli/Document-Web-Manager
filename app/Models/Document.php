<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'title',
        'file_path',
        'category_id',
    ];

    public function updateFile(UploadedFile|null $new_file)
    {
        // NOTE: Testable
        if (!$new_file) return;

        // Deleting previous document
        Storage::disk('public')->delete($this->file_path);
        $new_file_path = \App\Facades\Document::save($new_file);
        $this->update(['file_path' => $new_file_path]);
    }

    public function updateTitle(string|null $new_title)
    {
        if (!$new_title) return;

        $this->update(['title' => $new_title]);
    }

    public function updateCategory(int|null $new_category_id)
    {
        if (!$new_category_id) return;

        $this->update(['category_id' => $new_category_id]);
    }

    public function getFileSize()
    {
        // NOTE: Testable
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

    private function bytesToReadableFormat($bytes)
    {
        // NOTE: Testable
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

    public function getFileType()
    {
        return $this->documentFileType();
    }

    public function getFileName()
    {
        return basename($this->file_path);
    }

    private function documentFileType()
    {
        // NOTE: Testable
        if (is_null($this->file_path)) return 'Unknown';

        $file_extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
        return match ($file_extension)
        {
            'jpg', 'jpeg', 'png' => 'image',
            'pdf'                => 'pdf',
            default              => 'unknown',
        };
    }

    private function getImageDimensionsString()
    {
        // NOTE: Testable
        if (Storage::disk('public')->exists($this->file_path))
        {
            $full_file_path = Storage::disk('public')->path($this->file_path);
            $image_size = getimagesize($full_file_path);
            return $image_size[0] . 'px' . ' X ' . $image_size[1] . 'px';
        }

        return '0 X 0 (Image non trouvée)';
    }
}
