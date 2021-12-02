<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'checkout_id',
		'subtotal',
		'payment_method_id',
		'voucher',
		'discount',
		'total'
    ];

}
