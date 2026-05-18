<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageBlock extends Model
{
    use HasFactory;

    protected $table = 'page_blocks';

    protected $fillable = [
        'page_id',
        'title',
        'text',
        'file',
        'publish',
        'sort_order',
    ];

    protected $casts = [
        'publish' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
