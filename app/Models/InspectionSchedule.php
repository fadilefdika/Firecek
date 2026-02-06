<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionSchedule extends Model
{
    protected $table = 'fc_inspection_schedules';
    
    protected $fillable = [
        'title', 'schedule_type_id', 'start_date', 'start_time',
        'end_date', 'end_time', 'notes'
    ];

    public $timestamps = false;

    public function typeRelation()
    {
        return $this->belongsTo(ScheduleType::class, 'schedule_type_id'); // ⬅ foreign key baru
    }

        public function aparInspections()
    {
        return $this->hasMany(AparInspection::class, 'inspection_schedule_id');
    }

}

