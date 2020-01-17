<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $guarded = [];

    public function lines()
    {
    	return $this->belongsToMany(Line::class);
    }
    
}
