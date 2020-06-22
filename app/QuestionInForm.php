<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionInForm extends Model
{
    protected $fillable = [
        'form_id', 'ques_id'
    ];

    public function question_form(){
        return $this->belongsTo('App\EvaluationForm','form_id');
    }

    public function question_details(){
        return $this->belongsTo('App\Question','ques_id');
    }
}
