<?php

/**
 * Created by PhpStorm.
 * User: titu
 * Date: 1/11/17
 * Time: 2:56 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Activation_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $this->session->set_flashdata(array('request' => $actual_link));
        if(strpos($actual_link, "http://$_SERVER[HTTP_HOST]/activate") === false) {
            redirect('login');
        }
        $this->load->model("Mdl_user");
        $this->load->library('mongolib');
        $this->db = $this->mongolib->db;
        $this->sa = $this->db->sa;
        $this->user = $this->db->users;
        $this->package = $this->db->package;
    }

    public function activate_account($activation_token)
    {
        if(isset($activation_token)) {

            $user = $this->Mdl_user->get_user_by_token($activation_token);
            $script = '<script type="text/javascript">'.
                'setTimeout(function(){window.location="http://app.verifyrocket.com/login"}, 2000);'.
                '</script>';

            if($user && $user["active"] == false) {
                $this->user->update(array('_id' => new MongoId($user['_id'])), array('$set'=> array('active' => true)), array("multiple" => false));
                $data["msg"] = 'Your account has been successfully activated';
            }
            else {
                if(!$user){
                    $data["msg"] = "No user found";
                }
                else if($user["active"] == true) {
                    $data["msg"] = "Your account is already activated.";
                }
            }

            $data["script"] = $script;
            $this->load->view("user/activate_account", $data);
        }
    }

}