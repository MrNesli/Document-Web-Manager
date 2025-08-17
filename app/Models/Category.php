<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'img_path',
        'description',
    ];

    /*
     * Deletes category preview image
     *
     * */
    public function deleteImage(): void
    {
        if ($this->img_path)
            Storage::disk('public')->delete($this->img_path);
    }

    /*
     * Deletes category's documents' files
     *
     * */
    public function deleteDocuments(): void
    {
        foreach ($this->documents as $doc)
            $doc->deleteFile();
    }

    /*
     * Returns documents that belong to the category
     *
     * @return HasMany
     *
     * */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
