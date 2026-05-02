<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable =
        [
            'url',
            'alt',
            'disk',
            'mime_type',
            'size',
            'width',
            'height',
        ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'image_news');
    }
}
