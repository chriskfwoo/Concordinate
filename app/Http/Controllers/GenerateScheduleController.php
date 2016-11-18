<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Section;
use App\Course;
use Auth;

class GenerateScheduleController extends Controller
{
	/**
	 * View for the schedule making page
	 */
	public function schedulerView()
    {
        $availableCourses = $this->getAvailableCourses();
        return view('scheduler')->with('courses', $availableCourses);
    }

    /**
     * method that returns all the available courses the user can currently take
     */
	public function getAvailableCourses() 
	{
		$completedCourses = json_decode(Auth::user()->completed_courses);
		$availableCourses = collect();

		//get all the courses where who are not in pivot table, and also all the courses where all the pivot elements are met.
		$courses = Course::select(
			'course_list.id',
			'course_list.name'
		)
		->whereNotIn('id', $completedCourses)
		->get();

		foreach ($courses as $course) {
			$prereqs = $course->prereqs()->get();

			if ($prereqs->isEmpty()) {
				$availableCourses->push($course);
				continue;			
			}
			
			//check if all prereqs are met. if yes, push into available courses!
			foreach ($prereqs as $prereq) {
				if (in_array($prereq->pivot->pre_req_course_id, $completedCourses)) {
					$availableCourses->push($course);
				}
			}
		}
			
		return $availableCourses;
	}

	/**
	 * Method that returns to the frontend the possible schedules generated from the preferences.
	 */
	public function getPossibleSchedules(Request $request) 
	{
		;
		// dd($request);
		//get all the courses needed to pass to the get combinations method
		$section = new Section;
		dd($section->getCombinations());
		$sections = $section->getSectionsForScheduler($request);

		//get the combinations that are non conflicting now.
		$schedules = $section->getNonConflictingSchedules($sections);




		//return collection of possible schedules
	}

}
