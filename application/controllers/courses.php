<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->load->library('nativesession');
        $this->load->model("Course");
        $this->load->model("Schedule");
    }
    
	public function index()
	{
		if(!$this->tank_auth->is_logged_in()) 
			$this->load->view('home_page');
		else 
			$this->load->view('main/index');
	}

	public function generated()
	{
		$results = $this->Schedule->make_schedule();
		$data['openinfo'] = $results[1];
  		$data['selected_courses'] = $results[0];
		$this->load->view('courses/generated',$data);
	}
	
	public function search()
	{
		
		if((isset($_POST['query']) || isset($_POST['DEPT'])))
		{
			$data['DEPT'] = $this->input->post('DEPT');//need to sanitize data!
			$data['query'] = $this->input->post('query');
			$data['courses'] = array();
			if($data['DEPT'])
			{
				$data["courses"] = $this->Course->findByDept($data['DEPT']);
			}
			elseif($data['query'])
			{
				$query = $data['query'];//non-stripped version for prof query
				$data['query'] = preg_replace('/\s+/', '', $data['query']);//Strip string so queries match
				if (!preg_match('/[^A-Za-z]/', $data['query']) && strlen($data['query']) > 3)
				{
					$results = $this->Course->findByProf($query);
					$data["courses"] = $results['courses'];
					$data['matches'] = $results['matches'];
					$data['pages'] = 'p';
					$data['current_page'] = 0;
					$data['sid'] = 0;
					$data['DEPT']  = '';
					$data['query'] = $query;
					$data['discussions'] =$results['discussions'];
					$this->load->view('courses/search_results', $data);
					return;
				}
				else
				{
					switch(strlen($data['query']))
					{
						case 4:
							$data["courses"] = $this->Course->findBySection($data['query']);
							break;
						case 3:
						case 7:
						case 8:
							$str = $data['query'];
							$str =  substr($str, 0, 3) . ' ' . substr($str, 3);
							$data['query'] = $str;
							$data["courses"] =  $this->Course->findByNumber($str);
							break;
						default:
							break;
					}
				}
			}
			$searchable = $this->nativesession->get('searchable');
			$searchid = uniqid();	
			$matches = sizeof($data['courses']);
			if($matches > 20)
			{
				$split_size = ceil(($matches / 20));//20 results per page
				$chunks = $this->splitArray($data['courses'], $split_size);
				foreach($chunks as $index => $chunk)
					$searchable[$searchid][$index] = $chunk;
			}
			else
				$searchable[$searchid][0] = $data['courses'];

			$matches = sizeof($data['courses']);
			//Place new search data
			$this->nativesession->set('searchable', $searchable);
			$this->nativesession->set('matches', $matches);
			$this->nativesession->set('current_page', 0);
			$this->nativesession->set('pages',sizeof($searchable[$searchid]));
			$this->nativesession->set('query',$data['query']);
			$this->nativesession->set('DEPT',$data['DEPT']);
			$this->searchresults(0, $searchid);
		}
		else
			$this->load->view('courses/search_results');
	    }
	
	public function generateschedule()
	{
		if($this->input->is_ajax_request() && $this->tank_auth->is_logged_in())
		{
			$courses = $this->nativesession->get('tempcourses'); //TEMPCOURSES TO BE USED IN ACTUAL SCHEDULE GENERATOR
			$names = $this->nativesession->get('tempcoursenames');
			if(!empty($_POST["ID"]))
			{
				$val = json_decode($this->input->post('ID'));
				if($this->check_selected($val,"DEPT"))
				{
					print "Found";
					return;
				}
				print 'Section DEPT Added!';
				$sql = "select * from courses_professors where ID = ?;";
			}
			elseif(!empty($_POST["section"]))
			{
				$val = ($this->input->post('section'));
				if($this->check_selected($val,"section"))
				{
					print "Found";
					return;
				}
				print 'Section: '.$val.' Added!';
				$sql = "select * from courses_professors where section = ?;";
			}
			elseif(!empty($_POST["course"]))
			{//DO select queries for courses as a whole
				$val = ($this->input->post('course'));
				if($this->check_selected($val,"course"))
				{
					print "All sections for this Course have been added!";
					return;
				}
				print 'Course: '.$val.' Added!';
				$sql = "select * from courses_professors where course_name = ?;";
			}
			elseif(!empty($_POST["clear"]))//all empty, clear current list 
			{
				$this->nativesession->delete('tempcourses');
				$this->nativesession->delete('tempcoursenames');
				$this->nativesession->set('tempcourses',array());
				$this->nativesession->set('tempcoursenames',array());
				//echo json_encode($this->nativesession->get('tempcoursenames'));
				return;
			}
			elseif(!empty($_POST["remove"]))//all empty, clear specified courses
			{
				$value =$this->input->post("remove");
				$names = $this->nativesession->get('tempcoursenames'); 
				$courses = $this->nativesession->get('tempcourses');
				foreach($names as $index => $arr)
				{
					if ($arr['course_name'] == $value || $arr['section'] == $value || $arr['ID'] == $value)
						{
							unset($names[$index]); 
							unset($courses[$index]);
						}
				}
				$this->nativesession->set('tempcoursenames',$names);
				$this->nativesession->set('tempcourses',$courses);
				return;
			}
			$query = $this->db->query($sql, array($val));
			$data = $query->result_array();
			if(!empty($_POST["course"]))
				array_push($names,array('course_name' => $data[0]['course_name'],'section' => "ALL SECTIONS", 'ID' => $data[0]['ID'])); 
			else
				array_push($names,array('course_name' => $data[0]['course_name'],'section' => $data[0]['section'], 'ID' => $data[0]['ID'])); 
			array_push($courses,$data);
			$this->nativesession->set('tempcourses',$courses);				
			$this->nativesession->set('tempcoursenames',$names);
		}
		elseif(!$this->tank_auth->is_logged_in())
			print "nsi";	
		else//Algorithm goes here
		{
			$this->load->view('courses/generate_schedule');
		}
	}


	public function splitArray(array $array, $chunks)
	{
	  if (count($array) < $chunks)
	  {
	    return array_chunk($array, 1);
	  }
	  $new_array = array();
	  for ($i = 0, $n = floor(count($array) / $chunks); $i < $chunks; ++$i)
	  {
	    $slice = $i == $chunks - 1 ? array_slice($array, $i * $n) : array_slice($array, $i * $n, $n);
	    $new_array[] = $slice;
	  }
	  return $new_array;
	}

	
	public function check_selected($course, $type)
	{
		$names = $this->nativesession->get('tempcoursenames');
		$courses = $this->nativesession->get('tempcourses');
		if($type == "course")
		{
			$found = false;
			foreach($names as $index => $arr)
			{
				if ($arr['course_name'] == $course)
					if($arr['section'] != "ALL SECTIONS")
					{
						$found = true;
						unset($names[$index]);//remove all sections of that course
						unset($courses[$index]);
					}
			}
			if($found)
			{
				$sql = "select * from courses_professors where course_name = ?;";
				$query = $this->db->query($sql, array($course));
				$data = $query->result_array();
				array_push($courses,$data);				
				array_push($names,array('course_name' => $course,'section' => "ALL SECTIONS"));
				$this->nativesession->set('tempcourses',$courses);
				$this->nativesession->set('tempcoursenames',$names);
				return true;
			}
			return false;	
		}
		elseif($type == "section")
			$sql = "select course_name from courses_professors where section = ?;";
		elseif($type == "DEPT")
			$sql = "select course_name from courses_professors where ID = ?;";

		if($result = $this->db->query($sql, array($course)))
				{
					$row = $result->row();
					$cname = $row->course_name;
				}
				foreach($names as $arr)
					if ($arr['course_name'] == $cname)
						if($arr['section'] == "ALL SECTIONS")
							return true;
		else
			return false;

	}

	public function searchresults($number, $searchid)
	{
		$searchable = $this->nativesession->get('searchable');	
		$data['matches'] = $this->nativesession->get('matches');
		$data["courses"] = $searchable[$searchid][$number];
		$data["discussions"] = $this->Course->get_discussions($data["courses"]);
		$data['pages'] = $this->nativesession->get('pages');	
		$data['current_page'] = $number;
		$data['sid'] = $searchid;
		$data['query'] = $this->nativesession->get('query');
		$data['DEPT'] = $this->nativesession->get('DEPT');
		$this->load->view('courses/search_results', $data);
	}
















	}
