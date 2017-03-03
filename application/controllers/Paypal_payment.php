<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/autoload.php');

class Paypal_payment extends CI_Controller
{  
    private $ec_action = 'Recurring';
    public function __construct()
    {

        parent::__construct();

		// Load helpers
		$this->load->helper('url');
		
		// Load PayPal library
		$this->config->load('paypallib_config');
		
        $paypal_details = array(
			// you can get this from your Paypal account, or from your
			// test accounts in Sandbox
			'API_username' => $this->config->item('APIUsername'), 
			'API_signature' => $this->config->item('APISignature'), 
			'API_password' => $this->config->item('APIPassword'),
			// Paypal_ec defaults sandbox status to true
			// Change to false if you want to go live and
			// update the API credentials above
			'sandbox_status' => $this->config->item('Sandbox'),
		);
		$this->load->library('paypal_ec', $paypal_details);
        
         $this->load->model('Mdl_user');

        $this->user_prifile = $this->Mdl_user->fetch_user_profile();
    }
    
    public function index()
    {
        show_error('you are not authorized to view this page!');
    }
    
    public function checkout_buy_credit()
    {
        $this->ec_action = "Sale";
        $dash_profile = $this->Mdl_user->fetch_user_profile();
        
        $credit_count = $this->input->post('credit_count');
        $total_price = $this->input->post('total_price');
        $total_price = number_format((double)$total_price, 2, '.', '');
        //$total_price = 0.01;
        
        $product = array('package' => array('name' => 'Credit Buy', 'desc' => 'Number Lookup credit buy.', 'price' => $total_price, 'code' => $credit_count));
        $currency = $this->config->item('paypal_lib_currency_code');
            
        $to_buy = array(
			'desc' => 'Purchase from '.$this->config->item('site_name'), 
			'currency' => $currency, 
			'type' => $this->ec_action, 
			'return_URL' => site_url('paypal_payment/return_checkout_buy_credit'), 
			// see below have a function for this -- function back()
			// whatever you use, make sure the URL is live and can process
			// the next steps
			'cancel_URL' => site_url('buy_credit'), // this goes to this controllers index()
			'shipping_amount' => 0.00, 
			'get_shipping' => false);
        
        foreach($product as $p) {
			$temp_product = array(
    				'name' => $p['name'], 
    				'desc' => $p['desc'], 
    				'number' => $p['code'], 
    				'quantity' => 1, // simple example -- fixed to 1
    				'amount' => $p['price']);
    				
			// add product to main $to_buy array
			$to_buy['products'][] = $temp_product;
        }
        
        $set_ec_return = $this->paypal_ec->set_ec($to_buy);
        //print_r($set_ec_return);die;
        if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
    			// redirect to Paypal
			$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
 		} else {
			//$this->_error($set_ec_return);
            $this->session->set_flashdata(array('msg' => 'Sorry, Please Try again!', 'msg_type' => 'danger'));
            redirect('buy_credit');
 		}
    }
    
    public function return_checkout_buy_credit()
    {
        $this->ec_action = "Sale";
        $token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
        
        $get_ec_return = $this->paypal_ec->get_ec($token);
        if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
            $ec_details = array(
				'token' => $token, 
				'payer_id' => $payer_id, 
				'currency' => $get_ec_return['CURRENCYCODE'], 
				'amount' => $get_ec_return['AMT'], 
				//'IPN_URL' => site_url('test/ipn'), 
				// in case you want to log the IPN, and you
				// may have to in case of Pending transaction
				'type' => $this->ec_action);
            
            // DoExpressCheckoutPayment
            $do_ec_return = $this->paypal_ec->do_ec($ec_details);
            if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                $data = array();
                $credit_count = (int)$get_ec_return['L_NUMBER0'];
                $data['price'] = $get_ec_return['AMT'];
                $data['credit'] = (int)$credit_count;
                $data['is_debit'] = true;
                $data['user'] = $this->session->email_lookup_user_id;
                $data['time'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
                $data['notes'] = 'Paypal Credit Buy';
                $result = $this->Mdl_user->transaction_insert($data);
                $this->session->set_flashdata(array('msg' => $credit_count, 'msg_type' => 'success'));
                if ($result['ok'] == 1) {
                    $super_admin_data = $this->Mdl_user->fetch_sa_data();
                    $dash_profile = $this->Mdl_user->fetch_user_profile();
                    
                    $invoice['user_id'] = new MongoId($this->session->email_lookup_user_id);
                    $invoice['name'] = $dash_profile['firstname'] . ' ' . $dash_profile['lastname'];
                    $invoice['address'] = $dash_profile['address'];
                    $invoice['contact'] = $dash_profile['contact'];
                    $invoice['description'] = 'Pay as you go';
                    $invoice['contact'] = $dash_profile['contact'];
                    $invoice['price'] = $data['price'];
                    $invoice['validity'] = 'Unlimited';
                    $invoice['credit'] = $data['credit'];
                    $invoice['invoice_id'] = $this->Mdl_user->invoice_id_generate();
                    $invoice['invoice_from'] = $super_admin_data['company'];
                    $invoice['invoice_from_address'] = $super_admin_data['address'];
                    $invoice['datetime'] = new MongoDate(strtotime(date('y-m-d h:i:s')));
    
                    $this->Mdl_user->collection_insert($invoice, 'invoice');
    
                    $balance = (int)$credit_count;
                    $bal_result = $this->Mdl_user->set_new_balance($balance);
                    redirect('buy_credit_confirm/' . $credit_count);
                } else {
    
                    $this->session->set_flashdata(array('msg' => 'Sorry, Please Try again!', 'msg_type' => 'warning'));
                    redirect('buy_credit');
                }
            }else
            {
                $this->session->set_flashdata(array('msg' => 'Sorry, Please Try again!', 'msg_type' => 'danger'));
                redirect('buy_credit');
            }
            //End
        }else
        {
            $this->session->set_flashdata(array('msg' => 'Sorry, Please Try again!', 'msg_type' => 'danger'));
            redirect('buy_credit');
        }
    }
    
    public function checkout()
    {
        $invoice = array();
        
        $dash_profile = $this->Mdl_user->fetch_user_profile();

        $package_id = $this->input->post('package_id');
        $package_data = $this->Mdl_user->fetch_package_by_id($package_id);
        if (count($package_data) > 0) {
            $package_price = $package_data['price'];
            $package_price = number_format((double)$package_price, 2, '.', '');
            //$package_price = 0.01;
            $package_credit = $package_data['credit'];
            $userID = $this->session->email_lookup_user_id; //current user id
            
            $super_admin_data = $this->Mdl_user->fetch_sa_data();
            $invoice['name'] = $dash_profile['firstname'] . ' ' . $dash_profile['lastname'];
            $invoice['address'] = @$dash_profile['address'];
            $invoice['description'] = 'Package ( ' . $package_data['packname'] . ' )';
            
            $product = array('package' => array('name' => $package_data['packname'], 'desc' => $invoice['description'], 'price' => $package_price, 'code' => 'buy_package'));
            $currency = $this->config->item('paypal_lib_currency_code');
            
            $to_buy = array(
			'desc' => 'Purchase from '.$this->config->item('site_name'), 
			'currency' => $currency, 
			'type' => $this->ec_action, 
			'return_URL' => site_url('paypal_payment/return_checkout/'.$package_id), 
			// see below have a function for this -- function back()
			// whatever you use, make sure the URL is live and can process
			// the next steps
			'cancel_URL' => site_url('buy_package/'.$package_id), // this goes to this controllers index()
			'shipping_amount' => 0.00, 
			'get_shipping' => false);
            
            foreach($product as $p) {
    			$temp_product = array(
    				'name' => $p['name'], 
    				'desc' => $p['desc'], 
    				'number' => @$p['code'], 
    				'quantity' => 1, // simple example -- fixed to 1
    				'amount' => $p['price']);
    				
    			// add product to main $to_buy array
    			$to_buy['products'][] = $temp_product;
    		}
            
            $to_buy['billing_type'] = 'RecurringPayments';
            $to_buy['billingagreement_dec'] = $invoice['description'];
            
            // enquire Paypal API for token
    		$set_ec_return = $this->paypal_ec->set_ec($to_buy);
    		if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
    			// redirect to Paypal
    			$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
    		} else {
    			//$this->_error($set_ec_return);
                $this->session->set_flashdata(array('msg' => 'Sorry, your payment couldn\'t be completed', 'msg_type' => 'danger'));
                redirect("packages");
    		}
        }else
        {
            $this->session->set_flashdata(array('msg' => 'Sorry, Package not found.', 'msg_type' => 'danger'));
            redirect("packages");
        }
    }
    
    function return_checkout($package_id) {
		// we are back from Paypal. We need to do GetExpressCheckoutDetails
		// and DoExpressCheckoutPayment to complete.        
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
        $dash_profile = $this->Mdl_user->fetch_user_profile();
        $package_data = $this->Mdl_user->fetch_package_by_id($package_id);
		// GetExpressCheckoutDetails
		$get_ec_return = $this->paypal_ec->get_ec($token);
        //echo "<pre>";print_r($dash_profile);print_r($package_data);print_r($get_ec_return);
		if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
			// at this point, you have all of the data for the transaction.
			// you may want to save the data for future action. what's left to
			// do is to collect the money -- you do that by call DoExpressCheckoutPayment
			// via $this->paypal_ec->do_ec();
			//
			// I suggest to save all of the details of the transaction. You get all that
			// in $get_ec_return array
			$ec_details = array(
				'TOKEN' => $token, 
				'PayerID' => $payer_id, 
                'PROFILESTARTDATE'=>$get_ec_return['TIMESTAMP'],
                'DESC'=>$get_ec_return['L_DESC0'],
                'BILLINGPERIOD'=>'Month',
                'BILLINGFREQUENCY'=>'1',
				'CURRENCYCODE' => $get_ec_return['CURRENCYCODE'], 
                'COUNTRYCODE' => $get_ec_return['COUNTRYCODE'], 
				'AMT' => $get_ec_return['AMT'], 
                'MAXFAILEDPAYMENTS'=>3, 
                //'IPN_URL' => site_url('test/ipn'), 
				// in case you want to log the IPN, and you
				// may have to in case of Pending transaction
				'type' => $this->ec_action);
				
			// DoExpressCheckoutPayment
			$recuring_ec_return = $this->paypal_ec->recuring_ec($ec_details);
            //print_r($recuring_ec_return);die;
			if (isset($recuring_ec_return['ec_status']) && ($recuring_ec_return['ec_status'] === true)) {
				    
                    $package_price = $package_data['price'];
                    $package_price = number_format((double)$package_price, 2, '.', '');
                    $package_credit = $package_data['credit'];
                    
                    $data = array();
                    $data_2 = array();
                    $data_3 = array();
                    $data_4 = array();
                    $data['price'] = (double)$package_price;
                    $data['credit'] = (int)$package_credit;
                    $data['is_debit'] = true;
                    $data['user'] = $this->session->email_lookup_user_id;
                    $data['time'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
                    $data['notes'] = 'Paypal';

                    $data_2['user'] = $this->session->email_lookup_user_id;
                    $data_2['package'] = $package_id;
                    $data_2['purchase_time'] = new MongoDate(strtotime(date('Y-m-d 00:00:00')));

                    $data_3['user_id'] = $this->session->email_lookup_user_id;
                    $data_3['package_id'] = new MongoId($package_id);
                    $data_3['daily_limit'] = (int)$package_credit;
                    $data_3['is_valid'] = true;
                    $data_3['date'] = new MongoDate(strtotime(date('Y-m-d 00:00:00')));
                    $data_3['datetime'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
                    $data_3['paypal_profile_id'] = $recuring_ec_return['PROFILEID'];
                    $data_3['paypal_profile_status'] = $recuring_ec_return['PROFILESTATUS'];
                    $data_3['paypal_payer_id'] = $payer_id;
                    $data_3['correlation_id'] = $recuring_ec_return['CORRELATIONID'];

                    $end_datetime = date('Y-m-d 23:59:59');
                    $end_datetime = strtotime($end_datetime);
                    $end_datetime = strtotime("+29 day", $end_datetime);
                    $data_3['end_datetime'] = new MongoDate(strtotime(date('Y-m-d h:i:s', $end_datetime)));

                    //$data['response'] = (string)$charge;
                    $result = $this->Mdl_user->transaction_insert($data);
                    $this->session->set_flashdata(array('msg' => 'Thank you for buying package <span style="color:#703688;">' . $package_data['packname'] . '</span>.<br>Now Your daily limit is <span style="color:#703688;">' . $data_3['daily_limit'] . '</span> credit.', 'msg_type' => 'success'));
                
				    if ($result['ok'] == 1)
                    {
                        $super_admin_data = $this->Mdl_user->fetch_sa_data();
                        $invoice['user_id'] = new MongoId($this->session->email_lookup_user_id);
                        $invoice['name'] = $dash_profile['firstname'] . ' ' . $dash_profile['lastname'];
                        $invoice['address'] = $dash_profile['address'];
                        $invoice['contact'] = $dash_profile['contact'];
                        $invoice['description'] = 'Package ( ' . $package_data['packname'] . ' )';
                        $invoice['contact'] = $dash_profile['contact'];
                        $invoice['price'] = $data['price'];
                        $invoice['validity'] = '30 days';
                        $invoice['credit'] = $data_3['daily_limit'] . ' / per day';
                        $invoice['invoice_id'] = $this->Mdl_user->invoice_id_generate();
                        $invoice['invoice_from'] = $super_admin_data['company'];
                        $invoice['invoice_from_address'] = $super_admin_data['address'];
                        $invoice['datetime'] = new MongoDate(strtotime(date('y-m-d h:i:s')));

                        $this->Mdl_user->collection_insert($invoice, 'invoice');

                        $this->Mdl_user->prevent_other_packages();
                        $user_package_insert = $this->Mdl_user->collection_insert($data_3, 'user_package');
                        //print $this->session->flashdata('msg');
                        redirect('buy_package_confirm');
                    }
                    
			} else {
			    /*$this->_error($get_ec_return);
				$this->_error($do_ec_return);*/
                $this->session->set_flashdata(array('msg' => 'Sorry, your payment couldn\'t be completed', 'msg_type' => 'danger'));
                redirect("packages");
			}
		} else {
            //$this->_error($get_ec_return);
            $this->session->set_flashdata(array('msg' => 'Sorry, your payment couldn\'t be completed', 'msg_type' => 'danger'));
            redirect("packages");
		}
	}
    
    function _error($ecd) {
		echo "<br>error at Express Checkout<br>";
		echo "<pre>" . print_r($ecd, true) . "</pre>";
		echo "<br>CURL error message<br>";
		echo 'Message:' . $this->session->userdata('curl_error_msg') . '<br>';
		echo 'Number:' . $this->session->userdata('curl_error_no') . '<br>';
	}
}
