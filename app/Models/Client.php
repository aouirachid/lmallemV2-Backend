<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'denomination',
        'rc',
        'ice',
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
     * Get all of the orders for the Client
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
