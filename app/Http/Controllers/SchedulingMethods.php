<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Section;

class SchedulingMethods extends Controller
{
    public function getCombinations($courses)
    {
	    $sections = Section::all();
	    // $courses = array( "ENGR202", "ENCS282", "ELEC275");
		$combos_for_courses = array();
		$sections_for_courses = array();
		foreach ($courses as $course)
		{
			$combos_for_course = array();
		    $sections_for_course = $sections->filter(function($album) use($course)
			{
				if ($album->course ==  $course) {
                return true;
				}
			});
			$sections_for_courses = array_merge($sections_for_courses, $sections_for_course->toArray());
			$lectures = $sections_for_course->filter(function($album) use($course)
			{
				if ($album->type ==  "  Lec    ") {
                return true;
				}
			});
			foreach ($lectures as $lecture)
			{
				$tutorials = $sections_for_course->filter(function($album) use($lecture)
				{
					if ($album->type ==  "  Tut    " && $album->section3 == $lecture->section3 ) {
					return true;
					}
				});
				$labs = $sections_for_course->filter(function($album) use($lecture)
				{
					if ($album->type ==  "  Lab   " && $album->section3 == $lecture->section3) {
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
		//return view('tester', compact('combos_for_courses'));	
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
		}
		print ("count of all combinations before conflict check: ");
		print (count ($all_combinations) . '<br>');
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
		$conflicting_combinations = array();
		$flag = false;
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
		return view('getcombinations', compact('combos_for_courses', 'all_combinations', 'conflicting_combinations'));
    }
}
