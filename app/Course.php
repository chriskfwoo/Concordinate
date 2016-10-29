<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course_list';
    
    public $incrementing = false;
    public $timestamps = false;
}
