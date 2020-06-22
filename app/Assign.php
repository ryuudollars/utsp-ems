<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $fillable = [
        'sec_id', 'sub_id', 'teacher_id'
    ];

    public function section(){
        return $this->belongsTo('App\Section','sec_id');
    }

    public function subject(){
        return $this->belongsTo('App\Subject','sub_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Faculty','teacher_id');
    }
}
