<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course_list';
    
    public $incrementing = false;
    public $timestamps = false;

    /**
     * relationship between course and sections
     */
    public function sections()
    {
        return $this->hasMany('App\Section', 'course');
    }

    public function prereqs()
    {
    	return $this->belongsToMany('App\Course', 'pre_req', 'course_id', 'pre_req_course_id');
    }
}
