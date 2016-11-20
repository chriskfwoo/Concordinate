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
                // print ($lecture->course . " ". $lecture->section1. '<br>');
                $tutorials = $sections_for_course->filter(function($bar) use($lecture)
                {
                    if ($bar->type ==  "Tut" && $bar->section3 == $lecture->section3 ) {
                    return true;
                    }
                });
                // print("turtorials before ".count ($tutorials).'<br>'  );
                //determines if sections with the same lecture have the same day- time, if so pushes ids to array
                $bar2 = array();//holds sections with same lecture and day-time
                if (is_null($bar2))
                    print("its null");
                $bar3 = $tutorials->toArray();
                $bar3 = array_values($bar3);
                $tutorials = $tutorials-> keyBy("id");
                //var_dump ($tutorials);
                //foreach($bar3 as $sec)
                 //  print($sec["id"]. '<br>');
                for ($i = 0 ; $i < (count ($bar3) -1)  ; $i++)
                {
                    //print ($bar3[$i]["id"]);
                    for ($j = $i+1 ; $j < count ($bar3) ; $j++)
                    {
                        //print ($bar3[$j]["id"]);
                         if ($bar3[$i]["days"] == $bar3[$j]["days"])
                        {
                            if ($bar3[$i]["start"] == $bar3[$j]["start"])
                            {
                               array_push ($bar2,$bar3[$j]["id"]);
                               if ($tutorials->contains($bar3[$j]["id"]))
                                {
                                    // print ("yes it contains it".'<br>' );
                                    $tutorials->forget($bar3[$j]["id"]);
                                }
                                if ($tutorials->contains($bar3[$j]["id"]))
                                {
                                    // print ("it still contains it".'<br>' );
                                }
                            }
                            
                        }
                    }
                }
                
                //foreach($tutorials as $sec)
                 //  print($sec["id"].
                //var_dump ($bar2);
                $labs = $sections_for_course->filter(function($bar) use($lecture)
                {
                    if ($bar->type ==  "Lab" && $bar->section3 == $lecture->section3) {
                    return true;
                    }
                });
                $bar3 = $labs->toArray();
                $bar3 = array_values($bar3);
                $labs = $labs-> keyBy("id");
                // print("labs before ".count ($labs).'<br>' );
                for ($i = 0 ; $i < (count ($bar3) -1)  ; $i++)
                {
                    for ($j = $i+1 ; $j < count ($bar3) ; $j++)
                    {
                        if ($bar3[$i]["days"] == $bar3[$j]["days"])
                        {
                            if ($bar3[$i]["start"] == $bar3[$j]["start"])
                            {
                               if ($labs->contains($bar3[$j]["id"]))
                                {
                                    // print ("yes labs it contains it".'<br>' );
                                    $labs->forget($bar3[$j]["id"]);
                                }
                                if ($labs->contains($bar3[$j]["id"]))
                                {
                                    // print ("it still contains it".'<br>' );
                                }
                            }
                            
                        }
                    }
                }
                // print("labs after ".count ($labs).'<br>' );
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
        $conversion[""] = "0";
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
            //print ("size of combo for course : ".count ($combos_for_course).'<br>');
            if ( count ($all_combinations) == 0 )
            {
                foreach ($combos_for_course as $combo_for_course)//
                {
                    array_push ($all_combinations, $combo_for_course);
                }
            }
            else
            {
                //this is the number of sections that make a course combination, it is for an optimization that only checks newly added combos for course against $all_combinations that have alredy been checked for conflicts
                $r = count ($combos_for_course[0]);
                // print ("size of combo for course : ".$r.'<br>');
                // foreach ($combos_for_course as $combo)
                // {
                    // foreach ($combo as $section)
                        // print ($section->id.'<br>');
                // }
                
                $temp2 = $all_combinations;
                $all_combinations = array();
                foreach ($temp2 as $t)
                {
                    foreach ($combos_for_course as $combo)
                    {   
                        $temp3 = array_merge ( $t , $combo );
                        array_push ($all_combinations, $temp3);
                    }
                }
                //var_dump ($all_combinations);
                //return;
                // print ("size of all comb : ".count ($all_combinations).'<br>');
                $b = 0;
                foreach ($all_combinations as $combination)
                {
                    $combination= array_values ($combination);
                    // print ("size of comb : ".count ($combination).'<br>');
                    // print ($b++);
                    for ( $o = 0 ; $o < (count ($combination) - $r ); $o++)//$combination as $section1)
                    { 
                            for ( $p = (count ($combination) - $r ); $p < count ($combination) ; $p++) // $combination as $section2)
                            { 
                                // print ($combination[$o]->id." ".$combination[$p]->id." ".$o." ".$p.'<br>' );
                            //  print ($sections_day_times[$combination[$o]->id]["section_id"]." ".$sections_day_times[$combination[$p]->id]["section_id"]." ".$o." ".$p.'<br>' );
                                    for ($i = 0 ; $i < count ($sections_day_times[$combination[$o]->id]["start"]) ; $i++)
                                    {
                                        for ($j = 0 ; $j < count ($sections_day_times[$combination[$p]->id]["start"]) ; $j++ )
                                        {
                                            
                                            if (($sections_day_times[$combination[$o]->id]["start"][$i] > $sections_day_times[$combination[$p]->id]["start"][$j] && $sections_day_times[$combination[$o]->id]["start"][$i] < $sections_day_times[$combination[$p]->id]["end"][$j] || ($sections_day_times[$combination[$o]->id]["end"][$i] > $sections_day_times[$combination[$p]->id]["start"][$j] )&& $sections_day_times[$combination[$o]->id]["end"][$i] < $sections_day_times[$combination[$p]->id]["end"][$j]||
                                            $sections_day_times[$combination[$p]->id]["start"][$j] > $sections_day_times[$combination[$o]->id]["start"][$i] && $sections_day_times[$combination[$p]->id]["start"][$j] < $sections_day_times[$combination[$o]->id]["end"][$i] || ($sections_day_times[$combination[$p]->id]["end"][$j] > $sections_day_times[$combination[$o]->id]["start"][$i] )&& $sections_day_times[$combination[$p]->id]["end"][$j] < $sections_day_times[$combination[$o]->id]["end"][$i]))
                                            {
                                                $flag = true;
                                                // print ("flag is true");
                                                break 4;
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
        }
        
        return $all_combinations;
    }

        // /* This section fetches all lectures for a course. For each lecture, it fetches all associated labs and tutorials. It then finds all combinations of lecture with its tutotials and labs and pushes them to an array called $combo_for_course. The combo_for_course is then pushed to an array called $combos_for_course which contains all combiations for a course (lecture, its tutorial and lab). Finally combos_for_course is pushed to an array called $combos_for_courses, which contains combos_for_course from all courses on the course list.*/
        // foreach ($courseSections as $course => $sections_for_course)
        // {
        //     $combos_for_course = array();

        //     //$sections_for_courses will be used later in the algorithm to find time conflicts between sections 
        //     $sections_for_courses = array_merge($sections_for_courses, $sections_for_course->toArray());

        //     $lectures = $sections_for_course->filter(function($bar) use($course)
        //     {
        //         if ($bar->type ==  "Lec") {
        //         return true;
        //         }
        //     });
            
        //     foreach ($lectures as $lecture)
        //     {
        //         $tutorials = $sections_for_course->filter(function($bar) use($lecture)
        //         {
        //             if ($bar->type ==  "Tut" && $bar->section3 == $lecture->section3 ) {
        //             return true;
        //             }
        //         });
        //         $labs = $sections_for_course->filter(function($bar) use($lecture)
        //         {
        //             if ($bar->type ==  "Lab" && $bar->section3 == $lecture->section3) {
        //             return true;
        //             }
        //         });
        //         if (count ($tutorials) > 0)
        //         {
        //             foreach ($tutorials as $tutorial)
        //             {
        //                 if (count ($labs) > 0 )
        //                 {
        //                     foreach ($labs as $lab)
        //                     {
        //                         $combo_for_course = array();
        //                         array_push ($combo_for_course, $lecture);
        //                         array_push ($combo_for_course, $tutorial);
        //                         array_push ($combo_for_course, $lab);
        //                         array_push ($combos_for_course, $combo_for_course);
        //                     }
        //                 }
        //                 else
        //                 {                               
        //                     $combo_for_course = array();
        //                     array_push ($combo_for_course, $lecture);
        //                     array_push ($combo_for_course, $tutorial);
        //                     array_push ($combos_for_course, $combo_for_course);                 
        //                 }
        //             }
        //         }
        //         else if (count ($labs) > 0 )
        //         {
        //             foreach ($labs as $lab)
        //             {
        //                 $combo_for_course = array();
        //                 array_push ($combo_for_course, $lecture);
        //                 array_push ($combo_for_course, $lab);
        //                 array_push ($combos_for_course, $combo_for_course);
        //             }
        //         }
        //         else
        //         {
        //             $combo_for_course = array();
        //             array_push ($combo_for_course, $lecture);
        //             array_push ($combos_for_course, $combo_for_course);
        //         }           
        //     }
        //     array_push ($combos_for_courses, $combos_for_course);
        // }

        // /*this section creates takes each section for each course on the course list and creates an array of its meeting times. The array has an elements with keys: section_id, start, end. start and end are arrays themselvelves becaseu a section can have many meetings in a week. The meeting times are transformed to be compared with each other their start and end times are formed by concatinating the hour of day they meet (24 hour format and always 2 digits) with the minute they meet (always 2 digits). Then the day they meet is translated to a number for that day and added to the fron of the string. In this way two sections times can be compared.*/     
        // $sections_day_times = array();
        // $conversion = array();
        // $conversion["M"] = "1";
        // $conversion["T"] = "2";
        // $conversion["W"] = "3";
        // $conversion["J"] = "4";
        // $conversion["F"] = "5";
        // foreach ($sections_for_courses as $section)
        // {
        //     $section_day_times = array();
        //     $days = array();
        //     $temp4 = trim ($section["days"],'-');
        //     if (strlen($temp4) > 1 )
        //         $days = explode("-",$temp4);
        //     else 
        //         array_push ($days,$temp4);
        //     $start = explode(":",$section["start"]);
        //     $end = explode(":",$section["end"]);
        //     $section_day_times["start"] = array();
        //     $section_day_times["end"] = array();
        //     foreach($days as $day)
        //     {
        //         array_push ($section_day_times["start"], $conversion[$day].$start[0].$start[1] );               
        //         array_push ($section_day_times["end"], $conversion[$day].$end[0].$end[1] );
        //     }
        //     $section_day_times ["section_id"] = $section["id"];
        //     $sections_day_times[$section["id"]] = $section_day_times ;
        // }
        
        // /* This section emplys the section combinations and timing structure produced above to create combinations of possible schedules and at the same time checking for scheduling conflicts, thereby reducing complexity. For each course, each combination is added to $all_combinations array. Then for the following course, for each of its combinations, $all_combinations is multiplied and its combination added to it. After a  course has multiplied and added its combinations to all_combinations, each combination in all_combinations is checked for schedule conflicts. If found they are removed, thus reducing complexity by not adding more combiantions to a combination which already has a timing conflict. Before being optimized, combinations were built up before they were checked for time conflicts. For 5 courses there were 85 000 000 combinations. */
        // $conflicting_combinations = array();
        // $flag = false;
        // $all_combinations = array();
        // foreach ($combos_for_courses as $combos_for_course)
        // {           
        //     if ( count ($all_combinations) == 0 )
        //     {
        //         foreach ($combos_for_course as $combo_for_course)//
        //         {
        //             array_push ($all_combinations, $combo_for_course);
        //         }
        //     }
        //     else
        //     {
        //         $temp2 = $all_combinations;
        //         $all_combinations = array();
        //         foreach ($temp2 as $t)
        //         {
        //             foreach ($combos_for_course as $combo)
        //             {   
        //                 $temp3 = array_merge ($t , $combo);
        //                 array_push ($all_combinations, $temp3);
        //             }
        //         }
        //     }
        //     foreach ($all_combinations as $combination)
        //     {
        //         foreach ($combination as $section1)
        //         { 
        //             if ($flag == false )
        //             {
        //                 foreach ($combination as $section2)
        //                 {
        //                     if ($section1 != $section2 && $flag == false)
        //                     {
        //                         for ($i = 0 ; $i < count ($sections_day_times[$section1->id]["start"]) ; $i++)
        //                         {
        //                             for ($j = 0 ; $j < count ($sections_day_times[$section2->id]["start"]) ; $j++ )
        //                             {
        //                                 if (($sections_day_times[$section1->id]["start"][$i] > $sections_day_times[$section2->id]["start"][$j] && $sections_day_times[$section1->id]["start"][$i] < $sections_day_times[$section2->id]["end"][$j]) || ($sections_day_times[$section1->id]["end"][$i] > $sections_day_times[$section2->id]["start"][$j] && $sections_day_times[$section1->id]["end"][$i] < $sections_day_times[$section2->id]["end"][$j]))
        //                                     $flag = true;
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //         if ($flag == true)
        //         {
        //             array_push ($conflicting_combinations, $combination);
        //             $key = array_search($combination, $all_combinations);
        //             unset($all_combinations[$key]);
        //         }
        //         $flag = false;
        //     }
        // }

        // return $all_combinations;
        // // print ("count of all combinations before conflict check: ");
        // // print (count ($all_combinations) . '<br>');     

        // // print ("count of all combinations after conflict check: ");
        // // print (count ($all_combinations) . '<br>');
        // // return view('getcombinations', compact('combos_for_courses', 'all_combinations', 'conflicting_combinations'));
    

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
