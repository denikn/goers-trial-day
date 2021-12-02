<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'order_number',
		'ticket_ids',
		'email',
		'phone',
		'first_name',
		'last_name',
		'gender',
		'expired_at'
    ];

}
