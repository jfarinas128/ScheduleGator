<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	
	public function index()
	{
		//check session data if not logged in the show:
		if(!$this->User_model->logged()) 
			$this->load->view('home_page');
		else 
			$this->load->view('main/index');
	}
	
	public function search()
	{
		if((isset($_POST['query']) || isset($_POST['DEPT'])) && !isset($_POST['professor']))
		{
			$data['DEPT'] = $_POST['DEPT'];
			$data['query'] = $_POST['query'];
			$data['courses'] = array();
			if($data['DEPT'])
			{
				$sql = "select * from courses_professors where department = ?;";
				$query = $this->db->query($sql, array($data['DEPT']));
				$data["courses"] = $query->result_array();
			}
			elseif($data['query'])
			{
				$data['query'] = preg_replace('/\s+/', '', $data['query']);//Strip string so queries match
				switch(strlen($data['query']))
				{
					case 4:
						$sql = "select * from courses_professors where section = ?;";
						$query = $this->db->query($sql, array($data['query']));
						$data["courses"] = $query->result_array();
						break;
					case 3:
					case 7:
					case 8:
						$str = $data['query'];
						$str =  substr($str, 0, 3) . ' ' . substr($str, 3);
						$data['query'] = $str;
						$this->db->select('*');  //LIKE queries in codeigniter
						$this->db->like('course_name',$str);
						$query=$this->db->get("courses_professors");
						$result=$query->result_array();
						$data["courses"] = $result;
						break;
					default:
						break;
					}
			}
			//delete past search data
			$this->load->library('nativesession');	
			$this->nativesession->delete('result_pages');
			$this->nativesession->delete('pages');
			$this->nativesession->delete('current_page');
			$this->nativesession->delete('matches');
			$this->nativesession->delete('query');
			$this->nativesession->delete('DEPT');
			
			$matches = sizeof($data['courses']);
			$result_pages = array();
			if($matches > 20)
			{
				$split_size = ceil(($matches / 20));//20 results per page
				$chunks = $this->splitArray($data['courses'], $split_size);
				foreach($chunks as $index => $chunk)
					$result_pages[$index] = $chunk;
			}
			else
				$result_pages[0] = $data['courses'];
			//Place new search data
			$this->nativesession->set('result_pages', $result_pages);
			$this->nativesession->set('matches', $matches);
			$this->nativesession->set('current_page', 0);
			$this->nativesession->set('pages',sizeof($result_pages));
			$this->nativesession->set('query',$data['query']);
			$this->nativesession->set('DEPT',$data['DEPT']);

			$this->searchresults(0);
		}
		elseif(isset($_POST['professor']))
			$this->searchprofessor();
		else
			$this->load->view('courses/search_results');
	}


	public function searchprofessor()
	{
			$data['courses'] = array();
			$name = $_POST['query'];
			$this->load->library('nativesession');	
			if(strpos($name," "))
			{
			   $qname = preg_split('#\s+#', $name, null, PREG_SPLIT_NO_EMPTY);
			   $sql = "select * from courses_professors where professor_id = ANY(select id from professors where first= ? AND last = ?);";
			   $finalq = array($qname[0], $qname[1]);
			}
			else
			{
				$sql = " select * from courses_professors where professor_id = ANY(select id from professors where first= ? OR last = ?);";
				$finalq = array($name, $name);
			}
			$query = $this->db->query($sql,$finalq);
			$result = $query->result_array();
			$data["courses"] = $result;
			$data['matches'] = sizeof($result);
			$data['pages'] = 'p';
			$data['current_page'] = 0;
			$data['DEPT']  = '';
			$data['query'] = $name;
			$data['discussions'] = $this->get_discussions($data['courses']);
			$this->load->view('courses/search_results', $data);
	}
	
	public function generateschedule()//NEED to handle if duplicates passed??
	{
		$this->load->library('nativesession');	
		if($this->input->is_ajax_request())
		{
			$courses = $this->nativesession->get('tempcourses'); //TEMPCOURSES TO BE USED IN ACTUAL SCHEDULE GENERATOR
			$names = $this->nativesession->get('tempcoursenames');
			if(!empty($_POST["ID"]))
			{
				$val = json_decode($_POST['ID']);
				if($this->check_selected($val,"DEPT"))
				{
					print "This Section has already been added!";
					return;
				}
				print 'Section DEPT Added!';
				$sql = "select * from courses_professors where ID = ?;";
			}
			elseif(!empty($_POST["section"]))
			{
				$val = ($_POST['section']);
				if($this->check_selected($val,"section"))
				{
					print "This Section has already been added!";
					return;
				}
				print 'Section: '.$val.' Added!';
				$sql = "select * from courses_professors where section = ?;";
			}
			elseif(!empty($_POST["course"]))
			{//DO select queries for courses as a whole
				$val = ($_POST['course']);
				if($this->check_selected($val,"course"))
				{
					print "All sections for this Course have been added!";
					return;
				}
				print 'Course: '.$val.' Added!';
				$sql = "select * from courses_professors where course_name = ?;";
			}
			elseif(empty($_POST["course"]) && empty($_POST["section"]) && empty($_POST["ID"]))//all empty, clear current list 
			{
				$this->nativesession->delete('tempcourses');
				$this->nativesession->delete('tempcoursenames');
				$this->nativesession->set('tempcourses',array());
				$this->nativesession->set('tempcoursenames',array());
				return;
			}
			$query = $this->db->query($sql, array($val));
			$data = $query->result_array();
			if(!empty($_POST["course"]))
				array_push($names,array('course_name' => $data[0]['course_name'],'section' => "ALL SECTIONS")); 
			else
				array_push($names,array('course_name' => $data[0]['course_name'],'section' => $data[0]['section'])); 
			array_push($courses,$data);
			$this->nativesession->set('tempcourses',$courses);				
			$this->nativesession->set('tempcoursenames',$names);
		}
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
	public function get_discussions($courses)
	{
		$sql = "select * from discussions where course_id = ?;";
		$discussions = array();
		foreach($courses as $course)//Get discussions for each course found TO BE PUT IN MODEL
			{
				$query = $this->db->query($sql, array($course["ID"]));
				$discussions[$course["section"]] = $query->result_array();
			}
		return $discussions;
	}

	public function searchresults($number)
	{
		$this->load->library('nativesession');	
		$result_pages = $this->nativesession->get('result_pages');	
		$data["courses"] = $result_pages[$number];
		$data["discussions"] = $this->get_discussions($data["courses"]);
		$data['pages'] = $this->nativesession->get('pages');	
		$data['current_page'] = $number;
		$data['matches'] = $this->nativesession->get('matches');
		$data['query'] = $this->nativesession->get('query');
		$data['DEPT'] = $this->nativesession->get('DEPT');
		$this->load->view('courses/search_results', $data);
	}
















	}
