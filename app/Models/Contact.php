<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'code_edrpou',
        'zip_code',
        'address',
        'schedule',
        'email',
        'phone_number',
        'head_institution',
    ];
}
