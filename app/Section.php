<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'sec_code'
    ];

    public function student_section(){
        return $this->hasMany('App\Student');
    }
}
