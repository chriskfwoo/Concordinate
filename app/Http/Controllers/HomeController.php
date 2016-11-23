<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\User;
use App\Section;
use App\Course;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeView()
    {
        $name = Auth::user()->name;

        return view('home', [
            'name' => $name
        ]);
    }

    public function viewScheduleView()
    {
        $user = Auth::user();
        $schedules = json_decode($user->schedules);

        if ($schedules == null) {
            $schedules = [];
        }
        
        return view('viewschedule', [
            'schedules' => $schedules
        ]);
    }

    public function completedCoursesView()
    {
        $completedCourses = json_decode(Auth::user()->completed_courses);

        if ($completedCourses == null) {
            $completedCourses = [];
        }

        return view('completed-courses', [
            'completedCourses' => $completedCourses
        ]);
    }

    public function saveCompletedCourses(Request $request) {
        $completedCourses       = $request->get('completedCourses');

        if ($completedCourses == null) {
            $completedCourses = [];
        }
        $jsonCompletedCourses   = json_encode($completedCourses);

        $user = Auth::user();
        $user->completed_courses = $jsonCompletedCourses;
        $user->save();

        \Session::flash('flash_message','completed courses successfully saved');
        return Redirect::to('completed')->with('completed', $completedCourses);
    }

    public function deleteSchedule(Request $request)
    {
        $scheduleNumber = $request->get('scheduleNumber');
        
        $user = Auth()->user();
        $userSchedules = json_decode($user->schedules);

        unset($userSchedules[$scheduleNumber]);
        $userSchedules = array_values($userSchedules);

        $user->schedules = json_encode($userSchedules);
        $user->save();

        \Session::flash('flash_message','schedule successfully deleted');

        return Redirect::back(); ;
    }
}
