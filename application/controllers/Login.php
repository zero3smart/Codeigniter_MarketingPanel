<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use Mailgun\Mailgun;

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

    public function forgot_password()
    {
        if($this->session->userdata('email_lookup_user_logged_in'))
        {
            redirect($this->root.'dashboard');
        }

        if ($_POST['email']) {
            $this->load->library('form_validation');
            $email = $this->input->post('email');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message','email is not valid, please try again.');
                redirect($this->root."forgot_password");
            }else {
                $userInfo = $this->Mdl_login->getUserInfoByEmail($email);
                if (!$userInfo) {
                    $this->session->set_flashdata('flash_message', 'We cant find your email address');
                    redirect($this->root . "forgot_password");
                }

                // Make a small string (code) to assign to the user // to indicate they've requested a change of // password
                $code = mt_rand('5000', '200000');
                $data = array(
                    'forgot_password' => $code,
                );

                $this->Mdl_login->setForgotPwdToken($userInfo, $data);

                $url = base_url() . 'reset_password/token/' . $code;

                $message = '';
                $message .= 'A password reset has been requested for this email account.';
                $message .= 'Please click: ' . $url;

                //use Mailgun\Mailgun;

                # Instantiate the client.
                $mgClient = new Mailgun('key-04492621bb1decb7d7dc1a318d52fd7e');
                $domain = "notifications.verifyrocket.com";

                # Make the call to the client.
                $result = $mgClient->sendMessage($domain, array(
                    'from'    => 'notifications@verifyrocket.com',
                    'to'      => $email,
                    'subject' => 'Reset Password',
                    'text'    => $message
                ));

                if ($result) {
                    $this->session->set_flashdata('flash_message', 'please check your email for password reset instructions.');
                }
                else {
                    $this->session->set_flashdata('flash_message', 'Sorry, can not send email, please try again.');
                }

                redirect($this->root . "forgot_password");

            }
        }
        else {
            $this->load->view('user/forgot_password');
        }

    }

    public function reset_password($token)
    {
        if($this->session->userdata('email_lookup_user_logged_in'))
        {
            redirect($this->root.'dashboard');
        }

        $data = array(
            'token' => $token
        );
        if ($token)
            $this->load->view('user/reset_password', $data);

    }

    public function new_password()
    {
        if($this->session->userdata('email_lookup_user_logged_in'))
        {
            redirect($this->root.'dashboard');
        }

        $this->load->library('form_validation');
        $email = $this->input->post('email');
        $token = $this->input->post('token');
        $password1 = $this->input->post('password1');
        $password2 = $this->input->post('password2');
        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password1', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
        $data = array(
            'token' => $token
        );

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message','Invalid Email/Password, please try again.');
            $this->load->view('user/reset_password', $data);
        }
        else {
            if ($password1 != $password2) {
                $this->session->set_flashdata('flash_message','password doesnt match, please try again.');
                $this->load->view('user/reset_password', $data);
            }
            else {
                if (!$this->Mdl_login->does_token_match($email, $token)) {
                    $this->session->set_flashdata('flash_message','Your token is not valid, please try again.');
                    redirect($this->root . "forgot_password");
                }
                else {
                    $enc_password = sha1($password1);
                    $this->Mdl_login->set_password($email, $enc_password);
                    redirect($this->root);
                }
            }
        }

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
