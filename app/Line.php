<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $guarded = [];

    public function stations()
    {
    	return $this->belongsToMany(Station::class);
    }
}
