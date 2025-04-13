<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'orderNumber',
        'client_id',
        'handy_men_id',
        'service_id',
        'orderPrice',
        'orderDescription',
        'orderDate',
        'orderDeliveredAt',
        'orderStatus',
        'orderLocation',
    ];
    /**
     * Get the client that owns the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    /**
     * Get the handy_men that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function handy_men(): BelongsTo
    {
        return $this->belongsTo(HandyMan::class, 'handy_men_id');
    }
    /**
     * Get the service that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
