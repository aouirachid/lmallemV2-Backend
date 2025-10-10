<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class adminPanel extends User
{
    use HasFactory;

    protected $fillable = [
        'imagePath',
        'status',
        'user_id',
    ];

    /**
     * Get the user that owns the adminPanel
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
