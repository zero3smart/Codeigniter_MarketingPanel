<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*app.snapiq.com/application/controllers/user_controller*/

//date_default_timezone_set('America/New_York');
require 'vendor/autoload.php';
use GuzzleHttp\Client;

require 'class.pdf2text.php';

class User_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email_lookup_user_logged_in')) {
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $this->session->set_flashdata(array('request' => $actual_link));
            redirect('login');
        }
        $this->load->model("Mdl_user");
        $this->load->library('mongolib');
        $this->db = $this->mongolib->db;
        $this->sa = $this->db->sa;
        $this->user = $this->db->users;
        $this->package = $this->db->package;

        $this->user_prifile = $this->Mdl_user->fetch_user_profile();
    }

    public function get_balance_and_limit()
    {

        session_write_close();
        $dash_profile = $this->Mdl_user->fetch_user_profile();
        $current_package = $this->Mdl_user->fetch_current_package();
        $daily_limit = $this->Mdl_user->fetch_user_daily_limit();

        if ($daily_limit > -1) {
            $daily_limit_left = $current_package['daily_limit'] - $daily_limit;
        } else {
            $daily_limit_left = 0;
        }

        $total_usable_credit = $daily_limit_left + $dash_profile['balance'];
        $result = array();
        $result['balance'] = $dash_profile['balance'];
        $result['daily_limit'] = $daily_limit_left;
        $result['usable_credit'] = $total_usable_credit;

        echo json_encode($result);


    }

    public function global_balance()
    {
        $dash_profile = $this->Mdl_user->fetch_user_profile();
        echo $dash_profile['balance'];
    }

    public function get_file_process_progress($file_id)
    {
        $result = $this->Mdl_user->fetch_user_file_by_id($file_id);
        echo $result['progress'];
    }

    public function get_all_file_process_progress()
    {
        session_write_close();
        $icon_array = array();
        $icon_array[0] = "fa fa-spin fa-spinner";
        $result = $this->Mdl_user->fetch_user_file_by_status('processing');
        $htmlToReturn = '';

        foreach ($result as $key => $value) {
            if (isset($value['clean_id'])) {
                $response = $this->callStatusAPI($value['clean_id']);
                $response = json_decode($response, true);

                if(!$response["success"]) {
                    $this->Mdl_user->set_status_on_failure($value['_id'], $response["message"]);
                }
                else if($response["success"] && isset($response["data"]["errorMessage"])) {
                    $this->Mdl_user->set_status_on_failure($value['_id'], $response["data"]["errorMessage"]);
                }
                else if ($response["success"] && $response["data"]["status"] == "completion") { //completed
                    //lets update the record with the result and progress=processed
                    $this->Mdl_user->set_status_on_completion($value['_id'], 'processed', $response);
                } else {
                    /*if ($value['progress'] > 0)
                        $progress = intval(($value['progress'] * 180) / 100);
                    else
                        $progress = 0;

                    $progress_percent = intval($value['progress']);
                    shuffle($icon_array);*/
                    $htmlToReturn = $htmlToReturn . '
                        <tr>
                            <td>'. $value['file_name'] .'</td>
                            <td>'. $value['upload_time'] .'</td>
                        </tr>
                    ';

				/*echo '<div class="col-xs-12 file_progress_row" style="border:1px solid #32c5d2;padding:15px;background:#fff;">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="col-xs-12 file_data">
                                            <div class="col-xs-12" style="padding:10px 15px 20px 15px;">
                                            	<b>File Name : </b>
                                            	<span>' . $value['file_name'] . '</span>
                                            </div>
                                            <div class="col-xs-12" style="padding-bottom:10px">
                                            	<b>Uploaded at : </b>
                                            	<span>' . $value['upload_time'] . '</span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="icon"><span class="' . $icon_array[0] . '"></span></div>
                                    </div>
                                </div>
			';*/
                }

            }
        }
        if(strlen($htmlToReturn) > 0) {
            $htmlToReturn =
                '<div style="background-color: #fff;padding: 15px;">'.
                '<div class="table-responsive">'.

                '<table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" cellspacing="0">'.
                '<thead></thead><tr><th>File Name</th><th>Uploaded At</th></tr>'
                . $htmlToReturn
                .'</table></div></div>';
        }else
        {
            $htmlToReturn =
                '<div style="background-color: #fff;padding: 15px;">'.
                '<div class="table-responsive">'.

                '<table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" cellspacing="0">'.
                '<thead></thead><tr><th colspan="2">No file is processing.</th></tr>'
                .'</table></div></div>';
        }
        echo  $htmlToReturn;
    }

    public function getdate_all()
    {

        $time = getdate();
        return $time_str = $time['seconds'] . $time['minutes'] . $time['hours'] . $time['mday'] . $time['wday'] . $time['mon'] . $time['year'] . $time['yday'] . $time['weekday'] . $time['month'] . $time[0];

    }

    public function credit_reduce($credit, $note, $user_file_id = "")//
    {
        $dash_profile = $this->Mdl_user->fetch_user_profile();
        $current_package = $this->Mdl_user->fetch_current_package();
        $daily_limit = $this->Mdl_user->fetch_user_daily_limit();

        if ($user_file_id != "")
            $user_file_id = new MongoId($user_file_id);

        $type = "reduced";
        $is_debit = false;

        if ($daily_limit > -1) {
            $daily_limit_left = $current_package['daily_limit'] - $daily_limit;
        } else {
            $daily_limit_left = 0;
        }

        $total_usable_credit = $daily_limit_left + $dash_profile['balance'];

        if ($total_usable_credit >= $credit) {
            $current_package = $this->Mdl_user->fetch_current_package();
            if ($current_package) {

                $used_daily_limit = $this->Mdl_user->fetch_user_daily_limit();

                if ($daily_limit > -1) {
                    $daily_limit_left = $current_package['daily_limit'] - $used_daily_limit;
                } else {
                    $daily_limit_left = 0;
                }

                if ($credit > $daily_limit_left) {
                    $data_transaction = array();
                    $data_transaction['price'] = 0;
                    $data_transaction['user_file_id'] = $user_file_id;
                    $data_transaction['credit'] = $daily_limit_left;
                    $data_transaction['is_debit'] = false;
                    $data_transaction['user'] = $this->session->email_lookup_user_id;
                    $data_transaction['time'] = new MongoDate(strtotime(date('Y-m-d H:i:s')));
                    $data_transaction['notes'] = 'Daily limit ' . $type . ' for File Cleane Up';

                    $this->Mdl_user->set_user_daily_limit($daily_limit_left);
                    $this->Mdl_user->transaction_insert($data_transaction);
                    $row_left = (-1) * ($credit - $daily_limit_left);

                    $data_transaction = array();
                    $data_transaction['price'] = 0;
                    $data_transaction['user_file_id'] = $user_file_id;
                    $data_transaction['is_debit'] = $is_debit;
                    $data_transaction['user'] = $this->session->email_lookup_user_id;
                    $data_transaction['time'] = new MongoDate(strtotime(date('Y-m-d H:i:s')));
                    $data_transaction['credit'] = $row_left * (-1);
                    $data_transaction['notes'] = 'Credit ' . $type . ' for ' . $note;;
                    $this->Mdl_user->set_new_balance($row_left);
                    $this->Mdl_user->transaction_insert($data_transaction);
                } else {
                    $data_transaction = array();
                    $data_transaction['price'] = 0;
                    $data_transaction['user_file_id'] = $user_file_id;
                    $data_transaction['credit'] = $credit;
                    $data_transaction['is_debit'] = $is_debit;
                    $data_transaction['user'] = $this->session->email_lookup_user_id;
                    $data_transaction['time'] = new MongoDate(strtotime(date('Y-m-d H:i:s')));
                    $data_transaction['notes'] = 'Daily limit ' . $type . ' for ' . $note;;

                    $this->Mdl_user->set_user_daily_limit($credit);
                    $this->Mdl_user->transaction_insert($data_transaction);
                }

            } else {
                $data_transaction = array();
                $data_transaction['price'] = 0;
                $data_transaction['user_file_id'] = $user_file_id;
                $data_transaction['credit'] = intval($credit);
                $data_transaction['is_debit'] = $is_debit;
                $data_transaction['user'] = $this->session->email_lookup_user_id;
                $data_transaction['time'] = new MongoDate(strtotime(date('Y-m-d H:i:s')));
                $data_transaction['notes'] = 'Credit reduced for ' . $note;
                $row_left = (-1) * $credit;
                $this->Mdl_user->set_new_balance($row_left);
                $this->Mdl_user->transaction_insert($data_transaction);
            }

            return true;
        } else {
            return false;
        }
    }

    public function test()
    {
        $this->load->view("user/test_stripe");

    }

    public function index($parm1 = '')
    {


        $data['view']['page_title'] = 'Dashboard';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'dashboard';
        $data['view']['menu'] = 'dashboard';
        $data['view']['submenu'] = '';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $invoice_net_total_this_day = $this->Mdl_user->get_invoice_bill_total_for_chart(7);
        $expense_total_this_day = $this->Mdl_user->get_expense_bill_total_for_chart(7);


        $file_total_contacts_details = $this->Mdl_user->get_file_total_contacts_details_for_chart(7);
        $data['total_graph_data_sum'] = array_sum($file_total_contacts_details['total_contacts']) + array_sum($file_total_contacts_details['total_succesful']) + array_sum($file_total_contacts_details['total_smtp_clean']) + array_sum($file_total_contacts_details['total_failed']);

        $data['total_dates'] = implode(',', $file_total_contacts_details['dates']);
        $data['total_contacts_chart'] = implode(',', $file_total_contacts_details['total_contacts']);
        $data['total_successful_chart'] = implode(',', $file_total_contacts_details['total_succesful']);
        $data['total_smtp_clean_chart'] = implode(',', $file_total_contacts_details['total_smtp_clean']);
        $data['total_failed_chart'] = implode(',', $file_total_contacts_details['total_failed']);

        $data['file_summery_all'] = $this->Mdl_user->get_file_summery_all();
        $data['invoice_net_total_this_day'] = implode(',', $invoice_net_total_this_day);
        $data['expense_total_this_day'] = implode(',', $expense_total_this_day);


        $this->load->view("user/dashboard", $data);
    }

    public function packages()
    {
        $data['view']['page_title'] = 'Purchase';
        $data['view']['page_sub_title'] = 'Monthly Packages';
        $data['view']['section'] = 'packages';
        $data['view']['menu'] = 'store';
        $data['view']['submenu'] = 'packages';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');

        $data['package_document'] = $this->Mdl_user->fetch_package();
        $data['view']['buy'] = 2;

        $this->load->view("user/dashboard", $data);
    }

    public function package_stripe_form($package_id)
    {
        $data['view']['page_title'] = 'Purchase';
        $data['view']['page_sub_title'] = 'Monthly Packages';
        $data['view']['section'] = 'package_stripe_form';
        $data['view']['menu'] = 'store';
        $data['view']['submenu'] = 'packages';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['package_document'] = $this->Mdl_user->fetch_package_single($package_id);

        $this->load->view("user/dashboard", $data);
    }

    public function buy_credit()
    {
        $data['view']['page_title'] = 'Purchase';
        $data['view']['page_sub_title'] = 'Pay as you go';
        $data['view']['section'] = 'buy_credit';
        $data['view']['menu'] = 'store';
        $data['view']['submenu'] = 'buy_credit';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['view']['buy'] = 2;

        $this->load->view("user/dashboard", $data);
    }

    public function buy_package_confirm()
    {
        $data['view']['page_title'] = 'Purchase Credit';
        $data['view']['page_sub_title'] = 'Monthly Packages';
        $data['view']['section'] = 'packages';
        $data['view']['menu'] = 'store';
        $data['view']['submenu'] = 'packages';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['buy'] = 1;

        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['package_document'] = $this->Mdl_user->fetch_package();

        $this->load->view("user/dashboard", $data);
    }

    public function buy_credit_confirm($credit)
    {
        $data['view']['page_title'] = 'Purchase Credit';
        $data['view']['page_sub_title'] = 'Pay as you go';
        $data['view']['section'] = 'buy_credit';
        $data['view']['menu'] = 'store';
        $data['view']['submenu'] = 'buy_credit';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['view']['buy'] = 1;

        $data['view']['credit'] = $credit;

        $this->load->view("user/dashboard", $data);
    }

    public function profile()
    {
        $data['view']['page_title'] = 'Profile';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'profile';
        $data['view']['menu'] = 'profile';
        $data['view']['submenu'] = '';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['view']['first'] = $this->session->flashdata('first');
        $data['profile_document'] = $this->Mdl_user->fetch_user_profile();

        $this->load->view("user/dashboard", $data);
    }

    public function profile_update()
    {
        $username = $this->session->email_lookup_user_username;
        $microtime = microtime();
        $field_value = $this->input->post('field_value');
        $collection = $this->input->post('collection');
        if ($collection == 'user')
            $collection = 'users';
        $field = $this->input->post('field');
        $_id = $this->input->post('_id');
        if ($field == 'api_key' || $field == 'email' || $field == 'firstname' || $field == 'lastname' || $field == 'contact' || $field == 'address' || $field == 'zip' || $field == 'state' || $field == 'country') {

            if ($field == 'api_key') {
                $field_value = md5($username . '_' . $microtime);
            }
            $data = array(
                $field => $field_value
            );
            $this->Mdl_user->custom_edit_single_field_mdl($collection, $_id, $data);
        }
        echo $field_value;
    }

    public function profile_picture_update()
    {
        $user_id = $this->session->email_lookup_user_id;
        $return = 0;
        $name = explode('.', $_FILES['profile_picture']['name']);
        $ext1 = end($name);
        $profile_picture_name = $user_id . '_' . sha1($this->getdate_all()) . '.' . $ext1;
        $profile_picture_path = 'assets/user/avater/' . $profile_picture_name;
        $profile_picture_path_full = getcwd() . '/assets/user/avater/' . $profile_picture_name;
        //echo $profile_picture_path_full;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_path_full)) {
            $user_id = $this->session->email_lookup_user_id;
            $result = $this->user->findOne(array('_id' => new MongoId($user_id)));
            if (count($result) > 0) {
                if (!preg_match("/default/i", $result['avater'])) {
                    if (file_exists(getcwd() . '/' . $result['avater']))
                        unlink(getcwd() . '/' . $result['avater']);
                }
                $data = array(
                    'avater' => $profile_picture_path
                );

                $check = $this->Mdl_user->custom_edit_single_field_mdl('users', $user_id, $data);
                $_SESSION['email_lookup_user_avater'] = $profile_picture_path;
                $return = $check['ok'];

            }

            echo json_encode($return);
        } else {
            echo json_encode($return);
        }

    }

    public function instant_lookup()
    {
        $data['view']['page_title'] = 'Instant Lookup';
        $data['view']['page_sub_title'] = '';
        $data['view']['menu'] = 'instant_lookup';
        $data['view']['submenu'] = '';
        $data['view']['section'] = 'instant_lookup';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $this->load->view("user/dashboard", $data);
    }

    public function contact_upload_section()
    {
        $data['view']['page_title'] = 'Email Validation';
        $data['view']['page_sub_title'] = '';
        $data['view']['menu'] = 'contact';
        $data['view']['submenu'] = 'contact_upload_section';
        $data['view']['section'] = 'contact_upload_section';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');

        $this->load->view("user/dashboard", $data);
    }
    
    public function email_verification_section()
    {
        $data['view']['page_title'] = 'Email Verification';
        $data['view']['page_sub_title'] = '';
        $data['view']['menu'] = 'contact';
        $data['view']['submenu'] = 'email_verification_section';
        $data['view']['section'] = 'email_verification_section';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');

        $this->load->view("user/dashboard", $data);
    }        
    
    public function phone_upload_section()
    {
        $data['view']['page_title'] = 'Carrier Lookup';
        $data['view']['page_sub_title'] = '';
        $data['view']['menu'] = 'contact';
        $data['view']['submenu'] = 'phone_upload_section';
        $data['view']['section'] = 'phone_upload_section';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');

        $this->load->view("user/dashboard", $data);
    }
    
    public function data_append_section()
    {
        $data['view']['page_title'] = 'Data Append';
        $data['view']['page_sub_title'] = '';
        $data['view']['menu'] = 'contact';
        $data['view']['submenu'] = 'data_append_section';
        $data['view']['section'] = 'data_append_section';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');

        $this->load->view("user/dashboard", $data);
    }

    public function check_file_status()                                    //while file upload	// 1, oct, 2016
    {
        $file_name = trim($this->input->post('file_name'));
        $output = array();
        $output['file_name'] = $file_name;
        $output['file_existing'] = false;
        $output['current_processing'] = 0;
        /*$file_check = $this->Mdl_user->fetch_user_file_by_name($file_name);
        if (count($file_check) > 0) {
            $output['file_existing'] = true;
        }*/
        $output['current_processing'] = $this->db->user_file->find(array('user' => new MongoId($this->session->email_lookup_user_id), 'status' => 'processing'))->count();

        echo json_encode($output);
    }

    public function console_log($data)
    {
        echo '<script type="text/javascript">';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    private function guess_delimiter($r_array=array())
    {
        $bestDelimiter = ',';
        $delimChoices = [",", "\t", "|", ";"];
        $bestDelta = null;
        $fieldCountPrevRow = null;

        foreach($delimChoices as $delim)
        {
            $i = 0;
            $delta = 0;
            $avgFieldCount = 0;
            $fieldCountPrevRow = null;
            $total_rows = 0;
            foreach($r_array as $si_arr)
            {
                $i++; $total_rows++;

                $line = explode($delim, $si_arr);

                $fieldCount = count($line);
				$avgFieldCount += $fieldCount;

                if(is_null($fieldCountPrevRow))
                {
                    $fieldCountPrevRow = $fieldCount;
                    continue;
                }else
                {
                    $delta += Math.abs($fieldCount - $fieldCountPrevRow);
				    $fieldCountPrevRow = $fieldCount;
                }

                if($i > 1){ break; }
            }

            //echo $avgFieldCount.' : '.$total_rows.' <br>';
            if ($total_rows > 0){$avgFieldCount /= $total_rows;}
            //echo $bestDelta.' : '.$delta.' : '.$avgFieldCount.' : '.$total_rows.'<br>';
            if ((is_null($bestDelta) || $delta < $bestDelta) && $avgFieldCount > 1.99)
            {
                $bestDelta = $delta;
                $bestDelimiter = $delim;
            }
        }
        //echo $bestDelimiter;die;
        return $bestDelimiter;
    }

    public function  upload_file () {
        session_write_close();
        $contactfile = $_FILES['contactfile']['tmp_name'];
        $contactfile_line = file($contactfile);
        $user_id = $this->session->email_lookup_user_id;
        $user = $this->Mdl_user->fetch_user_profile();
        $column_number_2 = $this->input->post("column_number_2");
        $containsHeader = $this->input->post("header");
        $line_break = $this->input->post("line_break");
        $totalRecords = 0;

        foreach ($contactfile_line as $value) {
            $line = explode($line_break, $value);
            $totalRecords += count($line);
        }


        //$totalRecords = count(explode($line_break, $contactfile_line));


        if(!$containsHeader) {
            $containsHeader = false;
        }
        else {
            --$totalRecords;
        }

        if ($column_number_2 == "") {
            echo '
			Sorry, Email not found in this file. 
			';
        }
        else {
            echo $contactfile_line;
            echo 'Total credits required: ' . $totalRecords;
        }
    }

    public function upload_file1()
    {
        session_write_close();
        $file_name = $_FILES["contactfile"]["name"];
        $file_tmp = $_FILES["contactfile"]["tmp_name"];

        $file_id_str = "";
        $user_id = $this->session->email_lookup_user_id;
        $user = $this->Mdl_user->fetch_user_profile();
        $column_number_2 = $this->input->post("column_number_2");
        $containsHeader = $this->input->post("header");
        $lineBreak = $this->input->post("line_break");


        if(!$containsHeader) {
            $containsHeader = false;
        }

        if ($column_number_2 == "") {
            echo '
			Sorry, Email not found in this file. 
			';
        }
        else {
            $column_number_2 = $column_number_2 - 1;
            $dash_profile = $this->Mdl_user->fetch_user_profile();
            $current_package = $this->Mdl_user->fetch_current_package();
            $daily_limit = $this->Mdl_user->fetch_user_daily_limit();

            if ($daily_limit > -1) {
                $daily_limit_left = $current_package['daily_limit'] - $daily_limit;
            } else {
                $daily_limit_left = 0;
            }

            $total_usable_credit = $daily_limit_left + $dash_profile['balance'];

            $contactfile = $_FILES['contactfile']['tmp_name'];
            $contactfile_line = file($contactfile);


            $contactfile_line = array_reverse($contactfile_line);
            $result = array();
            $delimiter = $this->guess_delimiter($contactfile_line);
            foreach ($contactfile_line as $value) {
                $line = explode($delimiter, $value);
                $line[$column_number_2] = trim($line[$column_number_2]);
                $line[$column_number_2] = strtolower($line[$column_number_2]);
                $result[$line[$column_number_2]] = $value;
            }
            $result = array_reverse($result);

            $result_string_full = implode("", $result);

            $contactfile_length = count($result);

            if ($contactfile_length > $total_usable_credit) {
                redirect("User_controller/have_not_balance");
            }

            $i = 0;
            $status = array();
            $status['stage'] = "not done";

            if ($_FILES["contactfile"]["error"] == 0) {
                $name = trim($_FILES["contactfile"]["name"]);
                $csv_files_total_row = $contactfile_length;
                $csv_files_total_row = intval($csv_files_total_row);

                try {
                    $uploadToFtp = $this->upload_to_ftp($user["ftphost"], $user["username"], $user["ftppassword"], $contactfile, $name);
                }
                catch (Exception $e) {
                    echo 'Caught exception on file uploading to FTP: ',  $e->getMessage(), "\n";
                    return;
                }

                if (!$uploadToFtp) {
                    echo '
                        Failed to upload file to FTP. 
                        ';
                } else {

                    $apiResponse = $this->callScrubberAPI($name, $user["username"], $column_number_2, $containsHeader, $user["ftphost"], $user["ftppassword"]);

                    $apiResponse = json_decode($apiResponse, true);

                    /*$this->console_log("success: " . $apiResponse["success"]);
                    $this->console_log("cleanId: " . $apiResponse["data"]["cleanId"]);*/
                    if ($apiResponse["success"]) {
                        $clean_id = $apiResponse["data"]["cleanId"];
                        $clean_id = new MongoId($clean_id);
                        $data = array(
                            "clean_id" => $clean_id,
                            "user" => $user_id,
                            "file_name" => $name,
                            "upload_time" => new MongoDate(strtotime(date('Y-m-d H:i:s'))),
                            "process_end_time" => "",
                            "status" => "processing",
                            "progress" => (double)0

                        );

                        $upload = $this->Mdl_user->contact_upload_file_mdl($data); // inserts the $data

                        $user_file_data = $this->Mdl_user->fetch_user_file_id($clean_id); //the same as just inserted

                        $credit_reduce = $this->credit_reduce($csv_files_total_row, "File Cleanup", $user_file_data['_id']); //reduces credit, lets call it after getting the cleanId from the api

                        $user_file_data_id = $user_file_data['_id'];
                        $status['stage'] = "ok";
                        echo 'Successfully Uploaded./' . $name;
                        //$this->get_all_file_process_progress();
                        //redirect(site_url("User_controller/sendUploadRequest/". $user_file_data['_id']));
                    }
                    else {
                        echo 'Sorry, Try again';
                    }
                }
            } else {
                echo 'Sorry, Try again';
            }

        }
    }

    public function callStatusAPI($clean_id)
    {
        $statusURL = 'http://64.187.105.90:3000/status?cleanId=' . $clean_id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $statusURL
        ));

        $resp = curl_exec($curl);
        //$this->console_log($resp);
        curl_close($curl);
        return $resp;
    }

    public function callScrubberAPI($fileName, $userName, $index, $header, $ftpHost, $ftpPassword)
    {
        $scrubberURL = 'http://64.187.105.90:3000/clean';
        $options = json_encode(
            array(
                "fileName" => $fileName,
                "userName" => $userName,
                "ftpHost" => $ftpHost,
                "ftpPassword" => $ftpPassword,
                "header" => array(
                    "header" => $header,
                    "emailIndex" => $index
                ),
                "options" => array(
                    "mxOnly" => "true",
                    "mxStandard" => "true",
                    "botClickers" => "true",
                    "blackListed" => "true",
                    "spamTraps" => "true",
                    "hardBounces" => "true",
                    "complainers" => "true",
                    "badWords" => "true",
                    "longEmails" => "true",
                    "syntaxErrors" => "true",
                    "fixedMisSpelledDomains" => "true",
                    "fixedLatinLetters" => "true",
                    "roles" => "true",
                    "duplicates" => "true",
                    "disposables" => "true",
                    "departmentals" => "true",
                    "threatStrings" => "true",
                    "threatEndings" => "true"
                )
            )

        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $scrubberURL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $options);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function upload_to_ftp($host, $usr, $pwd, $local_file, $fileName)
    {

        $fp = fopen($local_file, 'r');
        $ftp_path = '/dirty/' . $fileName;
        $conn_id = ftp_connect($host, 21);
        ftp_login($conn_id, $usr, $pwd);
        ftp_pasv($conn_id, true);
        $upload = ftp_fput($conn_id, $ftp_path, $fp, FTP_ASCII);
        ftp_close($conn_id);
        return $upload;
    }

    public function download_from_ftp_problem($cleanId, $onlyReport = false)
    {

        $user = $this->Mdl_user->fetch_user_profile();

        $conn_id = ftp_connect($user["ftphost"], 21);

        ftp_login($conn_id, $user["username"], $user["ftppassword"]);
        ftp_pasv($conn_id, true);

        $extension = ($onlyReport ? '.pdf' : '.zip');

        $fileTo = $_SERVER["DOCUMENT_ROOT"] . '/test.verifyrocket.com/tmp/' . $cleanId . $extension;

        $handle = fopen($fileTo, 'w');
        if(!file_exists($fileTo)) {
            echo 'Could not create that shit file';
        }

        $fileFrom = 'clean/' . ($onlyReport ? 'report_' : '') . $cleanId . $extension;

        $contentType = ($onlyReport ? 'text/csv' : 'application/octet-stream');

        $downloadFromFTP = ftp_fget($conn_id, $handle, $fileFrom, FTP_ASCII, 0);
        ftp_close($conn_id);
        //fclose($handle);

        if($downloadFromFTP) {
            //if (file_exists($fileTo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $contentType);
            header('Content-Disposition: attachment; filename="'.$cleanId . $extension.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileTo));
            readfile($fileTo);
            fclose($handle);
            //}
        }
        else {
            echo '
                Failed to download file from FTP. 
                ';
        }

    }

    public function download_from_ftp($cleanId, $onlyReport = false)
    {

        $user = $this->Mdl_user->fetch_user_profile();

        $conn_id = ftp_connect($user["ftphost"], 21);

        ftp_login($conn_id, $user["username"], $user["ftppassword"]);
        ftp_pasv($conn_id, true);

        $extension = ($onlyReport ? '.pdf' : '.zip');

        $fileTo = getcwd() . '/tmp/' . $cleanId . $extension;

        $fileFrom = 'clean/' . ($onlyReport ? 'report_' : '') . $cleanId . $extension;

        $contentType = ($onlyReport ? 'application/pdf' : 'application/octet-stream');

        $downloadFromFTP = ftp_get($conn_id, $fileTo, $fileFrom, FTP_BINARY);
        ftp_close($conn_id);
        //fclose($handle);

        if($downloadFromFTP) {
            //if (file_exists($fileTo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $contentType);
            header('Content-Disposition: attachment; filename="'.$cleanId . $extension.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileTo));
            readfile($fileTo);
            //}
        }
        else {
            echo '
                Failed to download file from FTP. 
                ';
        }

    }

    public function contact_upload()
    {
        $file_name = $_FILES["contactfile"]["name"];
        $file_tmp = $_FILES["contactfile"]["tmp_name"];


        $file_id_str = "";
        $user_id = $this->session->email_lookup_user_id;
        $file_check = $this->Mdl_user->fetch_user_file_by_name($_FILES["contactfile"]["name"]);
        $column_number_2 = $this->input->post("column_number_2");
        if ($column_number_2 == "") {
            echo '
			Sorry, Email not found in this file. 
			';
        } else if (count($file_check) > 0) {
            echo '
			Sorry, You already uploded this file. 
			';
        } else {
            $column_number_2 = $column_number_2 - 1;
            $dash_profile = $this->Mdl_user->fetch_user_profile();
            $current_package = $this->Mdl_user->fetch_current_package();
            $daily_limit = $this->Mdl_user->fetch_user_daily_limit();

            if ($daily_limit > -1) {
                $daily_limit_left = $current_package['daily_limit'] - $daily_limit;
            } else {
                $daily_limit_left = 0;
            }

            $total_usable_credit = $daily_limit_left + $dash_profile['balance'];

            $contactfile = $_FILES['contactfile']['tmp_name'];
            $contactfile_line = file($contactfile);


            $contactfile_line = array_reverse($contactfile_line);
            $result = array();
            foreach ($contactfile_line as $value) {
                $line = explode(",", $value);
                $line[$column_number_2] = trim($line[$column_number_2]);
                $line[$column_number_2] = strtolower($line[$column_number_2]);
                $result[$line[$column_number_2]] = $value;
            }
            $result = array_reverse($result);

            $result_string_full = implode("", $result);

            $contactfile_length = count($result);

            if ($contactfile_length > $total_usable_credit) {
                redirect("User_controller/have_not_balance");
            }

            $grid = $this->db->getGridFS();

            $file_id = $grid->storeBytes($result_string_full);

            foreach ($file_id as $file_id_value) {
                $file_id_str = $file_id_value;
            }
            $i = 0;
            $status = array();
            $status['stage'] = "not done";

            if ($_FILES["contactfile"]["error"] == 0) {
                $name = trim($_FILES["contactfile"]["name"]);

                if ($file_id != '') {
                    $csv_files_total_row = $contactfile_length;
                    $csv_files_total_row = intval($csv_files_total_row);
                    $data = array(
                        "fs_file_id" => $file_id,
                        "user" => $user_id,
                        "file_name" => $name,
                        "upload_time" => new MongoDate(strtotime(date('Y-m-d H:i:s'))),
                        "process_end_time" => "",
                        "status" => "Uploaded",
                        "progress" => (double)0

                    );


                    $upload = $this->Mdl_user->contact_upload_file_mdl($data);

                    $user_file_data = $this->Mdl_user->fetch_user_file_id($file_id_str);

                    $credit_reduce = $this->credit_reduce($csv_files_total_row, "File Cleanup", $user_file_data['_id']);

                    $user_file_data_id = $user_file_data['_id'];
                    $status['stage'] = "ok";
                    redirect(site_url("User_controller/sendUploadRequest/" . $user_file_data['_id']));
                    //echo 'Successfully Uploaded./'.$user_file_data['_id'];
                }
            } else {
                echo 'Sorry, Try again';
            }

        }
    }

    public function have_not_balance()
    {

        echo 'Sorry you have not Sufficient Balance';
    }

    public function sendUploadRequest($fileID)
    {
        $client = new Client();
        $request = 'URL : "http://localhost:8080/EmailCleanupAPI/cleanup",<br>Data : { "form_params" : { "file_id" : "' . $fileID . '" } }';
        $response = $client->request('POST', 'http://localhost:8080/EmailCleanupAPI/cleanup', [
            'form_params' => [
                'file_id' => $fileID
            ]
        ]);
        $response_str = $response->getBody()->getContents();
        //echo $response_str;
        $result = $this->Mdl_user->contact_upload_file_api_response_mdl($request, $response_str, $fileID);

        echo 'Successfully Uploaded./' . $fileID;
        //['form_params' => [  'file_id' => $fileID ] ]
        //{'form_params' => {  'file_id' => $fileID } }

    }


    public function sendInstantCheckupRequest()
    {


        /*// create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "example.com");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);*/

        $email = trim($this->input->get('email'));
        //$api_key = $this->user_prifile['api_key'];

        $service_url = 'http://205.134.243.198:3001/search?email='.$email;

        $curl = curl_init($service_url);

        /*$curl_post_data = array(

            'api_key' => $api_key,
            'email' => $numbers

        );
        $fields_string = http_build_query($curl_post_data);*/

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($curl, CURLOPT_POST, true);

        //curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        $response_str = curl_exec($curl);


        curl_close($curl);

        //$numbers = $this->input->post('email');
        /*$target = 'http://64.187.105.81/RealTimeApi.aspx?AuthorizationToken=4K1093573T706643M&Email='.$numbers;

        $curl = curl_init($target);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        curl_close($curl);

        $response_str = $curl_response;
        */


       /* $numbers_array = explode(",", $numbers);
        $numbers_count = count($numbers_array);
        $expense = $numbers_count;*/

        //$credit_reduce = $this->credit_reduce($expense,'Instant Lookup');
/*
        $instant_lookup = array();
        $instant_lookup['user'] = $this->session->email_lookup_user_id;
        $instant_lookup['numbers'] = $numbers;
        $instant_lookup['numbers_count'] = intval($numbers_count);
        $instant_lookup['response'] = $response_str;
        $instant_lookup['time'] = new MongoDate(strtotime(date('Y-m-d H:i:s')));*/

        //echo $response_str;
        //$result = $this->Mdl_user->contact_upload_file_api_response_mdl($request,$response_str,$fileID);
        //$this->Mdl_user->insert_any_collection('instant_lookup',$instant_lookup);

        //$response = json_decode($response_str);
        echo $response_str;
        //echo 'Successfully Uploaded. ';
        //['form_params' => [  'file_id' => $fileID ] ]
        //{'form_params' => {  'file_id' => $fileID } }

    }

    public function report_instant_lookup($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Instant Clean';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_instant_lookup';
        $data['view']['section'] = 'report_instant_lookup';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/instant_lookup/';
        $config["total_rows"] = $this->Mdl_user->count_all_rows_instant_lookup();
        //print $config["total_rows"];die();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["instant_lookup_details"] = $this->Mdl_user->get_all_instant_lookup($config["per_page"], $page);
        //$data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_price_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }

    public function failed_upload($parm1 = '')
    {
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Failed Upload';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'failed_upload';
        $data['view']['section'] = 'failed_upload';
        $config = array();

        $config["base_url"] = base_url() . 'report/failed_upload/';

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_credit_expense($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Credit Usage';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_credit_expense';
        $data['view']['section'] = 'report_credit_expense';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/credit/expense/';
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_credit_expense();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 4;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_credit_expense($config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_credit_expense_credit_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_credit_expense_by_date($from, $to, $parm1 = '')
    {
        //echo $id;

        $from_pre = $from;
        $to_pre = $to;
        $from = date($from . ' 00:00:00');
        $to = date($to . ' 23:59:59');


        $from_iso = new MongoDate(strtotime($from));
        $to_iso = new MongoDate(strtotime($to));

        $date_array_1 = array();
        $date_array_1 = explode(" ", $from_iso);
        $date_1 = date('F j, Y', $date_array_1[1]);

        $date_array_2 = array();
        $date_array_2 = explode(" ", $to_iso);
        $date_2 = date('F j, Y', $date_array_2[1]);

        if ($date_1 == $date_2)
            $date_title = $date_1;
        else
            $date_title = $date_1 . ' - ' . $date_2;


        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Credit Usage ( ' . $date_title . ' )';
        $data['view']['section'] = 'report_credit_expense_by_date';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_credit_expense_by_date';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['from'] = $from_pre;
        $data['to'] = $to_pre;
        $config = array();

        $config["base_url"] = base_url() . 'report/credit/expense_by_date/' . $from_pre . '/' . $to_pre;
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_credit_expense_by_date($from, $to);

        //print $config["total_rows"];die();

        $config["per_page"] = 50;
        $config["uri_segment"] = 6;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_credit_expense_by_date($from, $to, $config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_credit_expense_by_date_credit_sum($from, $to);

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_credit_buy($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Credit Purchases';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_credit_buy';
        $data['view']['section'] = 'report_credit_buy';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/credit/buy/';
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_credit_buy();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 4;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_credit_buy($config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_credit_buy_credit_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_credit_buy_by_date($from, $to, $parm1 = '')
    {
        //echo $id;

        $from_pre = $from;
        $to_pre = $to;
        $from = date($from . ' 00:00:00');
        $to = date($to . ' 23:59:59');


        $from_iso = new MongoDate(strtotime($from));
        $to_iso = new MongoDate(strtotime($to));

        $date_array_1 = array();
        $date_array_1 = explode(" ", $from_iso);
        $date_1 = date('F j, Y', $date_array_1[1]);

        $date_array_2 = array();
        $date_array_2 = explode(" ", $to_iso);
        $date_2 = date('F j, Y', $date_array_2[1]);

        if ($date_1 == $date_2)
            $date_title = $date_1;
        else
            $date_title = $date_1 . ' - ' . $date_2;


        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Credit Purchases ( ' . $date_title . ' )';
        $data['view']['section'] = 'report_credit_buy_by_date';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_credit_buy_by_date';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['from'] = $from_pre;
        $data['to'] = $to_pre;
        $config = array();

        $config["base_url"] = base_url() . 'report/credit/buy_by_date/' . $from_pre . '/' . $to_pre;
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_credit_buy_by_date($from, $to);

        //print $config["total_rows"];die();

        $config["per_page"] = 50;
        $config["uri_segment"] = 6;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_credit_buy_by_date($from, $to, $config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_credit_buy_by_date_credit_sum($from, $to);

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }







    //	start package report
    //	start package report

    public function report_daily_limit_expense($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Report';
        $data['view']['page_sub_title'] = 'Daily Limit Expense';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_daily_limit_expense';
        $data['view']['section'] = 'report_daily_limit_expense';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/daily_limit/expense/';
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_daily_limit_expense();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 4;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_daily_limit_expense($config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_daily_limit_expense_credit_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_daily_limit_expense_by_date($from, $to, $parm1 = '')
    {
        //echo $id;

        $from_pre = $from;
        $to_pre = $to;
        $from = date($from . ' 00:00:00');
        $to = date($to . ' 23:59:59');


        $from_iso = new MongoDate(strtotime($from));
        $to_iso = new MongoDate(strtotime($to));

        $date_array_1 = array();
        $date_array_1 = explode(" ", $from_iso);
        $date_1 = date('F j, Y', $date_array_1[1]);

        $date_array_2 = array();
        $date_array_2 = explode(" ", $to_iso);
        $date_2 = date('F j, Y', $date_array_2[1]);

        if ($date_1 == $date_2)
            $date_title = $date_1;
        else
            $date_title = $date_1 . ' - ' . $date_2;


        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Report';
        $data['view']['page_sub_title'] = 'Daily Limit Expense ( ' . $date_title . ' )';
        $data['view']['section'] = 'report_daily_limit_expense_by_date';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_daily_limit_expense';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['from'] = $from_pre;
        $data['to'] = $to_pre;
        $config = array();

        $config["base_url"] = base_url() . 'report/daily_limit/expense_by_date/' . $from_pre . '/' . $to_pre;
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_daily_limit_expense_by_date($from, $to);

        //print $config["total_rows"];die();

        $config["per_page"] = 50;
        $config["uri_segment"] = 6;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_daily_limit_expense_by_date($from, $to, $config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_daily_limit_expense_by_date_credit_sum($from, $to);

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_package_buy($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Package Purchases';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_package_buy';
        $data['view']['section'] = 'report_package_buy';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/package/buy/';
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_package_buy();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 4;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_package_buy($config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_package_buy_credit_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_package_buy_by_date($from, $to, $parm1 = '')
    {
        //echo $id;

        $from_pre = $from;
        $to_pre = $to;
        $from = date($from . ' 00:00:00');
        $to = date($to . ' 23:59:59');


        $from_iso = new MongoDate(strtotime($from));
        $to_iso = new MongoDate(strtotime($to));

        $date_array_1 = array();
        $date_array_1 = explode(" ", $from_iso);
        $date_1 = date('F j, Y', $date_array_1[1]);

        $date_array_2 = array();
        $date_array_2 = explode(" ", $to_iso);
        $date_2 = date('F j, Y', $date_array_2[1]);

        if ($date_1 == $date_2)
            $date_title = $date_1;
        else
            $date_title = $date_1 . ' - ' . $date_2;


        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Package Purchases ( ' . $date_title . ' )';
        $data['view']['section'] = 'report_package_buy_by_date';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_package_buy';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['from'] = $from_pre;
        $data['to'] = $to_pre;
        $config = array();

        $config["base_url"] = base_url() . 'report/package/buy_by_date/' . $from_pre . '/' . $to_pre;
        $config["total_rows"] = $this->Mdl_user->count_all_transaction_credit_buy_by_date($from, $to);

        //print $config["total_rows"];die();

        $config["per_page"] = 50;
        $config["uri_segment"] = 6;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_transaction_package_buy_by_date($from, $to, $config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_transaction_package_buy_by_date_credit_sum($from, $to);

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }

    //	end package report
    //	end package report


    public function file_upload_status_chart($file_id)
    {
        $data['file_status_value_value'] = $this->Mdl_user->fetch_user_file_id($file_id);
        $this->load->view("user/file_upload_status_chart", $data);
    }

    public function file_status($parm1 = '')
    {

        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");

        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Cleaned Files';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'file_upload_status';
        $data['view']['section'] = 'file_status';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/file_status';
        $config["total_rows"] = $this->Mdl_user->count_all_rows_user_file();
        //print $config["total_rows"];die();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["file_status"] = $this->Mdl_user->
        fetch_user_file($config["per_page"], $page);
        //print_r($data["file_status"]);die();
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function file_upload_status($parm1 = '')
    {

        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");

        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Cleaned Files';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'file_upload_status';
        $data['view']['section'] = 'file_upload_status';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/file_upload_status';
        $config["total_rows"] = $this->Mdl_user->count_all_rows_user_file();
        //print $config["total_rows"];die();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["file_status"] = $this->Mdl_user->fetch_user_file($config["per_page"], $page);
        //print_r($data["file_status"]);die();
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }

    public function file_upload_status_ajax($parm1 = '')
    {
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['section'] = 'file_upload_status';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'file_upload_status';
        $config["total_rows"] = $this->Mdl_user->count_all_rows_user_file();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["file_status"] = $this->Mdl_user->
        fetch_user_file($config["per_page"], $page);
        //print_r($data["file_status"]);die();
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();
        echo '
	        <div class="table-responsive">
	        	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="">Name</th>
                                                <th class="">Split</th>
                                                <th class="">Uploaded at</th>
                                                <th class="">Completed at</th>
                                                <th class="">Groups</th>
                                                <th class="">Total Contact</th>
                                                <th class="">Valid Contact</th>
                                                <th class="">Invalid Contact</th>
                                                <th class=""></th>
                                            </tr>
                                        </thead>
                                        <tbody>';

        $i = $data['serial'] + 1;
        foreach ($data["file_status"] as $file_status_key => $file_status_value) {
            foreach ($file_status_value as $file_status_value_key => $file_status_value_value) {
                $api_log = array();
                $api_log = $this->Mdl_user->get_api_log_single($file_status_value_value['_id']);

                $row = 'odd';
                if ($i % 2 == 0) $row = 'even';
                $date = "";
                $date_array = array();
                if ($file_status_value_value['process_end_time'] != "") {
                    $date_array = explode(" ", $file_status_value_value['process_end_time']);
                    $date = date('F j, Y, g:i a', $date_array[1]);
                }

                echo '
	                                            		<tr class="' . $row . '" role="row">
                                                            <td>' . $file_status_value_value['file_name'] . '</td>
                                                            <td>' . $file_status_value_value['split_at'] . '</td>
                                                            <td>' . $file_status_value_value['upload_time'] . '</td>
                                                            <td>' . $date . '</td>
                                                            <td>' . $file_status_value_value['total_group'] . '</td>
                                                            <td>' . $file_status_value_value['total_contacts'] . '</td>
                                                            <td>' . $file_status_value_value['valid_contacts'] . '</td>
			                                                <td>' . $file_status_value_value['invalid_contacts'] . '</td>
			                                                <td><a class="btn btn-success" href="#api_log' . $file_status_value_value['_id'] . '" data-toggle="modal">API Log</a></td>
			                                           
			                                            </tr>
	                                            		';
                echo '<div id="api_log' . $file_status_value_value['_id'] . '" class="modal fade" tabindex="-1" data-width="760">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                    <h4 class="modal-title">' . $file_status_value_value['file_name'] . ' API Log</h4>
                                                                                </div>
                                                                                <div class="modal-body payment_method_body">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 text-center">
                                                                                            ';
                if (count($api_log) > 0) {
                    echo '
                                                                                                <b>Request:</b>
                                                                                                <p>' . $api_log['request'] . '</p>
                                                                                                <b>Response:</b>
                                                                                                <p>' . $api_log['response'] . '</p>

                                                                                                ';
                }
                echo '
                                                                                        </div>
                                                                                            
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <!--<a class="btn btn-outline green" data-dismiss="modal">Select this</a>-->
                                                                                    <a data-dismiss="modal" class="btn btn-outline dark">Cancel</a>
                                                                                </div>
                                                                            </div>';

            }
            $i++;
        }
        echo '
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="pagination_box text-right">
                                        ' . $data["pagination_links"] . '
                                    </div>
	        ';


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function file_download_as_criteria()
    {


        $category_array['carrier'] = 7;
        $category_array['carrier_type'] = 6;
        $category_array['country'] = 5;
        $category_array['state'] = 4;
        $category_array['city'] = 3;
        $category_array['wireless'] = 2;

        $file_id = strtolower($this->input->post("file_id"));
        $carrier = strtolower($this->input->post("carrier"));
        $carrier_type = strtolower($this->input->post("carrier_type"));
        $state = strtolower($this->input->post("state"));
        $city = strtolower($this->input->post("city"));
        $wireless = strtolower($this->input->post("wireless"));

        $name = $carrier . '-' . $carrier_type . '-' . $state . '-' . $city . '-' . $wireless . '-';

        $user_file_row = $this->Mdl_user->fetch_user_file_id($file_id);
        $look_file_id = $user_file_row['look_file_id'];
        $images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($look_file_id)));
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=" . str_replace(" ", "-", $name) . $user_file_row['file_name']);
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        $data = str_replace("\n", "\",\n", $data);
        $data_array = explode("\n", $data);
        foreach ($data_array as $key => $line) {
            $line_array = array();
            $line_array = explode(",", $line);
            //echo $line_array[count($line_array) - $category_array[$category]];
            if (strlen($line) > 0) {
                /*$checkdata = strtolower($line_array[count($line_array) - $category_array[$category]]);
                $checkdata = str_replace('"','',$checkdata);
                similar_text($name,$checkdata,$percent);
                 if($percent > 95)
                     echo $line,"\n";
                     */
                $print_status = 0;
                if ($carrier == "") {
                    $print_status = 1;
                } else {
                    $checkdata = strtolower($line_array[count($line_array) - $category_array['carrier']]);
                    $checkdata = str_replace('"', '', $checkdata);
                    similar_text($carrier, $checkdata, $percent);
                    if ($percent > 95) $print_status = 1;
                    else $print_status = 0;

                }
                if ($print_status == 1) {
                    if ($carrier_type == "") {
                        $print_status = 1;
                    } else {
                        $checkdata = strtolower($line_array[count($line_array) - $category_array['carrier_type']]);
                        $checkdata = str_replace('"', '', $checkdata);
                        similar_text($carrier_type, $checkdata, $percent);
                        if ($percent > 95) $print_status = 1;
                        else $print_status = 0;
                    }
                }

                if ($print_status == 1) {
                    if ($state == "") {
                        $print_status = 1;
                    } else {
                        $checkdata = strtolower($line_array[count($line_array) - $category_array['state']]);
                        $checkdata = str_replace('"', '', $checkdata);
                        similar_text($state, $checkdata, $percent);
                        if ($percent > 95) $print_status = 1;
                        else $print_status = 0;
                    }
                }

                if ($print_status == 1) {
                    if ($city == "") {
                        $print_status = 1;
                    } else {
                        $checkdata = strtolower($line_array[count($line_array) - $category_array['city']]);
                        $checkdata = str_replace('"', '', $checkdata);
                        similar_text($city, $checkdata, $percent);
                        if ($percent > 95) $print_status = 1;
                        else $print_status = 0;
                    }
                }

                if ($print_status == 1) {
                    if ($wireless == "") {
                        $print_status = 1;
                    } else {
                        $checkdata = strtolower($line_array[count($line_array) - $category_array['wireless']]);
                        $checkdata = str_replace('"', '', $checkdata);
                        similar_text($wireless, $checkdata, $percent);
                        if ($percent > 95) $print_status = 1;
                        else $print_status = 0;
                    }
                }

                if ($print_status == 1)
                    echo $line, "\n";
            }
        }

    }

    public function file_download($file_id)
    {

        $user_file_row = $this->Mdl_user->fetch_user_file_id($file_id);
        $look_file_id = $user_file_row['look_file_id'];
        $images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($look_file_id)));
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=" . $user_file_row['file_name']);
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        echo str_replace("\n", "\",\n", $data);

    }


    public function report_file_download($id)
    {

        $this->download_from_ftp($id, true);
        /*$images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($id)));
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=report_" . $id . ".pdf");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        echo $data;*/
        /*$a = new PDF2Text();
        $a->setFilename($data); //grab the test file at http://www.newyorklivearts.org/Videographer_RFP.pdf
        $a->decodePDF();
        $output = $a->output();
        echo $output;
        */


    }

    public function test_pdf($id)
    {
        $images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($id)));
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=report_" . $id . ".pdf");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        echo $data;
    }

    public function clean_file_download($id)
    {

        $this->download_from_ftp($id);
        /*$images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($id)));
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=clean_" . $id . ".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        echo $data;*/
        //echo str_replace("\n","\",\n",$data);

    }

    public function smtp_clean_file_download($id)
    {

        $images = $this->db->getGridFS();
        $image = $images->findOne(array('_id' => new MongoId($id)));
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=smtp_clean_" . $id . ".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = $image->getBytes();
        echo $data;
        //echo str_replace("\n","\",\n",$data);

    }


    public function instant_lookup_report_download_by_id($id)
    {
        $result = $this->Mdl_user->instant_lookup_by_id($id);
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=" . $result['_id'] . ".txt");

        // do your Db stuff here to get the content into $content

        print $result['response'];
    }


    public function api_lookup_file()
    {


        $data['view']['page_title'] = 'API (Lookup File)';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'api_lookup_file';
        $data['view']['menu'] = 'api';
        $data['view']['submenu'] = 'api_lookup_file';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');


        $this->load->view("user/dashboard", $data);
    }

    public function api_numbers_lookup()
    {


        $data['view']['page_title'] = 'API (Numbers Lookup)';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'api_numbers_lookup';
        $data['view']['menu'] = 'api';
        $data['view']['submenu'] = 'api_numbers_lookup';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');


        $this->load->view("user/dashboard", $data);
    }

    public function api_download_lookup_file()
    {


        $data['view']['page_title'] = 'API (Download Lookup File)';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'api_download_lookup_file';
        $data['view']['menu'] = 'api';
        $data['view']['submenu'] = 'api_download_lookup_file';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');


        $this->load->view("user/dashboard", $data);
    }

    public function api_lookup_file_status()
    {


        $data['view']['page_title'] = 'API (Lookup File Status)';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'api_lookup_file_status';
        $data['view']['menu'] = 'api';
        $data['view']['submenu'] = 'api_lookup_file_status';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');


        $this->load->view("user/dashboard", $data);
    }

    public function old_pass_check($parm1 = '')
    {
        //$this->load->model('Mdl_login');
        if ($parm1 != '') {
            $enc_password = sha1($parm1);
            //die();
            $fetch_user_login = $this->Mdl_user->check_password($enc_password);
            if ($fetch_user_login) {
                echo '1';                                                // if user logged in
            } else {
                echo '0';
            }
        } else
            echo '0';
    }

    public function password_update($old, $new_1, $new_2)
    {

        //echo $old.','.$new_1.','.$new_2.',';
        $enc_password = sha1($old);
        $enc_password_2 = sha1($new_1);
        $fetch_user_login = $this->Mdl_user->check_password($enc_password);
        if ($fetch_user_login) {
            if ($new_1 == $new_2 && strlen($new_1) > 5) {
                $this->Mdl_user->set_password($enc_password_2);
                echo '1';
            } else
                echo '0';
        } else
            echo '0';
    }

    public function file_delete($id)
    {

        $this->session->set_flashdata(array('msg' => 'Under development! Not implemented yet.', 'msg_type' => 'danger'));
        redirect("report/file_upload_status");
        return;
        /*$user_id = $this->session->email_lookup_user_id;
        $delete = $this->db->user_file->remove(array('_id' => new MongoId($id), 'user' => new MongoId($user_id)));
        if ($delete['ok'] == 1)
            $this->session->set_flashdata(array('msg' => 'Successfully Deleted that file.', 'msg_type' => 'success'));
        else
            $this->session->set_flashdata(array('msg' => 'Sorry, Please try again.', 'msg_type' => 'danger'));
        redirect("report/file_upload_status");*/
    }

    public function failed_file_delete()
    {

        $user_id = $this->session->email_lookup_user_id;
        $delete = $this->db->user_file->remove(array('status' => 'failed', 'user' => new MongoId($user_id)));
        if ($delete['ok'] == 1)
            $this->session->set_flashdata(array('msg' => 'Successfully Deleted failed processed files.', 'msg_type' => 'success'));
        else
            $this->session->set_flashdata(array('msg' => 'Sorry, Please try again.', 'msg_type' => 'danger'));
        redirect("contact_upload_section");
    }

    public function report_failed_upload_ajax()
    {

    }


    public function report_invoice($parm1 = '')
    {
        //echo $id;
        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Invoices';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_invoice';
        $data['view']['section'] = 'report_invoice';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $config = array();

        $config["base_url"] = base_url() . 'report/invoice/';
        $config["total_rows"] = $this->Mdl_user->count_all_invoice();
        //print $config["total_rows"];die();
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_invoice($config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_invoice_price_sum();

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }


    public function report_invoice_by_date($from, $to, $parm1 = '')
    {
        //echo $id;

        $from_pre = $from;
        $to_pre = $to;
        $from = date($from . ' 00:00:00');
        $to = date($to . ' 23:59:59');


        $from_iso = new MongoDate(strtotime($from));
        $to_iso = new MongoDate(strtotime($to));

        $date_array_1 = array();
        $date_array_1 = explode(" ", $from_iso);
        $date_1 = date('F j, Y', $date_array_1[1]);

        $date_array_2 = array();
        $date_array_2 = explode(" ", $to_iso);
        $date_2 = date('F j, Y', $date_array_2[1]);

        if ($date_1 == $date_2)
            $date_title = $date_1;
        else
            $date_title = $date_1 . ' - ' . $date_2;


        if ($parm1 == '')
            $data['serial'] = 0;
        else
            $data['serial'] = $parm1;
        $this->load->library("pagination");
        $data['view']['page_title'] = 'Reports';
        $data['view']['page_sub_title'] = 'Invoices ( ' . $date_title . ' )';
        $data['view']['section'] = 'report_invoice_by_date';
        $data['view']['menu'] = 'report';
        $data['view']['submenu'] = 'report_invoice';
        $data['view']['msg'] = $this->session->flashdata('msg');
        $data['view']['msg_type'] = $this->session->flashdata('msg_type');
        $data['from'] = $from_pre;
        $data['to'] = $to_pre;
        $config = array();

        $config["base_url"] = base_url() . 'report/invoice_by_date/' . $from_pre . '/' . $to_pre;
        $config["total_rows"] = $this->Mdl_user->count_all_invoice_by_date($from, $to);

        //print $config["total_rows"];die();

        $config["per_page"] = 50;
        $config["uri_segment"] = 5;
        $config['num_links'] = 3;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['cur_tag_open'] = '<a  class="btn btn-square btn-primary">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'group_pagination_link btn btn-square btn-warning');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data["expense_details"] = $this->Mdl_user->get_all_invoice_by_date($from, $to, $config["per_page"], $page);
        $data["expense_price_sum"] = $this->Mdl_user->get_all_invoice_by_date_price_sum($from, $to);

        //echo $data["expense_price_sum"];
        $data["pagination_links"] = $this->pagination->create_links();
        //print_r($data["pagination_links"]);
        //die();

        $this->load->view("user/dashboard", $data);


        //$data['groups_document'] = $this->Mdl_user->fetch_groups();
        //print_r($data['groups_document']);die();

    }

    //	end invoice report
    //	end invoice report

    public function download_invoice($id)
    {
        $data = array();
        $data['invoice'] = $this->Mdl_user->get_invoice_by_id($id);
        $this->load->view("user/download_invoice", $data);

    }

    public function pricing_contact_us()
    {

        $requirement = trim($this->input->post('requirement'));
        $data = array();
        $msg = 'Sorry, Your requirement was blank.';
        $msg_type = false;
        if ($requirement) { //echo $requirement;
            $data['user_id'] = new MongoId($this->session->email_lookup_user_id);
            $data['requirement'] = $requirement;
            $this->Mdl_user->insert_any_collection('custom_pricing_contact', $data);
            $msg = 'Your requirements have been received.<br>We will contact you within 12 hours.';
            $msg_type = true;
        }

        $data['view']['page_title'] = '';
        $data['view']['page_sub_title'] = '';
        $data['view']['section'] = 'pricing_contact_us';
        $data['view']['menu'] = '';
        $data['view']['submenu'] = '';
        $data['view']['msg'] = $msg;
        $data['view']['msg_type'] = $msg_type;


        $this->load->view("user/dashboard", $data);

    }


}