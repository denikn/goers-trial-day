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
}
