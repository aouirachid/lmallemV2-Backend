<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HandyMan extends Model
{
    use HasFactory;

    protected $table = 'handy_men';

    protected $fillable = [
        'ice',
        'specializedField',
        'accountNumber',
        'bankName',
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

    /**
     * Get all of the document for the handyMan
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get all of the orders for the HandyMan
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
