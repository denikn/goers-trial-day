<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
		'event_id',
		'name',
		'datetime',
		'price',
		'qty',
		'max_per_person',
		'package_details',
		'group'
    ];
}
