<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionQuestionOption extends Model
{
    protected $table = 'fc_inspection_question_options';

    protected $fillable = [
        'inspection_question_id',
        'option_text',
    ];

    public function question()
    {
        return $this->belongsTo(InspectionQuestion::class);
    }
}
