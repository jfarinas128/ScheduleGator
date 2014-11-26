<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//IF all sections of a given course are selected, and some are web/ineligible and some aren't, AND the algorithm fails due to that course
//don't consider it a failure if the same named course is in the 
class Schedule extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('nativesession');
		$this->load->model("Course");
		$this->selected_courses = $this->nativesession->get('tempcourses');
	}

	public function make_schedule()
	{
		$current_selections = $this->format_days_periods($this->selected_courses, false);	//take current course elections set
		$generated_sql = array(); //indexed by course of reference against all others in list
		$returnval = $current_selections; //for debug only
		$debug = $this->generateSQL($current_selections);
		$tempsql = $debug[0];

		$generated_sql = $tempsql;
		$course_availability =  $debug[1];
		return array($returnval,$generated_sql,$course_availability, $debug[2]);
	}

	public function format_days_periods(&$sch, $isDiscussion) //formulate values for date/time periods into arrays
	{
		foreach($sch as &$course_group)
		{
  			foreach($course_group as &$course)
  			{
  				if(!$isDiscussion && !$this->checkIneligible($course, false))
  				{
   					$course['lecture_period_array'] = explode(',', $course['lecture_period_array']);
  					$course['lecture_day'] = str_split(preg_replace('/\s+/', '', $course['lecture_day']));
  				}
  				elseif($isDiscussion && !$this->checkIneligible($course, true))
  				{
   					$course['discussion_period_array'] = explode(',', $course['discussion_period_array']);
  					$course['discussion_day'] = str_split(preg_replace('/\s+/', '', $course['discussion_day']));
  				}
  			}
  		}
  		return $sch;
	}

	public function generateSQL($current_selections)
	{
		//$debug = array();
		$course_availability = $this->getCurrentSelectionAvailability($current_selections);
		$sql = "SELECT * FROM courses_professors WHERE ( course_name = ";
		$discussions = $course_availability["discussions"];
		$ineligible_courses = $course_availability["ineligible_courses"];
		$multiple_courses = $course_availability["grouped_courses"];
		foreach($current_selections as $index => $course_group)
		{
			foreach ($course_group as $course)
			{
				$count_multiple = 0;
				$last_multiple = false;
				$cname = $course['course_name']; 
				$csection = $course['section'];
				$periods_to_check_against = $this->arrayRecursiveDiff($course_availability["periods_to_check_against"],array($course["ID"] => $course['lecture_period_array']));
				$days_to_check_against = $this->arrayRecursiveDiff($course_availability["days_to_check_against"],array($course["ID"] => $course['lecture_day']));
				//we now have 2 list of lists containing lecture days/periods of all OTHER (excluding the current) courses to be respected
				//discussions can be thrown on top of this with no need for arrayRecursiveDiff

				$sql .= "\"".$cname."\"".' AND section = '."\"".$csection."\" AND(";
				$c = 0;
<<<<<<< HEAD
				foreach($days_to_check_against as $i => $day_list) //$i is ID number of course
=======
				foreach($days_to_check_against as $i => $day_list) //$i is ID number 
>>>>>>> origin/master
				{
					if($this->in_array_r($i, $multiple_courses)) //one of multiple courses in a given group (EEL3111C i.e)
					{
						$count_multiple += 1;
						if($count_multiple == 1)
						{
							if($c == 0) 
								$sql .= "(";
							else $sql .= "AND(";
						}
						elseif($count_multiple > 1)
							$sql .= " OR ";
						$last_multiple = true;

						foreach($day_list as $day)
							$sql .= ($day === reset($day_list)) ? " ((lecture_day NOT LIKE \"%".$day."%\"" : " AND lecture_day NOT LIKE \"%".$day."%\"";
						$sql .= ") OR ";
						foreach($day_list as $day)
							$sql .= ($day === reset($day_list)) ? " (lecture_day LIKE \"%".$day."%\"" : " AND lecture_day LIKE \"%".$day."%\"";

						foreach($periods_to_check_against[$i] as $period)
							$sql .= " AND lecture_period_array NOT LIKE \"%".$period."%\"";
<<<<<<< HEAD
=======

>>>>>>> origin/master
					}
					else
					{
						if($last_multiple)
						{
							$sql .= ")";
							$last_multiple = false;
						}
						if($c == 0) 
							$sql .= "(";
						else $sql .= "AND(";

						foreach($day_list as $day)
							$sql .= ($day === reset($day_list)) ? " (lecture_day NOT LIKE \"%".$day."%\"" : " AND lecture_day NOT LIKE \"%".$day."%\"";
						$sql .= ") OR ";
						foreach($day_list as $day)
							$sql .= ($day === reset($day_list)) ? " (lecture_day LIKE \"%".$day."%\"" : " AND lecture_day LIKE \"%".$day."%\"";

						foreach($periods_to_check_against[$i] as $period)
							$sql .= " AND lecture_period_array NOT LIKE \"%".$period."%\"";
<<<<<<< HEAD
=======
	/* //ADDING IN DISCUSSIONS 
						foreach ($discussions[$i] as $cid => $discussion)
						{
							foreach($discussion['discussion_day'] as $dday)
							{
								$sql .= " AND lecture_day NOT LIKE \"%".$dday."%\"";
							}
							foreach($discussion['discussion_period_array'] as $dperiod)
							{
								$sql .= " AND lecture_period_array NOT LIKE \"%".$dperiod."%\"";
							}
						}
	*/
>>>>>>> origin/master
					}
					$sql .= "))";
					$c++;
				}
				//$sql .= (!$this->last($current_selections, $index)) ? "\n )) OR ( course_name = " : "))";	//original code
				if($last_multiple)
<<<<<<< HEAD
					$sql .= " ) ";
				//else $sql .= " ";
	//ADDING IN DISCUSSIONS VS LECTURE (NOT DICSUSSION VS DISCUSSION) ALSO NOT (DISCUSSION OF A 'MULTIPLE' COURSE course where any discussion of the course is not mutually exclusive) )
				if(!empty($discussions))
				{
					$sql .= "\n #Starting discussions now \n";
					foreach($discussions as $course_id => $discussion_group)
					{
						$sql .= "  AND (";
						foreach ($discussion_group as $cid => $discussion)
						{
							foreach($discussion['discussion_day'] as $dday)
								$sql .= ($dday === reset($discussion['discussion_day'])) ? " (lecture_day NOT LIKE \"%".$dday."%\"" : " AND lecture_day NOT LIKE \"%".$dday."%\"";
							$sql .= ") OR ";
							foreach($discussion['discussion_day'] as $dday)
								$sql .= ($dday === reset($discussion['discussion_day'])) ? " (lecture_day LIKE \"%".$dday."%\"" : " AND lecture_day LIKE \"%".$dday."%\"";
							foreach($discussion['discussion_period_array'] as $dperiod)
								$sql .= " AND lecture_period_array NOT LIKE \"%".$dperiod."%\"";
						}	
						$sql .= " ))";
					}
				}
				$sql .= " )) OR ( course_name = ";
=======
					$sql .= "\n ))) OR ( course_name = ";
				else $sql .= "\n )) OR ( course_name = ";
>>>>>>> origin/master
				//BUG, if a course group that has more than one course is at the end of the $current_selections, then "\n )) OR ( course_name = " is rendered instead of "))"		
			}
		}
		$sql = $this->str_lreplace("OR ( course_name = ", "", $sql); //cheesy workaround for now
		return array($sql, $discussions, $ineligible_courses);
	}

	public function getCurrentSelectionAvailability(&$current_selections) //major method->returns discussions for all selections, removes ineligible courses from algorithm
	{
		$discussions = $ineligible_courses = $all_periods = $all_days = $multiple_courses = array(); //$discussions holds an array of discussions per each given course
		foreach($current_selections as $index => &$course_group)
		{
			$isMultiple = (count($course_group) > 1);
			$multiple_courses[$index] = array();
			foreach ($course_group as $i => &$course)
			{
				if(!$this->checkIneligible($course, false))
				{
					if($isMultiple)
						array_push($multiple_courses[$index], $course["ID"]);
					$results = $this->Course->get_discussion($course);
					foreach ($results as $result)
					{
						if($result && !$this->checkIneligible($result, true)) // as long as there are discussions that are eligible 
						{
							if(!array_key_exists($course["ID"],$discussions))
								$discussions[$course["ID"]] = array($result);
							else array_push($discussions[$course["ID"]], $result);
						}
					}
					$all_periods[$course["ID"]] = $course['lecture_period_array'];
					$all_days[$course["ID"]] = $course['lecture_day'];
				}
				else 
				{
					array_push($ineligible_courses,$course); //push the course to temp list 
					unset($course_group[$i]);				//then remove it to avoid algorithm issues
					$course_group = array_values($course_group);
				}
			}
		}
		return array("periods_to_check_against" => $all_periods, "days_to_check_against" => $all_days, "discussions" => $this->format_days_periods($discussions, true),
					 "ineligible_courses" => $ineligible_courses, "grouped_courses" => $multiple_courses);
	}

	public function arrayRecursiveDiff($aArray1, $aArray2) 
	{ 
	    $aReturn = array(); 
	    foreach ($aArray1 as $mKey => $mValue) 
	    { 
	        if (array_key_exists($mKey, $aArray2)) 
	        { 
	            if (is_array($mValue)) 
	            {
	                $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]); 
	                if (count($aRecursiveDiff)) 
<<<<<<< HEAD
	                	$aReturn[$mKey] = $aRecursiveDiff; 
=======
	                { 
	                	$aReturn[$mKey] = $aRecursiveDiff; 
	                } 
>>>>>>> origin/master
	            } 
	            else 
	            { 
	                if ($mValue != $aArray2[$mKey]) 
<<<<<<< HEAD
=======
	                { 
>>>>>>> origin/master
	                    $aReturn[$mKey] = $mValue; 
	            } 
<<<<<<< HEAD
=======
	        } 
	        else 
	        { 
	            $aReturn[$mKey] = $mValue; 
>>>>>>> origin/master
	        } 
	        else  
	            $aReturn[$mKey] = $mValue; 
	    } 
	    return $aReturn; 
	} 

	public function in_array_r($needle, $haystack, $strict = false) 
	{
	    foreach ($haystack as $item) 
<<<<<<< HEAD
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) 
	            return true;
=======
	    {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }
>>>>>>> origin/master
    	return false;
	}
/*
	public function findKey($array, $keySearch) 
	{
	    foreach ($array as $key => $item)
	    {
	        if ($key == $keySearch)
	            return true;
	        elseif(isset($array[$key]))
	        	$this->findKey($array[$key], $keySearch);
	    }
	    return false;
	}
*/
	public function str_lreplace($search, $replace, $subject)
	{
	    $pos = strrpos($subject, $search);
<<<<<<< HEAD
	    if($pos !== false)
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
=======

	    if($pos !== false)
	    {
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }
>>>>>>> origin/master
	    return $subject;
	}

	public function checkIneligible($obj, $isDiscussion)//remove WEB and TBA courses -> values that don't equivocate to anything = ineligible
	{
		if(!$isDiscussion)
			return ($obj['lecture_day'] == 'TBA' || $obj['lecture_building'] == 'WEB' && $obj['lecture_room'] == 'WEB' || ($obj['lecture_day'] == '' && $obj['lecture_period'] == ''));
		else return ($obj['discussion_building'] == 'WEB' || ($obj['discussion_day'] == '' && $obj['discussion_period'] == '') );
	}

}
