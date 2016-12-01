<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function generatedSchedulesView($combinations)
    {
    	return view('generated-schedules', [
    		'results' => $combinations
    	]);
    }

    public function continueScheduleView()
    {
    	return view('confirm-schedule');
    }

    /**
     * method that returns all the available courses the user can currently take
     */
	public function getAvailableCourses($continue = null) 
	{
		$electiveCount = 0;

		$completedCourses = [];

		if(isset(Auth::user()->completed_courses)){
			$completedCourses = json_decode(Auth::user()->completed_courses);
		}

		//count the number of completed electives.
		foreach($completedCourses as $completedCourse) {
			if (strpos($completedCourse, 'ELECTIVE') !== false) {
				$electiveCount++;
			}
		}

		$availableCourses = collect();
		
		if ($continue) {

			$user = Auth()->user();
			$userSchedules = json_decode($user->schedules);
			$scheduler = $userSchedules[count($userSchedules)-1];

			//if this page comes from a continue, check last schedule for the courses that are already taken.
			foreach ($scheduler as $semesterKey => $semester) {
				foreach ($semester as $sectionKey => $section) {
					if (!in_array($section->course, $completedCourses)) {

						//check if this course is an elective
						if (Course::find($section->course)->elective == 1) {
							$electiveCount++;
						}

						array_push($completedCourses, $section->course);
					}
				}
			}	

		}

		//get all the courses where who are not in pivot table, and also all the courses where all the pivot elements are met.
		$courses = Course::select(
			'course_list.id',
			'course_list.name',
			'course_list.fall_semester',
			'course_list.winter_semester'
		)
		->whereNotIn('id', $completedCourses);

		if ($electiveCount >= 4) {
			$courses->where('elective', 0);
		}

		$courses = $courses->get();

		foreach ($courses as $course) {
			$prereqs = $course->prereqs()->get();

			if ($prereqs->isEmpty()) {
				$availableCourses->push($course);
				continue;			
			}
			
			$prereqNum = sizeOf($prereqs);

			//check if all prereqs are met. if yes, push into available courses!
			foreach ($prereqs as $key=>$prereq) {
				
				if (in_array($prereq->pivot->pre_req_course_id, $completedCourses)) {
					
					if ($prereqNum == $key + 1) {
						$availableCourses->push($course);
					}

				} else {
					continue;
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
    	$continue = $request->get('continue');
    	$semester = $request->get('semester');
		//get all the courses needed to pass to the get combinations method
		$section 		= new Section;
		$courseSections = $section->getSectionsForScheduler($request);
		
		$combinations = $section->getCombinations($courseSections);
		
		$results = new Paginator($combinations, 10);	
    	$results->setPath('generate');

		return view('generated-schedules', [
			'results' 		=> $results,
			'totalResults' 	=> count($combinations),
			'continue' 		=> $continue,
			'semester'		=> $semester
		]);
	}

	public function saveSchedule(Request $request) 
	{
		$user = Auth()->user();
		$userSchedule = json_decode($user->schedules);
		
		$continue 		= $request->get('continue');
		$course 		= $request->get('course');
		$sectionType 	= $request->get('sectiontype');
		$sectionCode 	= $request->get('sectioncode');
		$days 			= $request->get('days');
		$start 			= $request->get('start');
		$end 			= $request->get('end');
		
		$schedule = [];
		$semester = [];

		for ($i = 0; $i < count($course); $i++) {
			$section = [
				'course' => $course[$i],
				'type' => $sectionType[$i],
				'days' => $days[$i],
				'start' => $start[$i],
				'end' => $end[$i]
			];

			array_push($semester, $section);
		}

		array_push($schedule, $semester);

		if (empty($userSchedule)) {
			$userSchedule = [];
			array_push($userSchedule, $schedule);
		} else if (empty($continue)) {
			array_push($userSchedule, $schedule);
		} else {
			$scheduleNum = count($userSchedule)-1;
			
			array_push($userSchedule[$scheduleNum], $semester);
		}
		
		$user->schedules = json_encode($userSchedule);
		$user->save();

		return view('confirm-schedule')->with('courses', $this->getAvailableCourses(true));
	}

}
