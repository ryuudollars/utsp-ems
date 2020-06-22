<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'ques_category', 'ques_statement'
    ];

    public function question_details(){
        return $this->hasMany('App\QuestionInForm');
    }
}
