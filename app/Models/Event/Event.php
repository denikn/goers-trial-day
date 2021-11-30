<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'type',
		'organization_id',
		'name',
		'place',
		'location',
		'location_details',
		'maps',
		'description',
		'interests',
		'group'
    ];

	public function organization()
    {
        return $this->belongsTo('App\Models\Event\Organization', 'organization_id', 'id');
    }

	public function session()
    {
        return $this->hasMany('App\Models\Event\EventSession', 'event_id', 'id');
    }

	public function ticket()
    {
        return $this->hasMany('App\Models\Event\Ticket', 'event_id', 'id');
    }
}
