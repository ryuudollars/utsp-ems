<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'post', 'academic_id', 'semester_id', 'form_id',
    ];

    public function academic_year(){
        return $this->belongsTo('App\AcademicYear','academic_id');
    }

    public function semester(){
        return $this->belongsTo('App\Semester','semester_id');
    }

    public function evaluation_form(){
        return $this->belongsTo('App\EvaluationForm','form_id');
    }


}
