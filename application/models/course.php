<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Model {
	public $table_name = 'courses';
	function __construct()
	{
		parent::__construct();
	}

	public function record_count() 
	{
        return $this->db->count_all("courses_professors");
    }

	public function findByDept($dept)
	{
		$sql = "select * from courses_professors where department = ?;";
		$query = $this->db->query($sql, array($dept));
		return $query->result_array();
	}

	public function findByProf($prof)
	{
			if(strpos($prof," "))
			{
			   $qname = preg_split('#\s+#', $prof, null, PREG_SPLIT_NO_EMPTY);
			   $finalq = array($qname[0], $qname[1]);
			   $this->db->select('*');
			   $this->db->like('instructor',$qname[0]);
			   $this->db->like('instructor',$qname[1]);
			   $query=$this->db->get("courses_professors");
			}
			else
			{
				$sql = "select * from courses_professors where professor_id = ANY(select id from professors where first= ? OR last = ?);";
				$finalq = array($prof, $prof);
				$query = $this->db->query($sql,$finalq);
			}
			$result = $query->result_array();
			$data['courses'] = $result;
			$data['matches'] = sizeof($result);
			$data['discussions'] = $this->get_discussions($data['courses']);
			return $data;
	}

	public function findBySection($section)
	{
		$sql = "select * from courses_professors where section = ?;";
		$query = $this->db->query($sql, array($section));
		return $query->result_array();
	}

	public function findByNumber($course)
	{
		$this->db->select('*');  //LIKE queries in codeigniter
		$this->db->like('course_name',$course);
		$query=$this->db->get("courses_professors");
		return $query->result_array();
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
}