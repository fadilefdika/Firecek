<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AparInspection extends Model
{
    protected $table = 'fc_apar_inspections';

    protected $fillable = [
        'inspection_schedule_id',
        'apar_id',
        'inspected_by',
        'inspected_at',
        'status',
        'created_at',
        'updated_at',
    ];
}
