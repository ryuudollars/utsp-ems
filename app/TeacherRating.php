<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherRating extends Model
{
    protected $fillable = [
        'form_id', 'statement', 'category', 'rate', 'form_title', 'teacher_fname',
        'teacher_lname', 'sub_desc', 'rated_by_fname', 'rated_by_lname'
    ];
}
