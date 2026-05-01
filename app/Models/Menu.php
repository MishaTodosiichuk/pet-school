<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use HasFactory, NodeTrait, SoftDeletes;

    protected $table = 'menus';

    protected $fillable = [
        'title',
        'slug',
        'publish',
        'parent_id'
    ];

    protected $casts = [
        'publish' => 'boolean',
    ];
}
