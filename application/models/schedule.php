<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('nativesession');
		$this->load->model("Course");
		$this->selected_courses = $this->nativesession->get('tempcourses');
	}

	public function make_date_time(&$sch) //formulate values for date/time periods into arrays
	{
		foreach($sch as $index => &$course_group)
		{
  			foreach($course_group as &$course)
  			{
  				$course['lecture_period_array'] = explode(',', $course['lecture_period_array']);
  				if($course['lecture_day'] != 'TBA' && $course['lecture_day'] != '')
  					$course['lecture_day'] = str_split(preg_replace('/\s+/', '', $course['lecture_day']));
  			}
  		}
  		return $sch;
	}

	public function make_schedule()
	{
		$current_selections = $this->make_date_time($this->selected_courses);	//take current course elections set
		$generated_sql = array(); //indexed by course of reference against all others in list
		$returnval = $current_selections; //for debug only
		$tempsql = $this->addCourseNameSectionSQL($current_selections);
		while(!empty($current_selections))//For each course (in group) get list of open dates/times (should stop at smallest or 2nd smallest)
		{
			$current_course_group = min($current_selections);	//get smallest from remaining courses
			$key = array_search($current_course_group, $current_selections);	
			foreach($current_course_group as &$course) //get open days/periods for a given course
				$tempsql .= $this->addCourseDaysPeriodsSQL($course);
			unset($current_selections[$key]);
		}
		$generated_sql = $tempsql;
		return array($returnval,$generated_sql);
	}

	public function last(&$array, $key) 
	{
	    end($array);
	    return $key === key($array);
	}

	public function addCourseNameSectionSQL($current_selections) //List of courses (names and sections only), current course to build against
	{
		$sql = "SELECT * FROM courses_professors WHERE ((course_name = ";
		foreach($current_selections as $index => $course_group)
		{
			foreach ($course_group as $course)
			{
				$cname = $course['course_name']; 
				$csection = $course['section'];
				if (!$this->last($current_selections, $index))
					$sql .= "\"".$cname."\"".' AND section = '."\"".$csection."\")".' OR (course_name = ';
				else $sql .= "\"".$cname."\"".' AND section = '."\"".$csection."\"))";
			}
		}
		return $sql;

	}

	public function addCourseDaysPeriodsSQL($course)
	{
		//REFACTOR -> ADD this for loop into the end of the other, so statement is : AND (lecture_day NOT LIKE ...   AND lecture_period_array NOt LIKE...)
		//grouping day and times together
		$sql = " AND ((lecture_day NOT LIKE \"%";
		foreach ($course['lecture_day'] as $index => $day)
		{
			if (!$this->last($course['lecture_day'], $index))
				$sql .= $day."%\")"." AND (lecture_day NOT LIKE \"%";
			else $sql .= $day."%\"))";
		}
		$sql.= " AND ((lecture_period_array NOT LIKE \"%";
		foreach ($course['lecture_period_array'] as $index => $period)
		{
			if (!$this->last($course['lecture_period_array'], $index))
				$sql .= $period."%\")"." AND (lecture_period_array NOT LIKE \"%";
			else $sql .= $period."%\"))";
		}
		return $sql;
	}
	
}