<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $table = 'sections';

    public $timestamps = false;

    public function getCombinations($courseSections)
    {
        $combos_for_courses = array();
        $sections_for_courses = array();
        
        /* This section fetches all lectures for a course. For each lecture, it fetches all associated labs and tutorials. It then finds all combinations of lecture with its tutotials and labs and pushes them to an array called $combo_for_course. The combo_for_course is then pushed to an array called $combos_for_course which contains all combiations for a course (lecture, its tutorial and lab). Finally combos_for_course is pushed to an array called $combos_for_courses, which contains combos_for_course from all courses on the course list.*/
        foreach ($courseSections as $course => $sections_for_course)
        {
            $combos_for_course = array();

            //$sections_for_courses will be used later in the algorithm to find time conflicts between sections 
            $sections_for_courses = array_merge($sections_for_courses, $sections_for_course->toArray());

            $lectures = $sections_for_course->filter(function($bar) use($course)
            {
                if ($bar->type ==  "Lec") {
                return true;
                }
            });
            
            foreach ($lectures as $lecture)
            {
                $tutorials = $sections_for_course->filter(function($bar) use($lecture)
                {
                    if ($bar->type ==  "Tut" && $bar->section3 == $lecture->section3 ) {
                    return true;
                    }
                });
                $labs = $sections_for_course->filter(function($bar) use($lecture)
                {
                    if ($bar->type ==  "Lab" && $bar->section3 == $lecture->section3) {
                    return true;
                    }
                });
                if (count ($tutorials) > 0)
                {
                    foreach ($tutorials as $tutorial)
                    {
                        if (count ($labs) > 0 )
                        {
                            foreach ($labs as $lab)
                            {
                                $combo_for_course = array();
                                array_push ($combo_for_course, $lecture);
                                array_push ($combo_for_course, $tutorial);
                                array_push ($combo_for_course, $lab);
                                array_push ($combos_for_course, $combo_for_course);
                            }
                        }
                        else
                        {                               
                            $combo_for_course = array();
                            array_push ($combo_for_course, $lecture);
                            array_push ($combo_for_course, $tutorial);
                            array_push ($combos_for_course, $combo_for_course);                 
                        }
                    }
                }
                else if (count ($labs) > 0 )
                {
                    foreach ($labs as $lab)
                    {
                        $combo_for_course = array();
                        array_push ($combo_for_course, $lecture);
                        array_push ($combo_for_course, $lab);
                        array_push ($combos_for_course, $combo_for_course);
                    }
                }
                else
                {
                    $combo_for_course = array();
                    array_push ($combo_for_course, $lecture);
                    array_push ($combos_for_course, $combo_for_course);
                }           
            }
            array_push ($combos_for_courses, $combos_for_course);
        }

        /*this section creates takes each section for each course on the course list and creates an array of its meeting times. The array has an elements with keys: section_id, start, end. start and end are arrays themselvelves becaseu a section can have many meetings in a week. The meeting times are transformed to be compared with each other their start and end times are formed by concatinating the hour of day they meet (24 hour format and always 2 digits) with the minute they meet (always 2 digits). Then the day they meet is translated to a number for that day and added to the fron of the string. In this way two sections times can be compared.*/     
        $sections_day_times = array();
        $conversion = array();
        $conversion["M"] = "1";
        $conversion["T"] = "2";
        $conversion["W"] = "3";
        $conversion["J"] = "4";
        $conversion["F"] = "5";
        foreach ($sections_for_courses as $section)
        {
            $section_day_times = array();
            $days = array();
            $temp4 = trim ($section["days"],'-');
            if (strlen($temp4) > 1 )
                $days = explode("-",$temp4);
            else 
                array_push ($days,$temp4);
            $start = explode(":",$section["start"]);
            $end = explode(":",$section["end"]);
            $section_day_times["start"] = array();
            $section_day_times["end"] = array();
            foreach($days as $day)
            {
                array_push ($section_day_times["start"], $conversion[$day].$start[0].$start[1] );               
                array_push ($section_day_times["end"], $conversion[$day].$end[0].$end[1] );
            }
            $section_day_times ["section_id"] = $section["id"];
            $sections_day_times[$section["id"]] = $section_day_times ;
        }
        
        /* This section emplys the section combinations and timing structure produced above to create combinations of possible schedules and at the same time checking for scheduling conflicts, thereby reducing complexity. For each course, each combination is added to $all_combinations array. Then for the following course, for each of its combinations, $all_combinations is multiplied and its combination added to it. After a  course has multiplied and added its combinations to all_combinations, each combination in all_combinations is checked for schedule conflicts. If found they are removed, thus reducing complexity by not adding more combiantions to a combination which already has a timing conflict. Before being optimized, combinations were built up before they were checked for time conflicts. For 5 courses there were 85 000 000 combinations. */
        $conflicting_combinations = array();
        $flag = false;
        $all_combinations = array();
        foreach ($combos_for_courses as $combos_for_course)
        {           
            if ( count ($all_combinations) == 0 )
            {
                foreach ($combos_for_course as $combo_for_course)//
                {
                    array_push ($all_combinations, $combo_for_course);
                }
            }
            else
            {
                $temp2 = $all_combinations;
                $all_combinations = array();
                foreach ($temp2 as $t)
                {
                    foreach ($combos_for_course as $combo)
                    {   
                        $temp3 = array_merge ($t , $combo);
                        array_push ($all_combinations, $temp3);
                    }
                }
            }
            foreach ($all_combinations as $combination)
            {
                foreach ($combination as $section1)
                { 
                    if ($flag == false )
                    {
                        foreach ($combination as $section2)
                        {
                            if ($section1 != $section2 && $flag == false)
                            {
                                for ($i = 0 ; $i < count ($sections_day_times[$section1->id]["start"]) ; $i++)
                                {
                                    for ($j = 0 ; $j < count ($sections_day_times[$section2->id]["start"]) ; $j++ )
                                    {
                                        if (($sections_day_times[$section1->id]["start"][$i] > $sections_day_times[$section2->id]["start"][$j] && $sections_day_times[$section1->id]["start"][$i] < $sections_day_times[$section2->id]["end"][$j]) || ($sections_day_times[$section1->id]["end"][$i] > $sections_day_times[$section2->id]["start"][$j] && $sections_day_times[$section1->id]["end"][$i] < $sections_day_times[$section2->id]["end"][$j]))
                                            $flag = true;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($flag == true)
                {
                    array_push ($conflicting_combinations, $combination);
                    $key = array_search($combination, $all_combinations);
                    unset($all_combinations[$key]);
                }
                $flag = false;
            }
        }

        return $all_combinations;
        // print ("count of all combinations before conflict check: ");
        // print (count ($all_combinations) . '<br>');     

        // print ("count of all combinations after conflict check: ");
        // print (count ($all_combinations) . '<br>');
        // return view('getcombinations', compact('combos_for_courses', 'all_combinations', 'conflicting_combinations'));
    }

    /**
     * Get all sections that are to be used in the schedule combinations
     */
    public function getSectionsForScheduler($request)
    {
    	//get all the courses needed to pass to the get combinations method
		$courses = $request->get('courses');
        
		$section = new Section;
		$sections = $section
			->whereIn('course', $courses)
            ->where('semester', '=', 'fall')
			->applyPreferences()
			->get();

		$courses = $sections->groupBy('course');

        return $courses;
    }

    public function scopeApplyPreferences($query)
    {


    	return $query;
    }
}
