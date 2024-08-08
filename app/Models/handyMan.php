<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class handyMan extends Model
{
    use HasFactory;
    protected $fillable = [
        'ice',
        'specializedField',
        'accountNumber',
        'status',
        'user_id'
    ];
}
