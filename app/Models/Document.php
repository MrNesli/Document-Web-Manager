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

    /*
     * Deletes document file
     *
     * */
    public function deleteFile(): void
    {
        Storage::disk('public')->delete($this->file_path);
    }

    /*
     * Updates document file
     *
     * @param UploadedFile|null $new_file
     *
     * */
    public function updateFile(UploadedFile|null $new_file): void
    {
        // NOTE: Testable
        if (!$new_file) return;

        // Deleting previous document
        Storage::disk('public')->delete($this->file_path);
        $new_file_path = \App\Facades\Document::saveFile($new_file);
        $this->update(['file_path' => $new_file_path]);
    }

    /*
     * Updates document title
     *
     * @param string|null $new_title
     *
     * */
    public function updateTitle(string|null $new_title): void
    {
        if (!$new_title) return;

        $this->update(['title' => $new_title]);
    }

    /*
     * Updates document category
     *
     * @param int|null $new_category_id
     *
     * */
    public function updateCategory(int|null $new_category_id): void
    {
        if (!$new_category_id) return;

        $this->update(['category_id' => $new_category_id]);
    }

    /*
     * Returns file's size or dimensions if it's an image
     *
     * */
    public function getFileSize(): string
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
        else
        {
            return '';
        }
    }

    /*
     * Converts bytes to human readable format
     *
     * */
    private function bytesToReadableFormat($bytes): string
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

    /*
     * Returns document's file type
     *
     * */
    public function getFileType(): string
    {
        return $this->documentFileType();
    }

    /*
     * Returns document's file name
     *
     * */
    public function getFileName(): string
    {
        return basename($this->file_path);
    }

    /*
     * Converts file extension to file type
     *
     * */
    private function documentFileType(): string
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

    /*
     * Returns image's dimensions
     *
     * */
    private function getImageDimensionsString(): string
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
