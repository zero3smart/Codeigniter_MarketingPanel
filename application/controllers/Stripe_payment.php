<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/autoload.php');

class Stripe_payment extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Mdl_user');

        $this->user_prifile = $this->Mdl_user->fetch_user_profile();
        //if($this->user_prifile['username'] == 'affan' )
        //redirect('buy_credit');
    }


    public function test_stripe()
    {
        $this->load->view("user/test_stripe");
    }

    public function checkout_buy_credit()
    {

        $invoice = array();
        $invoice['card'] = $this->input->post('card_number');

        $dash_profile = $this->Mdl_user->fetch_user_profile();

        $credit_count = $this->input->post('credit_count');
        $total_price = $this->input->post('total_price');
        $total_price = number_format((double)$total_price, 2, '.', '');
        $total_price_cent = $total_price * 100;
        \Stripe\Stripe::setApiKey("sk_test_uf7di1vW51TKwuBaceT54rwm"); //Replace with your Secret Key

        $charge = \Stripe\Charge::create(array(
            "amount" => (double)$total_price_cent,
            "currency" => "usd",
            "card" => $_POST['stripeToken'],
            "description" => "Number Lookup credit buy."
        ));
        //print_r($charge);
        //die();
        if ($charge->status == 'succeeded') {
            $data = array();
            $data['price'] = (double)$total_price;
            $data['credit'] = (int)$credit_count;
            $data['is_debit'] = true;
            $data['user'] = $this->session->email_lookup_user_id;
            $data['time'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
            $data['notes'] = 'Stripe Credit Buy';
            $result = $this->Mdl_user->transaction_insert($data);
            $this->session->set_flashdata(array('msg' => $credit_count, 'msg_type' => 'success'));

            if ($result['ok'] == 1) {
                $super_admin_data = $this->Mdl_user->fetch_sa_data();
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
        } else {
            $this->session->set_flashdata(array('msg' => 'Sorry, Please Try again!', 'msg_type' => 'danger'));
            redirect('buy_credit');
        }
    }

    public function checkout()
    {
        try {
            //echo APPPATH.'controllers/Stripe/lib/Stripe.php';
            //require_once('./lib/Stripe.php');//or you

            $invoice = array();
            $invoice['card'] = $this->input->post('card_number');
            $dash_profile = $this->Mdl_user->fetch_user_profile();


            $package_id = $this->input->post('package_id');
            $package_data = $this->Mdl_user->fetch_package_by_id($package_id);
            if (count($package_data) > 0) {
                $package_price = $package_data['price'];
                $package_price = number_format((double)$package_price, 2, '.', '');
                $total_price_cent = $package_price * 100;
                $package_credit = $package_data['credit'];


                //echo '<br>';$this->input->post('stripeToken');
                $userID = $this->session->email_lookup_user_id; //current user id
                //echo json_encode($product);
                //echo $price; die();
                //echo $_POST['stripeToken'];
                \Stripe\Stripe::setApiKey("sk_test_uf7di1vW51TKwuBaceT54rwm"); //Replace with your Secret Key

               /* $charge = \Stripe\Charge::create(array(
                    "amount" => (double)$total_price_cent,
                    "currency" => "usd",
                    "card" => $_POST['stripeToken'],
                    "description" => "Number Lookup credit buy."
                ));*/

                /*-------------------------------------------------*/

                \Stripe\Stripe::setApiKey("sk_test_uf7di1vW51TKwuBaceT54rwm");

                $customer = \Stripe\Customer::create(array(
                    "description" => "Customer for " . $dash_profile['email'],
                    "plan" => $package_id,
                    "card" => $_POST['stripeToken']
                ));

                /*-------------------------------------------------*/


                //print_r($charge);

                //echo $charge;
                //echo '</br></br></br></br>';
                //$charge_arr = json_decode($charge);
                //print_r($charge_arr);
                //die();
                //echo "<h1>Your payment has been completed.</h1>";
                /*$response = json_decode($charge);
                print $charge->id; print $charge->source->name; die();*/
                if ($customer) {
                    $data = array();
                    $data_2 = array();
                    $data_3 = array();
                    $data_4 = array();
                    $data['price'] = (double)$package_price;
                    $data['credit'] = (int)$package_credit;
                    $data['is_debit'] = true;
                    $data['user'] = $this->session->email_lookup_user_id;
                    $data['time'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
                    $data['notes'] = 'Stripe';

                    $data_2['user'] = $this->session->email_lookup_user_id;
                    $data_2['package'] = $package_id;
                    $data_2['purchase_time'] = new MongoDate(strtotime(date('Y-m-d 00:00:00')));

                    $data_3['user_id'] = $this->session->email_lookup_user_id;
                    $data_3['package_id'] = new MongoId($package_id);
                    $data_3['daily_limit'] = intval($package_data['credit']);
                    $data_3['is_valid'] = true;
                    $data_3['date'] = new MongoDate(strtotime(date('Y-m-d 00:00:00')));
                    $data_3['datetime'] = new MongoDate(strtotime(date('Y-m-d h:i:s')));
                    $data_3['stripe_customer_id'] = $customer["id"];

                    $end_datetime = date('Y-m-d 23:59:59');
                    $end_datetime = strtotime($end_datetime);
                    $end_datetime = strtotime("+29 day", $end_datetime);
                    $data_3['end_datetime'] = new MongoDate(strtotime(date('Y-m-d h:i:s', $end_datetime)));

                    //$data['response'] = (string)$charge;
                    $result = $this->Mdl_user->transaction_insert($data);
                    $this->session->set_flashdata(array('msg' => 'Thank you for buying package <span style="color:#703688;">' . $package_data['packname'] . '</span>.<br>Now Your daily limit is <span style="color:#703688;">' . $data_3['daily_limit'] . '</span> credit.', 'msg_type' => 'success'));

                    if ($result['ok'] == 1) {
                        /*
                        $balance = (int)$package_credit;
                        $this->Mdl_user->user_package_insert($data_2);
                        $bal_result = $this->Mdl_user->set_new_balance($balance);
                        */
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
                        //$this->Mdl_user->update_user($data_4,'users');
                    }
                } else {
                    $this->session->set_flashdata(array('msg' => 'Sorry, your payment couldn\'t be completed', 'msg_type' => 'danger'));
                    redirect('packages');
                }


            } else {
                $this->session->set_flashdata(array('msg' => 'Sorry, Package not found.', 'msg_type' => 'danger'));
                redirect("packages");
            }
        } catch (Stripe_CardError $e) {

        } catch (Stripe_InvalidRequestError $e) {

        } catch (Stripe_AuthenticationError $e) {
        } catch (Stripe_ApiConnectionError $e) {
        } catch (Stripe_Error $e) {
        } catch (Exception $e) {
        }
    }

}