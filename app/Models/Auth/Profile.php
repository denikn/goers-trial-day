<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'first_name',
		'last_name',
		'phone',
		'birthday',
		'gender'
    ];
}
