<?php

class Profile_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table_name = "users_profile";
	}

}