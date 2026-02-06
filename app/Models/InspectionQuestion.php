<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionQuestion extends Model
{
    protected $table = 'fc_inspection_questions';

    protected $fillable = [
        'media_id',
        'question_text',
    ];


    public function options()
    {
        return $this->hasMany(InspectionQuestionOption::class, 'inspection_question_id');
    }
}
