<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminPanel extends Model
{
    use HasFactory;
    protected $fillable = [
        'imagePath',
        'status',
        'user_id'
    ];
}
