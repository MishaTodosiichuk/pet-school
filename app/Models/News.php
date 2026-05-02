<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'views_count',
        'publish',
        'created_at',
    ];

    protected $casts = [
        'publish' => 'boolean',
    ];

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_news');
    }
}
