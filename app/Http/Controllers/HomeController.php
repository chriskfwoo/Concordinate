<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\User;
use App\Section;
use App\Course;
use Auth;

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
         if($schedules == null){
           $schedules = [];
        }
        return view('viewSchedule', [
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

        return Redirect::to('completed')->with('completed', $completedCourses);

        // @if (in_array('COMP248', $completedCourses)) checked="checked" @endif
    }

}
