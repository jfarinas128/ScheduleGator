<?php

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table_name = "users";
	}

	function logged() {
		$uid = $this->session->userdata('uid');
		$email = $this->session->userdata('email');
		$hash = $this->session->userdata('hash');
		if($uid != false && $hash != false) {
			$sql = "SELECT password FROM users WHERE id = ?";
			$query = $this->db->query($sql, array($uid));
			$row = $query->row();
			if($hash == trim($row->password) ){
				return true;
			}
		}
		else {
			if($this->login())
				return true;
		}
		return false;
	}
	function login() {
		if(isset($_POST['email'], $_POST['password'])) {
			$sql = "SELECT id, email,  password FROM users WHERE email = ?";
			$query = $this->db->query($sql, array($_POST['email']));
			if(!$query) {
				//Error
				echo 'Email not in the Database';
			}
			$row = $query->row();

			$hash = hash('sha256', $this->db->escape_str($_POST['email']).$this->db->escape_str($_POST['password']));
			if($hash == $row->password){
				$user_data = array(
						'uid'   => $row->id,
						'email' => $row->email,
						'hash'  => $hash
										);
				$uid = $this->session->set_userdata($user_data);
				$this->load->library( 'nativesession' );
				$this->nativesession->set('tempcourses',array());
				$this->nativesession->set('tempcoursenames',array());
				return true;
			}
			else {
				//Error
				$user_data = array(
						'uid'   => $row->id,
						'email' => $row->email,
						'hash'  => $hash
				);
				echo '<pre>';
				var_dump($user_data);
				echo '</pre>';
				echo '<pre>';
				var_dump($row->password);
				echo '</pre>';
			}
		}
		return false;
	}
	function get_id($email) {
		$sql  = "select id from users where email = ? ;";
		if($result = $this->db->query($sql, array($email))) {
			$row = $result->row();
			return $row->id;
		}

		return false;

	}

	function get_user($id) {
		$sql  = "select * from users as u,users_profile as up where u.id = ? AND u.id = up.user_id;";
		if($result = $this->db->query($sql, array($id))) {
			return $result->row();
		}

		return false;

	}

	function get_name($email) {
		$uid = $this->get_id($email);
		$sql  = "select first,last from users_profile where user_id = ? ;";
		if($result = $this->db->query($sql, array($uid))) {
			$row = $result->row();
			$info['first'] =  $row->first;
			$info['last'] = $row->last;
			return $info;
		}


		return false;

	}
}