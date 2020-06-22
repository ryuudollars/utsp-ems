<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    protected $fillable = [
        'title', 'type', 'start_date', 'end_date', 'speaker', 'venue'
    ];

    public function question_form(){
        return $this->hasMany('App\QuestionInForm');
    }
}
