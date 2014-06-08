<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('tank_auth');

    }

	public function index()
	{
		//check session data if not logged in the show:
		if($this->tank_auth->is_logged_in()) 
			$this->load->view('main/index');
		else 
			$this->load->view('home_page');
	}
	public function viewcourses()
	{
		$this->load->view('courses/courses');
	}
	public function about()
	{
		$this->load->view('about');
	}
	function database() {
		$queries = array('user_info' => "SELECT * from users,users_profile WHERE users.id=users_profile.user_id");
		$data = array();
		if(isset($_POST['query'])) {
			$query = $this->db->query($_POST['query']);
			$data['query'] = $query->result_array();
			$data['q']     = $_POST['query'];
		}
		$this->load->view('database_view',$data);
	}

	function profileView(){
		$this->load->view('profile/main.php');
	}

	function post_message()
	{
		$id=1;
		$data["gid"] = $id;
		$this->session->set_userdata(array('recent_group'=>$id));
		//Group information from groups table
		$this->load->model('Group_model');

		//get all messages for a given group
		$data['messages'] = $this->Group_model->get_messages($id,10);

		$uid = $this->session->userdata('uid');
		$this->load->model('User_model');
		$data['query'] = $this->User_model->getAllGroups();
		$this->load->helper('url');

		foreach($data['query'] as $index => $group)
		{
			$data['query'][$index]['score'] = $this->Group_model->get_correct_picks($uid, $group['id']);
		}
		$gid=1;
		$this->load->model('Group_model');
		$email = $this->session->userdata('email');
		if(isset($_POST['message']) && ($this->Group_model->checkMember($id,$email))) {
			$uid = $this->session->userdata('uid');
			$gid = $id;
			$sql = 'insert into messages(user_id, group_id, message)values(?,?,?);';
			$query = $this->db->query($sql,array($uid, $gid,$_POST['message']));

			redirect('landing/viewmygroups');
		}
		else
		{
			redirect('landing/viewmygroups');
		}
	}

}

/* End of file landing.php */
/* Location: ./application/controllers/landind.php */