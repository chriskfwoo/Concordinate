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
        return view('viewSchedule');
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


    public function scraping()
    {
        $url = 'https://www.concordia.ca/encs/students/course-schedules.html';
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        dd($data);   // Returning the data from the function
        
    }

}
