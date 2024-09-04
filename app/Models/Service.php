<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'image',
    'description',
    'status',
    'category_id'
    ];
    public function Category():BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
