<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['size', 'mime_type', 'file_name', 'path', 'type'];
    protected $appends = ['url'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return url('/').Storage::url($this->path);
    }
}
