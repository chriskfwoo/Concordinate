<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function schedulerView()
    {
        return view('scheduler');
    }

    public function viewScheduleView()
    {
        return view('viewSchedule');
    }

    public function completedCoursesView()
    {
        $array = ['COMP232' => 1];

        return view('completed-courses', [
                'courses' => $array
            ]);
    }

    public function saveCompletedCourses(Request $request) {
         dd($request);
    }

}
