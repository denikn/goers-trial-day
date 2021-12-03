<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event\EventSession;

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

	public function getSellingPeriodAttribute()
	{
		$decodeSellingPeriod = json_decode($this->attributes['selling_period']);
		$sellingPeriod = ['start' => $decodeSellingPeriod[0],
						  'end' => $decodeSellingPeriod[1]];

		return $sellingPeriod;
	}

	public function getEventSessionIdsAttribute()
	{
		foreach(json_decode($this->attributes['event_session_ids']) as $event_session_id)
		{
			$eventSessionData[] = EventSession::find($event_session_id);
		}

		return $eventSessionData;
	}

}
