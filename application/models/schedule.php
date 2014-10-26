<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Model {

	protected $selected_courses = array(); 
	protected $smallest = 9999;

	function __construct()
	{
		parent::__construct();
		$this->load->library('nativesession');
		$this->selected_courses = $this->nativesession->get('tempcourses');
		$days_of_the_week = array('M','T','W','R','F');
		$periods = array('1','2','3','4','5','6','7','8','9','10','11');
		$special_cases = array('E1' => 12, 'E2' => 13, 'E3' => 14, 'TBA' => 0);
	}

	public function make_date_time() //formulate values for date/time periods into arrays
										//refactor-> make method so you can pass in agroup of courses at a time, after you find out smallest group
										//main method will control all of this
	{
		foreach($this->selected_courses as $index => &$course_group)
		{
  			foreach($course_group as &$course)
  			{
  				if(sizeof($course_group) < $this->smallest)
  					$this->smallest = $index; 
  				$course['lecture_period_array'] = explode(',', $course['lecture_period_array']);
  				if($course['lecture_day'] != 'TBA' && $course['lecture_day'] != '')
  					$course['lecture_day'] = str_split(preg_replace('/\s+/', '', $course['lecture_day']));
  			}
  		}
  		return array($this->selected_courses, $this->smallest);
	}

	
	
}