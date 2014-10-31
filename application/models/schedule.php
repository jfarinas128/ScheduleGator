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
		$current_selections = $this->format_days_periods($this->selected_courses);	//take current course elections set
		$generated_sql = array(); //indexed by course of reference against all others in list
		$returnval = $current_selections; //for debug only
		$debug = $this->generateSQL($current_selections);
		$tempsql = $debug[0];

		$generated_sql = $tempsql;
		$course_availability =  $debug[1];
		return array($returnval,$generated_sql,$course_availability, $debug[2]);
	}

	public function format_days_periods(&$sch) //formulate values for date/time periods into arrays
	{
		foreach($sch as $index => &$course_group)
		{
  			foreach($course_group as &$course)
  			{
  				if(!$this->checkIneligible($course, false))
  				{
   					$course['lecture_period_array'] = explode(',', $course['lecture_period_array']);
  					$course['lecture_day'] = str_split(preg_replace('/\s+/', '', $course['lecture_day']));
  				}
  			}
  		}
  		return $sch;
	}

	public function last(&$array, $key) 
	{
	    end($array);
	    return $key === key($array);
	}

	public function str_lreplace($search, $replace, $subject)
	{
	    $pos = strrpos($subject, $search);

	    if($pos !== false)
	    {
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }
	    return $subject;
	}

	public function generateSQL($current_selections)
	{
		$debug = array();
		$course_availability = $this->getCurrentSelectionAvailability($current_selections);
		$sql = "SELECT * FROM courses_professors WHERE ( course_name = ";
		$debug = $course_availability[2];
		$inel = $course_availability[3];
		foreach($current_selections as $index => $course_group)
		{
			foreach ($course_group as $course)
			{
				$cname = $course['course_name']; 
				$csection = $course['section'];
				$periods_to_check_against = $this->arrayRecursiveDiff($course_availability[0],array($course["ID"] => $course['lecture_period_array']));
				$days_to_check_against = $this->arrayRecursiveDiff($course_availability[1],array($course["ID"] => $course['lecture_day']));
				//we now have 2 list of lists containing days/periods of all OTHER (excluding the current) courses to be respected

				$sql .= "\"".$cname."\"".' AND section = '."\"".$csection."\" AND(";
				//$debug[$course['ID'].' period'] = $periods_to_check_against;
				//$debug[$course['ID'].' days'] = $days_to_check_against;
				$c = 0;
				foreach($days_to_check_against as $i => $day_list)
				{
					if($c == 0) 
						$sql .= "(";
					else $sql .= "OR(";
					foreach($day_list as $day)
						$sql .= ($day === reset($day_list)) ? " lecture_day NOT LIKE \"%".$day."%\"" : " AND lecture_day NOT LIKE \"%".$day."%\"";
					foreach($periods_to_check_against[$i] as $period)
						$sql .= " AND lecture_period_array NOT LIKE \"%".$period."%\"";
					$sql .= ")";
					$c++;
				}
				//$sql .= (!$this->last($current_selections, $index)) ? "\n )) OR ( course_name = " : "))";	//original code
				$sql .= "\n )) OR ( course_name = ";
				//BUG, if a course group that has more than one course is at the end of the $current_selections, then "\n )) OR ( course_name = " is rendered instead of "))"		
			}
		}
		$sql = $this->str_lreplace("OR ( course_name = ", "", $sql); //cheesy workaround for now
		return array($sql, $debug, $inel);
	}

	public function getCurrentSelectionAvailability(&$current_selections) //major method->returns discussions for all selections, removes ineligible courses from algorithm
	{
		$discussions = $ineligible_courses = $all_periods = $all_days = array(); //$discussions holds an array of discussions per each given course
		foreach($current_selections as $index => $course_group)
		{
			foreach ($course_group as $i => $course)
			{
				if(!$this->checkIneligible($course, false))
				{
					$results = $this->Course->get_discussion($course);
					foreach ($results as $result)//NEED TO format period/days of discussions once obtained
					{
						if($result && !$this->checkIneligible($result, true)) // as long as there are discussions
							if(!array_key_exists($course["ID"],$discussions))
								$discussions[$course["ID"]] = array($result);
							else array_push($discussions[$course["ID"]], $result);
					}
					$all_periods[$course["ID"]] = $course['lecture_period_array'];
					$all_days[$course["ID"]] = $course['lecture_day'];
				}
				else 
				{
					array_push($ineligible_courses,$course); //push the course to temp list 
					unset($course_group[$i]);				//then remove it to avoid algorithm issues
				}
			}
		}
		return array($all_periods, $all_days, $discussions, $ineligible_courses);
	}

	public function arrayRecursiveDiff($aArray1, $aArray2) 
	{ 
	    $aReturn = array(); 
	    foreach ($aArray1 as $mKey => $mValue) { 
	        if (array_key_exists($mKey, $aArray2)) { 
	            if (is_array($mValue)) { 
	                $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]); 
	                if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; } 
	            } else { 
	                if ($mValue != $aArray2[$mKey]) { 
	                    $aReturn[$mKey] = $mValue; 
	                } 
	            } 
	        } else { 
	            $aReturn[$mKey] = $mValue; 
	        } 
	    } 
	    return $aReturn; 
	} 

	public function checkIneligible($obj, $isDiscussion)//remove WEB and TBA courses -> values that don't equivocate to anything = ineligible
	{
		if(!$isDiscussion)
			return ($obj['lecture_day'] == 'TBA' || $obj['lecture_building'] == 'WEB' && $obj['lecture_room'] == 'WEB' || ($obj['lecture_day'] == '' && $obj['lecture_period'] == ''));
		else return ($obj['discussion_building'] == 'WEB' || ($obj['discussion_day'] == '' && $obj['discussion_period'] == '') );
	}

}
