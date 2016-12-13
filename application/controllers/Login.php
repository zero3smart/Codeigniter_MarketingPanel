<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("Mdl_login");
        $this->root = "";
    }
	public function index()                                                       	// user login panel
	{
		if($this->session->userdata('email_lookup_user_logged_in'))
		{
			redirect($this->root.'dashboard');
		}

        $data['error'] = $this->session->flashdata('msg');
		$data['request'] = $this->session->flashdata('request');
		$this->load->view('user/login',$data);
	}
	
	public function do_login_user()                                              	// user login function
    {
    	if($this->session->userdata('email_lookup_user_logged_in'))
		{
			redirect($this->root.'dashboard');
		}
    	$this->load->library('form_validation');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $request = $this->input->post('request');
       
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) 
        {
        	$this->session->set_flashdata(array(
						'msg'=>'<strong>Access Denied</strong> Invalid Username/Password','request'=>$request
						));
				redirect($this->root.'login');
        } 
        else 
        {
        	$enc_password = sha1($password);
            //die();
        	$fetch_user_login = $this->Mdl_login->fetch_user_login($username,$enc_password);
        	if($fetch_user_login)
        	{
                $this->session->set_flashdata(array(
                        'first'=>0
                        ));
                if($request != '')
                    header("location:".$request);
                else
        		redirect($this->root."dashboard");												// if user logged in
        	}
			else
			{
				$this->session->set_flashdata(array(
						'msg'=>'<strong>Access Denied</strong> Invalid Username/Password','request'=>$request
						));
				redirect($this->root.'login');
			}
        }
    }

    public function do_login_user_after_signup($username,$password)                                                 // user login function
    {
        if($this->session->userdata('email_lookup_user_logged_in'))
        {
            redirect($this->root.'dashboard');
        }
       

            $enc_password = sha1($password);
            //die();
            $fetch_user_login = $this->Mdl_login->fetch_user_login($username,$enc_password);
            if($fetch_user_login)
            {
                $this->session->set_flashdata(array(
                        'first'=>1
                        ));
                redirect($this->root."profile");                                              // if user logged in
            }
            else
            {
                $this->session->set_flashdata(array(
                        'msg'=>'<strong>Access Denied</strong> Invalid Username/Password','request'=>base_url().'dashboard'
                        ));
                redirect($this->root.'login');
            }
        
    }

    public function user_logout()													// user log out
    {
    	$this->session->unset_userdata('email_lookup_user_logged_in');
    	$this->session->unset_userdata('email_lookup_user_username');
    	$this->session->unset_userdata('email_lookup_user_id');
        $this->session->set_flashdata(array(
                        'request'=>''
                        ));
        if($this->session->email_lookup_admin_logged_in)
            redirect($this->root.'admin','refresh');
        else
    	   redirect($this->root.'login','refresh');
    }








	public function super_admin()                                                       		// Super admin login panel
	{
		if($this->session->userdata('email_lookup_admin_logged_in'))
		{
			redirect($this->root.'admin');
		}
		$data['error'] = $this->session->flashdata('msg');
        $data['request'] = $this->session->flashdata('request');
		$this->load->view('admin/login',$data);
	}

	public function do_login_sa()                                              		// Super admin login function
    {
    	if($this->session->userdata('email_lookup_admin_logged_in'))
		{
			redirect($this->root.'admin');
		}
    	$this->load->library('form_validation');
    	$username = $this->input->post('username');
        $password = $this->input->post('password');
        $request = $this->input->post('request');
       
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) 
        {
        	$this->session->set_flashdata(array(
						'msg'=>'<strong>Access Denied</strong> Invalid Username/Password','request'=>$request
						));
				redirect($this->root.'super_admin');
        } 
        else 
        {
        	$enc_password = sha1($password);
        	$fetch_sa_login = $this->Mdl_login->fetch_sa_login($username,$enc_password);
        	if($fetch_sa_login)
        	{
                 if($request != '')
                    header("location:".$request);
                else
                redirect($this->root."admin");  									// if super admin logged in
        	}
			else
			{
				$this->session->set_flashdata(array(
						'msg'=>'<strong>Access Denied</strong> Invalid Username/Password','request'=>$request
						));
				redirect($this->root.'super_admin');
			}
        }
    }

    public function admin_logout()										// admin log out
    {
    	$this->session->unset_userdata('email_lookup_admin_logged_in');
    	$this->session->unset_userdata('email_lookup_admin_username');
    	$this->session->unset_userdata('email_lookup_admin_id');
        
    	redirect($this->root.'super_admin','refresh');
    }

}
