<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
		'service_fee',
		'type'
    ];

}
