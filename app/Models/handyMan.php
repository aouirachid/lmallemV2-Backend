<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the user that owns the adminPanel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    

}
