<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'order_number',
		'email',
		'phone',
		'first_name',
		'last_name',
		'gender',
		'expired_at'
    ];

	public function detail()
    {
        return $this->hasMany('App\Models\Order\CheckoutDetail', 'checkout_id', 'id');
    }

}
