<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Section;
use App\Course;
use Auth;

require('simple_html_dom.php');

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

    $html = file_get_html('https://aits.encs.concordia.ca/oldsite/resources/schedules/courses/?y=2016&s=4/index.php');

    $maincontent = $html->find('div[id=maincontent]');
    $tableRows = $maincontent[0]->first_child()->last_child()->children(10)->children(1);
    
    dd('scraping method');
    foreach ($tableRows->children() as $row) {

        $href       = $row->children(0)->children(0)->getAttribute('href');
        $newUrl     = html_entity_decode('https://aits.encs.concordia.ca/oldsite/resources/schedules/courses/' . $href);
        $newHtml    = file_get_html($newUrl);
        $tables     = $newHtml->find('table');
        $courseName = substr($href, strpos($href, "c=")+2);

        // echo $courseName . " ";

        if (count($tables) > 1) {
            $table = $tables[1];
        } else {
            $table = $tables[0];
        }
        
        $tableRows = $table->find('tr');
        
        for ($i = 1; $i < count($tableRows); $i++) {
            $row = $tableRows[$i];
            $td  = $row->find('td');
            
            $type       = $td[0]->innertext;
            $section1   = $td[1]->innertext;
            $section2   = $td[2]->innertext;
            $section3   = $td[3]->innertext;
            $days       = $td[4]->innertext;
            $start      = $td[5]->innertext;
            $end        = $td[6]->innertext;
            $room       = $td[7]->innertext;
            $instructor = $td[8]->innertext;
            $semester   = "winter";

            $section = new Section;

            $section->course    = $courseName;
            $section->type      = $type;
            $section->section1  = $section1;
            $section->section2  = $section2;
            $section->section3  = $section3;
            $section->days      = $days;
            $section->start     = $start;
            $section->end       = $end;
            $section->room      = $room;
            $section->instructor = $instructor;
            $section->semester = $semester;

            $section->save();

        }

        //if the course exists, add a 1 to the course table for that course.
        //if course does not exist, add that course.
        // $course = Course::find($courseName);
        // if ($course) {
        //     $course->winter_semester = 1;
        //     $course->save();
        //     echo "saved a existing one <br>";
        // } else {
        //     $course = new Course;
        //     $course->id = $courseName;
        //     $course->name = "dummy";
        //     $course->fall_semester = 0;
        //     $course->winter_semester = 1;
        //     $course->priority = 0;
        //     $course->save();
        //     echo "saved NEW <br>";
        // }

        // echo 'saved';
    }
        dd('hi');
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
