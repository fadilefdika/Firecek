<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionSchedule extends Model
{
    protected $table = 'fc_inspection_schedules';
    protected $fillable = [
        'title', 'type', 'start_date', 'start_time',
        'end_date', 'end_time', 'notes'
    ];
    public $timestamps = false; 
}
