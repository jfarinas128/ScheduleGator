<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {


	public function index()
	{
		//check session data if not logged in the show:
		$this->load->model('User_model');
		if(!$this->User_model->logged()) {
			$this->load->view('profile/main');
		}
		else   {
			//show main page
			$this->load->view('profile/main');
		}
	}

	public function view($id = false) {
		$this->load->model('User_model');
		if($id == false) {
			$this->load->view('profile/main');
		}
		else {
			$data['uid'] = $id;
			$this->load->view('profile/main',$data);

		}
	}

	public function upload()
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png");

		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{

			$this->load->model('User_model');
			$uid=$this->session->userdata('uid');
			move_uploaded_file($_FILES["file"]["tmp_name"],
			"upload/user".$uid);
			$this->load->view('profile/main');

		}
	}


}
