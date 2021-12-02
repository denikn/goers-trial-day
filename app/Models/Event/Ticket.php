<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
		'event_id',
		'name',
		'event_session_ids',
		'selling_period',
		'price',
		'qty',
		'max_per_person',
		'package_details',
		'group'
    ];

	public function event()
    {
        return $this->belongsTo('App\Models\Event\Event', 'event_id', 'id');
    }
}
