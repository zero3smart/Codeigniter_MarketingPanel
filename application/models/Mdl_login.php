<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_login extends CI_Model {
	//private $connection = null;
	function __construct() {
        parent::__construct();

    	//$this->load->library('encrypt');
		$this->connection = new MongoClient();
		$this->db = $this->connection->email_cleanup;
		$this->sa = $this->db->super_admin;
		$this->user = $this->db->users;
		//if($this->sa->insert(array('username'=>'admin','password'=>sha1('123456')))) echo "Success";die();
    }
	public function fetch_user_login($username,$password)
	{
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->user->findOne($data);
		if($result && $result['active'] == true)
		{
			$this->session->set_userdata(array(
				'email_lookup_user_logged_in' => true,
				'email_lookup_user_username' => $result['username'],
				'email_lookup_user_id' => $result['_id'],
				'email_lookup_user_avater' => $result['avater']
				));
			return true;
		}
		else
			return false;
	}

	public function fetch_sa_login($username,$password)
	{
		$data = array(
			'username' => $username,
			'web_password' => $password
			);
		$result = $this->sa->findOne($data);
		if($result)
		{
			$this->session->set_userdata(array(
				'email_lookup_admin_logged_in' => true,
				'email_lookup_admin_username' => $result['username'],
				'email_lookup_admin_id' => $result['_id']
				));
			return true;
		}
		else
			return false;
	}


}

?>