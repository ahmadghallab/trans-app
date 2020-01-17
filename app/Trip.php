<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $guarded = [];

    public function line()
    {
        return $this->belongsTo(Line::class, 'line');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver');
    }

    public function subscriptions()
    {
        return $this->hasMany(EmployeeTrip::class, 'trip');
    }
}
