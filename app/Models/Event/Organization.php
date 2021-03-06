<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
    ];

	public function event()
    {
        return $this->hasMany('App\Models\Event\Event', 'id', 'organization_id');
    }
}
