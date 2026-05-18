<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "pages";

    protected $fillable = ['title'];

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class, 'page_id', 'id')
            ->orderBy('sort_order');
    }
}
