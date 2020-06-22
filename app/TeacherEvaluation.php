<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherEvaluation extends Model
{
    protected $fillable = [
        'assign_id', 'form_id'
    ];

    public function assign(){
        return $this->belongsTo('App\Assign','assign_id');
    }

    public function evaluation(){
        return $this->belongsTo('App\EvaluationForm','form_id');
    }
}
