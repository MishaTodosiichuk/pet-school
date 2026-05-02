<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoGallery extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'photo_galleries';

    protected $fillable = ['title', 'key', 'publish'];

    protected $casts = [
        'publish' => 'boolean',
    ];

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'photo_galleries_image')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order', 'asc');
    }

    public static function getByKey(string $key)
    {
        return self::where('key', $key)->with('images')->first();
    }
}
