<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $table = 'sections';

    public $timestamps = false;

    /**
     * Get all sections that are to be used in the schedule combinations
     */
    public function getSectionsForScheduler($request)
    {
    	//get all the courses needed to pass to the get combinations method
		$courses = $request->get('courses');
        dd($courses);
		$section = new Section;
		$sections = $section
			->whereIn('course', $courses)
			->applyPreferences()
			->get();

		$courses = $sections->groupBy('course');

		foreach ($courses as $courseKey => $course) {
    		$courses[$courseKey] = $course->groupBy('section3');

    		foreach ($courses[$courseKey] as $sectionKey => $sections) {
    			$courses[$courseKey][$sectionKey] = $sections->groupBy('type');
    		}
    	}

		return $courses->toArray();
    }

    /**
     * Get all the non conflicting schedule possibilities
     */
    public function getNonConflictingSchedules($courses)
    {
    	$schedules = collect([]);
    	$schedule = collect([]);

    	$course  = current($courses);
    	$section = current($course);
    	$lecture = $section["  Lec    "];

    	$this->tryToAdd($lecture, $courses, $schedule, $schedules);

    	


    	

    	dd($schedules);
		return $schedules;    	
    }

    public function tryToAdd($lecture, $coursess, $schedule, $schedules) 
    {

    	//if no conflict, add. else, move to next Lecture
    	if (!$this->checkConflict(current($lecture), $schedule)) {

    		$schedule->push($lecture);

    		//if there is NO MORE nextCourse, it is a complete lecture schedule.

    		if (!next($courses)) {
    			$schedules->push($schedule);
    			$schedule = collect([]);
    		} else {
    			//if ther is a next course, continue wiht next course
    			$this->tryToAdd('lecture', $courses, $schedule, $schedules);
    		}

    	} else {	
    		//check the next lecture of this course.
    		$nextLecture = next($lecture);

    		//if there is a next lecture to try to add, try it
    		//if not, there is no more lecture, therefore you need to go back and change the lecture of previous course.
    		if ($nextLecture) {
    			$this->tryToAdd($nextLecture, $courses, $schedule, $schedules);
    		} else {

    		}
    	}
    }


    public function checkConflict($toBeAdded, $schedule) 
    {	
    	return false;
    }

    /**
     * Apply the preferences when getting the sections
     */
    public function scopeApplyPreferences($query)
    {


    	return $query;
    }
}
