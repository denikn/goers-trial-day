<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventSession extends Model
{
    protected $fillable = [
        'event_id',
		'start',
		'end'
    ];

	public function event()
    {
        return $this->belongsTo('App\Models\Event\Event', 'event_id', 'id');
    }
}
