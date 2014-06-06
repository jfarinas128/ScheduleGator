<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//check session data if not logged in the show:
		$this->load->model('User_model');

		if(!$this->User_model->logged()) 
			$this->load->view('home_page');
		else 
			$this->load->view('main/index');
	}
	public function signin()
	{
		$this->load->view('landing_page');
	}
	public function viewcourses()
	{
		$this->load->view('courses/courses');
	}
	public function login()
	{
		$this->load->model('User_model');
		$this->User_model->login();
	}
	public function about()
	{
		$this->load->view('about');

	}
	public function register()
	{
		//have the submitted a register form?
		if(isset($_POST['first'])&& isset($_POST['last']) && isset($_POST['email']) && isset($_POST['password'])) {

			//load usr model for access user table db
			$this->load->model('User_model');

			//initial info in register form
			// -- the data is sanitized in the user_model
			$first = $_POST['first'];
			$last = $_POST['last'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			//hash the password using email as the salt
			$hash = hash('sha256', $email.$password);

			//check if the email is already owned by another user
			if($this->User_model->exists('email',$email)) {
				echo "<h1>Email already exists in DB: ".$email."</h1>";
			}
			//email doesnt exist, lets create user
			else if($result = $this->User_model->create(array($email, $hash), array('email','password'))) {
				//since we have their first name we add a row for user_profile with their name

				//the user was created, lets get the id of that user
				$uid = $this->User_model->get_id($email);

				//load usr model for access user table db
				$this->load->model('Profile_model');


				$result = $this->Profile_model->create(array($uid, $first, $last), array('user_id','first','last'));
				if(	!$result ){
					echo "<h1>There was error creating user profile.</h1>";
				}

				//OK SO we have registered the user, lets log them in
				$user_data = array(
						'uid'   => $uid,
						'email' => $email,
						'hash'  => $hash
				);
				$uid = $this->session->set_userdata($user_data);
				$this->load->view('main/index');
			}
		}
	}
	function logout() {
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('hash');
		session_unset();
		$this->load->view('home_page');
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
		$this->load->view('profile/index.php');
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