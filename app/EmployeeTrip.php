<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTrip extends Model
{
    protected $table = 'employee_trip';

    protected $guarded = [];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee');
    }
}
