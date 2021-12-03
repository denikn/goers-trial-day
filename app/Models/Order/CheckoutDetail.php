<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class CheckoutDetail extends Model
{
    protected $fillable = [
        'checkout_id',
		'ticket_id',
		'qty'
    ];

	public function checkout()
    {
        return $this->belongsTo('App\Models\Order\Checkout', 'id', 'checkout_id');
    }

	public function ticket()
    {
        return $this->hasOne('App\Models\Event\Ticket', 'id', 'ticket_id');
    }

}
