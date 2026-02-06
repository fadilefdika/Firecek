<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleType extends Model
{
    protected $table = 'fc_schedule_type';

    protected $fillable = ['schedule_name']; 
}
