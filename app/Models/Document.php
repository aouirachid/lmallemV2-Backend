<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    //
    protected $fillable = [
        'selfEmployedCard',
        'Anthropometric',
        'diploma',
        'handy_man_id',
    ];

    /**
     * Get the handyMan that owns the Document
     */
    public function handyMan(): BelongsTo
    {
        return $this->belongsTo(handyMan::class, 'handy_man_id');
    }
}
