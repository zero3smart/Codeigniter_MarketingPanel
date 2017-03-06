<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*app.snapiq.com/application/models/mdl_user*/

class Mdl_user extends CI_Model {
	function __construct() {
        parent::__construct();
		/*if(!$this->session->userdata('email_lookup_user_logged_in'))
		{
			redirect('login');
		}
		*/
        $this->load->library('mongolib');
        $this->db = $this->mongolib->db;
		$this->user_template = $this->db->user_template;
		$this->user_file = $this->db->user_file;
		$this->user = $this->db->users;
		$this->filter_keyword = $this->db->filter_keyword;
		$this->package = $this->db->package;
		$this->user_package = $this->db->user_package;
		$this->user_template = $this->db->user_template;
		$this->user_daily_limit = $this->db->user_daily_limit;
		$this->user_campaign = $this->db->user_campaign;
		$this->campaign_type = $this->db->campaign_type;
		$this->api_log = $this->db->api_log;
		$this->user_group = $this->db->user_group;
		$this->group_contact = $this->db->group_contact;
		$this->transaction = $this->db->transactions;
		$this->campaign_api_log = $this->db->campaign_api_log;
		$this->bulk_broadcast_candidate = $this->db->bulk_broadcast_candidate;
		$this->bulk_broadcast_candidate_failed = $this->db->bulk_broadcast_candidate_failed;
		$this->instant_lookup = $this->db->instant_lookup;
		$this->invoice = $this->db->invoice;
		
    }

    public function get_file_summery_all()
    {
    	$session_id = $this->session->email_lookup_user_id;

    	$i=0;
    	$result = array();
    	$result_2 = array();

    	$result['preclean_records'][0] = 0;
		$result['clean_records'][0] = 0;
		$result['smtp_cleaned'][0] = 0;
		$result['smtp_not_cleaned'][0] = 0;

		$result_2['preclean_records'] = 0;
		$result_2['clean_records'] = 0;
		$result_2['smtp_cleaned'] = 0;
		$result_2['smtp_not_cleaned'] = 0;

    	$query = $this->user_file->find(array('user'=>new MongoId($session_id),"status" => "processed"));
		foreach ($query as $value) {
			if(isset($value['summary']))
			{
				$data_of_summary = array();
				foreach ($value['summary'] as $summary_key => $summary_value) {
                    $chart_index = $summary_value['name'];
                    $chart_index = strtolower($chart_index);
                    $chart_index = str_replace(" ","_",$chart_index);
                    $data_of_summary[$chart_index]['name'] = $summary_value['name'];
                    $data_of_summary[$chart_index]['value'] = $summary_value['value'];
                }
				$result['preclean_records'][$i] = $data_of_summary['total_preclean_records']['value'];
				$result['clean_records'][$i] = $data_of_summary['total_clean_emails']['value'];
				if(isset($value['total_email_exists']))
				$result['smtp_cleaned'][$i] = $value['total_email_exists'];
				else
				$result['smtp_cleaned'][$i] = 0;

				$result['smtp_not_cleaned'][$i] = $result['clean_records'][$i] - $result['smtp_cleaned'][$i];


				$i++;
			}
		}

		if(count($result) > 0)
		{
			$result_2['preclean_records'] = array_sum($result['preclean_records']);
			$result_2['clean_records'] = array_sum($result['clean_records']);
			$result_2['smtp_cleaned'] = array_sum($result['smtp_cleaned']);
			$result_2['smtp_not_cleaned'] = array_sum($result['smtp_not_cleaned']);
		}
		
		return $result_2;

    }

    public function get_file_total_contacts_details_for_chart($day)
    {
    	

    	$invoice_net_total_this_day = array();

    	for($i=$day-1;$i>=0;$i--)
    	{
    		$total_contacts = array();
    		$total_succesful = array();
    		$total_smtp_clean = array();
    		$total_failed = array();

    		$total_contacts_amount = 0;
    		$total_succesful_amount = 0;
    		$total_smtp_clean_amount = 0;
    		$total_failed_amount = 0;

    		$query = array();

	    	$date = date('Y-m-d', strtotime('today - '.$i.' days'));

			$invoice_net_total_this_day['dates'][$i] = "'$date'";

	    	$date_1 = date('Y-m-d 00:00:00', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	$date_2 = date('Y-m-d 23:59:59', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	//echo '<br>';
	    	
	    	$date_1_iso = new MongoDate(strtotime($date_1));
	    	$date_2_iso = new MongoDate(strtotime($date_2));
	    	$date_tok = explode('-',$date);
	    	$date_tok[1] = $date_tok[1]-1;
	    	//echo $date;
	    	$session_id = $this->session->email_lookup_user_id;
	    	$query = $this->user_file->find(array('user'=>new MongoId($session_id),"process_end_time" => array('$gte' => $date_1_iso, '$lte' => $date_2_iso)));
			$j=0;
			foreach ($query as $value) {
				//print_r($value);
				if(isset($value['summary']))
				{
					//print_r($value);
					$data_of_summary = array();
					foreach ($value['summary'] as $summary_key => $summary_value) {
	                    $chart_index = $summary_value['name'];
	                    $chart_index = strtolower($chart_index);
	                    $chart_index = str_replace(" ","_",$chart_index);
	                    $data_of_summary[$chart_index]['name'] = $summary_value['name'];
	                    $data_of_summary[$chart_index]['value'] = $summary_value['value'];
	                }
	                
					$total_contacts[$j] = $data_of_summary['total_preclean_records']['value'];
					$total_succesful[$j] = $data_of_summary['total_clean_emails']['value'];
					
					if(isset($value['total_email_exists']))
					$total_smtp_clean[$j] = $value['total_email_exists'];
					else
					$total_smtp_clean[$j] = 0;

					//print_r($total_smtp_clean);
					//$total_failed[$j] = $total_succesful[$j] - $total_smtp_clean[$j];

					$j++;
				}
			}
			if(count($total_contacts) > 0) $total_contacts_amount = array_sum($total_contacts);
			if(count($total_succesful) > 0) $total_succesful_amount = array_sum($total_succesful);
			if(count($total_smtp_clean) > 0) $total_smtp_clean_amount = array_sum($total_smtp_clean);
			if(count($total_failed) > 0) $total_failed_amount = array_sum($total_failed);

			$invoice_net_total_this_day['total_contacts'][$i] = $total_contacts_amount;
			$invoice_net_total_this_day['total_succesful'][$i] = $total_succesful_amount;
			$invoice_net_total_this_day['total_smtp_clean'][$i] = $total_smtp_clean_amount;
			$invoice_net_total_this_day['total_failed'][$i] = $total_failed_amount;
			unset($query);

	    	
    	}
    	return $invoice_net_total_this_day;
    	
    }
	
    public function get_invoice_bill_total_for_chart($day)
    {
    	$invoice_net_total_this_day = array();

    	for($i=$day-1;$i>=0;$i--)
    	{
    		$total = array();
    		$query = array();
    		$total_amount = 0;
	    	$date = date('Y-m-d', strtotime('today - '.$i.' days'));
	    	$date_1 = date('Y-m-d 00:00:00', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	$date_2 = date('Y-m-d 23:59:59', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	//echo '<br>';
	    	
	    	$date_1_iso = new MongoDate(strtotime($date_1));
	    	$date_2_iso = new MongoDate(strtotime($date_2));
	    	$date_tok = explode('-',$date);
	    	$date_tok[1] = $date_tok[1]-1;
	    	//echo $date;
	    	$session_id = $this->session->email_lookup_user_id;
	    	$query = $this->transaction->find(array('user'=>new MongoId($session_id),"is_debit"=>true,"time" => array('$gte' => $date_1_iso, '$lte' => $date_2_iso)));
			foreach ($query as $value) {
				$total[] = $value['credit'];
			}
			if(count($total) > 0)
				$total_amount = array_sum($total);

			$invoice_net_total_this_day[$i] = '[Date.UTC('.$date_tok[0].', '.$date_tok[1].', '.$date_tok[2].'), '.$total_amount.']';
	    	unset($query);

	    	
    	}
    	return $invoice_net_total_this_day;
    }
	
    public function get_expense_bill_total_for_chart($day)
    {
    	$invoice_net_total_this_day = array();

    	for($i=$day-1;$i>=0;$i--)
    	{
    		$total = array();
    		$query = array();
    		$total_amount = 0;
	    	$date = date('Y-m-d', strtotime('today - '.$i.' days'));
	    	$date_1 = date('Y-m-d 00:00:00', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	$date_2 = date('Y-m-d 23:59:59', strtotime('today - '.$i.' days'));
	    	//echo '<br>';
	    	//echo '<br>';
	    	
	    	$date_1_iso = new MongoDate(strtotime($date_1));
	    	$date_2_iso = new MongoDate(strtotime($date_2));
	    	$date_tok = explode('-',$date);
	    	$date_tok[1] = $date_tok[1]-1;
	    	//echo $date;
	    	$session_id = $this->session->email_lookup_user_id;
	    	$query = $this->transaction->find(array('user'=>new MongoId($session_id),"is_debit"=>false,"time" => array('$gte' => $date_1_iso, '$lte' => $date_2_iso)));
			foreach ($query as $value) {
				$total[] = $value['credit'];
			}
			if(count($total) > 0)
				$total_amount = array_sum($total);

			$invoice_net_total_this_day[$i] = '[Date.UTC('.$date_tok[0].', '.$date_tok[1].', '.$date_tok[2].'), '.$total_amount.']';
	    	unset($query);

	    	
    	}
    	return $invoice_net_total_this_day;
    }
	
	public function messageTemplateAdd($data)
	{
		$result = $this->user_template->insert($data);
		
		
	}
	
	public function messageTemplateShow ($userid)
	{
		$data = array(
			'user_id' => $userid
			);
			
		$result = $this->user_template->find($data);
		return $result;
	}
	
	public function messageTemplateGetForEdit ($id)
	{
		$data = array(
			'id' => $id
			);
		$result = $this->user_template->find($data);
		if($result){
			return $result;
		}else{
			return false;
		}
		
	}
	
	public function filter_keyword ()
	{
		$result = $this->filter_keyword->find();
		if($result){
			return $result;
		}else{
			return "";
		}
		
	}
	
	
	
	public function chkExistingMessageTemplate ($title)
	{
		$data = array(
			'title' => $title
			);
		$result = $this->user_template->findOne($data);
		if($result){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function messgaeTemplateEdit($_id,$data)
	{
		
		 try{
		 	return $this->user_template->update(array('_id' => new MongoId($_id)), array('$set'=>$data), array("multiple" => false));
		 }
		 catch (MongoCursorException $e){
	
		  	echo "error message: ".$e->getMessage()."\n";
		  	echo "error code: ".$e->getCode()."\n";
		 }
	}
	
	public function messgaeTemplateDelete($_id)
	{
		
		 try{
		 	return $this->user_template->remove(array('_id' => new MongoId($_id)));
		 }
		 catch (MongoCursorException $e){
	
		  	echo "error message: ".$e->getMessage()."\n";
		  	echo "error code: ".$e->getCode()."\n";
		 }
	}
	
	public function messgaeTemplateBulkDelete($title)
	{
		
		 try{
		 	 $this->user_template->remove(array('title' => $title));
			 return 1;
		 }
		 catch (MongoCursorException $e){
	
		  	echo "error message: ".$e->getMessage()."\n";
		  	echo "error code: ".$e->getCode()."\n";
		 }
	}
	
	
	
	
	public function contact_upload_file_mdl($data)
	{
		return $this->user_file->insert($data);
	}

	public function user_package_insert($data)
	{
		return $this->user_package->insert($data);
	}

	public function fetch_user_profile()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user->findOne(array('_id'=>new MongoId($user_id)));
		return $result;
	}

    public function get_user_by_token($token)
    {
        $result = $this->user->findOne(array('activation_token'=> $token));
        return $result;
    }

	public function update_user($data){
		$user_id = $this->session->email_lookup_user_id;
		$this->user->update(array('_id' => new MongoId($user_id)), array('$set'=> $data), array("multiple" => false));
	}
	
	public function fetch_campaign_exists($campaign_name)
	{
		$user_id = $this->session->email_lookup_user_id;
		$campaign_name = '/^'.$campaign_name.'/i';
		$result = array();
		$result = $this->user_campaign->findOne(array('user'=>new MongoId($user_id),'name' => new MongoRegex($campaign_name)));
		return $result;
	}
	
	public function set_new_balance($balance)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user->findOne(array('_id'=>new MongoId($user_id)));
		$new_balance = $result['balance'] + $balance;
		$this->user->update(array('_id' => new MongoId($user_id)), array('$set'=> array('balance' => (int)$new_balance)), array("multiple" => false));
	}
	
	public function fetch_package_single($id)
	{
		$result = $this->package->findOne(array('_id'=>new MongoId($id)));
		return $result;
	}
	
	public function fetch_user_file_id($clean_id)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user_file->findOne(array('user'=>new MongoId($user_id),'clean_id'=>new MongoId($clean_id)));
		return $result;
	}
	
	public function fetch_user_file_by_id($file_id)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user_file->findOne(array('user'=>new MongoId($user_id),'_id'=>new MongoId($file_id)));
		return $result;
	}

	public function fetch_package_by_id($id)
	{
		$result = array();
		$result = $this->package->findOne(array('_id'=>new MongoId($id)));
		return $result;

	}
	
	public function custom_edit_single_field_mdl($collection,$_id,$data)
	{
		try{

			return $this->db->$collection->update(array('_id'=> new MongoId($_id)),array('$set'=>$data));
		}
		catch (MongoCursorException $e){
		}
	}
	
	public function prevent_other_packages()
	{
		try{
			$user_id = $this->session->email_lookup_user_id;
			return $this->db->user_package->update(array('user_id'=> new MongoId($user_id)),array('$set'=>array('is_valid'=>false)), array("multiple" => true));
		}
		catch (MongoCursorException $e){
		}
	}
	
	public function collection_insert($data,$collection)
	{
		try{
			//$this->db->$collection->update(array('_id' => new MongoId($user_id)), array('$set'=> array('password' => $new_pass)), array("multiple" => false));
	
			
			 $this->db->$collection->insert($data);
			 return $data['_id'];
		}
		catch (MongoCursorException $e){
		}
	}

	public function fetch_package()
	{

		$result = $this->package->find();
		return $result;
	}
	
	public function fetch_groups($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_group->find(array('user'=>new MongoId($user_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
	}

	
	public function fetch_groups_search($limit,$start,$keyword)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		//find({$text:{$search:"tutorialspoint"}})
		$keyword = '/'.$keyword.'/i';
		$result = $this->user_group->find(array('user'=>new MongoId($user_id),'name'=> new MongoRegex($keyword)))->limit($limit)->skip($start);
		
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
		//print_r($result_2);
		//die();
	}
	public function fetch_groups_search_count($keyword)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		//find({$text:{$search:"tutorialspoint"}})
		$keyword = '/'.$keyword.'/i';
		return $this->user_group->find(array('user'=>new MongoId($user_id),'name'=> new MongoRegex($keyword)))->count();
		
		//print_r($result_2);
		//die();
	}
	public function count_all_rows_user_template_search($keyword)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		//find({$text:{$search:"tutorialspoint"}})
		$keyword = '/'.$keyword.'/i';
		return $this->user_template->find(array('user'=>new MongoId($user_id),'title'=> new MongoRegex($keyword)))->count();
		
		//print_r($result_2);
		//die();
	}
		
	public function fetch_user_file($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_file->find(array('user'=>new MongoId($user_id), 'status' => 'processed', "isphonenumberfile"=> array('$exists' => false)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}

		return $result_2;
	}


	/**********************************************************/
	/* BEGIN : This function return user's Phone Number files */
	/**********************************************************/
	public function fetch_user_phonenumber_file($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_file->find(array('user'=>new MongoId($user_id), 'status' => 'processed', 'isphonenumberfile'=>'1'))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}

		return $result_2;
	}
	//user's file by file id
	public function fetch_user_file_by_fileid($fid)
	{
		$result_2 = array();
		$result = $this->user_file->findOne(array('_id'=>new MongoId($fid)));
		$i=0;
		if(count($result)>0)
		{
			foreach ($result as $result_key => $result_value) {
				$result_2[$i][$result_key] = $result_value;
				$i++;
			}
		}
		return $result_2;
	}


    public function set_status_complete($id, $status, $totalPreCleanRecords, $totalRecordsAfterClean, $totalInvalid)
    {
    	 try{

            $result = (object)null;
            $result->status = $status;
            $result->messsage = "File processed successful";
            $result->totalPreCleanRecords = "File processed successful";
            if(isset($response)) {
              //  $result->result = $response;

            }
            
            $result->result["data"]['summary']['endTime'] = new MongoDate($this->microseconds()/1000000);
            $result->result["data"]['summary']['totalPreCleanRecords'] = $totalPreCleanRecords;
            $result->result["data"]['summary']['totalRecordsAfterClean'] = $totalRecordsAfterClean;
            $result->result["data"]['summary']['totalInvalid'] = $totalInvalid;
                // return $this->db->user_file->update(array('_id'=> new MongoId($id)),array('$set'=> array('status' => $status)));
            // print_r($result->result["data"]['summary']['endTime']);
            // print_r(microtime());
            print_r($this->microseconds());
            return $this->db->user_file->update(array('_id'=> new MongoId($id)),array('$set'=>$result));
                }
        catch (MongoCursorException $e){
        }
    }


	/***********************************************************/
	/* // END : This function return user's Phone Number files */
	/***********************************************************/




	public function set_status_on_completion($id, $status, $response)
    {

        /*$foo = (object)null; //create an empty object
        $foo->bar = "12345";
        $foo->test="good";
        $foo = json_encode($foo);
        echo($foo); //12345*/
        try{

            $result = (object)null;
            $result->status = $status;
            $result->messsage = "File processed successful";
            if(isset($response)) {
                $result->result = $response;

            }
            $result->result["data"]['summary']['endTime'] = new MongoDate($response["data"]['summary']['endTime']/1000);
            return $this->db->user_file->update(array('_id'=> new MongoId($id)),array('$set'=>$result));
        }
        catch (MongoCursorException $e){
        }
    }



    function microseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
	}

    public function set_status_on_failure($id, $message)
    {
        try{

            $result = (object)null;
            $result->status = 'failed';
            $result->messsage = $message;

            return $this->db->user_file->update(array('_id'=> new MongoId($id)),array('$set'=>$result));
        }
        catch (MongoCursorException $e){
        }
    }
			
	public function fetch_user_file_by_status($status)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result_3 = array();
		$result = $this->user_file->find(array('user'=>new MongoId($user_id), 'status' => $status))->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		$i=0;
		foreach ($result_2 as $file_status_key => $file_status_value) 
        {
            foreach ($file_status_value as $file_status_value_key => $file_status_value_value) 
            {

                $date_2 = "";
                $date_2_array = array();
                if($file_status_value_value['upload_time'] != "")
                {
                    $date_2_array = explode(" ",$file_status_value_value['upload_time']);
                    $date_2 = date('F j, Y, g:i a',$date_2_array[1]);
                }
            	$result_3[$i]['_id'] = "".$file_status_value_value['_id']."";
            	$result_3[$i]['upload_time'] = $date_2;
            	$result_3[$i]['file_name'] = $file_status_value_value['file_name'];
                $result_3[$i]['status'] = $file_status_value_value['status'];
            	$result_3[$i]['progress'] = $file_status_value_value['progress'];
            	$result_3[$i]['clean_id'] = isset($file_status_value_value['clean_id']) ? $file_status_value_value['clean_id']->{'$id'} : null;
            }
            $i++;

         }
		return $result_3;
	}
		
	public function fetch_user_campaign($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_campaign->find(array('user'=>new MongoId($user_id), 'status' => 'processed'))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
	}
		
	public function fetch_user_daily_limit()
	{
	 	$date_1 = date("Y-m-d 23:59:59");
	 	$date_2 = date("Y-m-d 00:00:00");
		$date_1_iso = new MongoDate(strtotime($date_1));
		$date_2_iso = new MongoDate(strtotime($date_2));
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();

		$current_package = $this->fetch_current_package();

		if($current_package)
		{
			$result = $this->user_daily_limit->find(array('user'=>new MongoId($user_id),'user_package_id'=> new MongoId($current_package['_id']), 'datetime' => array('$gte' => $date_2_iso, '$lte' => $date_1_iso)));
			if(count($result)>0)
			{
				$i=0;
				foreach ($result as $result_key => $result_value) {
					$result_2[$i] = $result_value['total'];
					$i++;
				}

				return array_sum($result_2);
			}
			else
			{
				return 0;
			}
		}
		else
			return -1;
	}

	public function fetch_current_package()
	{
		$result = array();
		$result_2 = array();
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user_package->findOne(array('user_id'=>new MongoId($user_id),'is_valid' => true));
		
		if(count($result)>0)
		{
			$now_date = new MongoDate(strtotime(date('Y-m-d H:i:s')));
			$result_2 = $this->user_package->findOne(array('_id'=>new MongoId($result['_id']),'end_datetime'=>array('$gte' => $now_date)));
			
			if(count($result_2)>0)
			{
				return $result;
			}
			else
			{
				$this->user_package->update(array('_id' => new MongoId($result['_id'])), array('$set'=> array('is_valid' => false)), array("multiple" => false));
				return false;
			}
		}
		else
			return false;
		//return $result;
	}	
	public function set_user_daily_limit($total)
	{
	 	$date = date("Y-m-d 00:00:00");
		$date_iso = new MongoDate(strtotime($date));

		$date_time = date("Y-m-d H:i:s");
		$date_time_iso = new MongoDate(strtotime($date_time));
		
		$current_package = $this->fetch_current_package();
		if($current_package)
		{
			$user_id = $this->session->email_lookup_user_id;
			$data = array(
				'user' => $user_id,
				'user_package_id' => $current_package['_id'],
				'total' => (int)$total,
				'date' => $date_iso,
				'datetime' => $date_time_iso
				);
			$this->user_daily_limit->insert($data);
		}
		
		
	}
		
	
		
	public function fetch_user_file_by_name($name)
	{
		$name = trim($name);
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_file->findOne(array('user'=>new MongoId($user_id),'file_name'=>$name));
		$i=0;
		if(count($result)>0)
		{
			foreach ($result as $result_key => $result_value) {
				$result_2[$i][$result_key] = $result_value;
				$i++;
			}
		}
		return $result_2;
	}
		

	public function fetch_user_template($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result = $this->user_template->find(array('user_id'=>new MongoId($user_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
	}
	
	public function fetch_user_template_search($limit,$start,$keyword)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$keyword = '/'.$keyword.'/i';
		$result = $this->user_template->find(array('user_id'=>new MongoId($user_id),'title'=> new MongoRegex($keyword)))->limit($limit)->skip($start);
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
	}
	
	public function count_all_rows_user_template()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_template->find(array('user_id'=>new MongoId($user_id)))->count();
		
	}
	
	public function fetch_group_name($group_id)
	{
		$username = $this->session->email_lookup_user_username;
		$result_2 = array();
		$result = $this->user_group->findOne(array('_id'=>new MongoId($group_id)));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2[2]['name'];
	}

	public function fetch_template_name($template_id)
	{
		$username = $this->session->email_lookup_user_username;
		$result = array();
		$result_2 = array();
		$result = $this->user_template->findOne(array('_id'=>new MongoId($template_id)));
		$i=0;
		if(count($result)>0)
		{
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		//print_r($result_2);
		//die();
		return $result_2[1]['title'];
		}
		else
		return "Not Found";
	}

	public function fetch_group_details($group_id,$limit,$start)
	{
		$username = $this->session->email_lookup_user_username;
		$result_2 = array();
		$result = $this->group_contact->find(array('group'=>new MongoId($group_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i][$result_key] = $result_value;
			$i++;
		}
		return $result_2;
	}

	public function count_all_rows_user_group()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_group->find(array('user'=>new MongoId($user_id)))->count();
	}

	public function count_all_rows_user_campaign()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_campaign->find(array('user'=>new MongoId($user_id)))->count();
	}

	public function count_all_rows_group_contact($group_id)
	{
		return $this->group_contact->find(array('group'=>new MongoId($group_id)))->count();
	}
	
	public function count_all_rows_user_file()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_file->find(array('user'=>new MongoId($user_id),"status"=>'processed'))->count();
	}
	
	public function count_processing_user_file()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_file->find(array('user'=>new MongoId($user_id),"status"=>'processing'))->count();
	}
	


	public function group_delete($group_id){
		$user_id = $this->session->email_lookup_user_id;
		 $delete_group = $this->user_group->remove(array('_id' =>new MongoId($group_id),'user'=>new MongoId($user_id)));
		 if($delete_group['ok'] == 1) 
		 	$delete_contact = $this->group_contact->remove(array('group' =>new MongoId($group_id)));
		 if($delete_contact['ok'] == 1) return true;
	}
	public function packages_data_insert_fail($data)
	{
		
	}

	public function fetch_group_contact_count($group_id_value)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->user_group->find(array('_id'=>new MongoId($group_id_value),'user'=>new MongoId($user_id)));
		
		$i=0;
		foreach ($result as $result_key => $result_value) {
			$result_2[$i] = $result_value['total_contacts'];
			$i++;
		}
		return $result_2[0];
	}
	public function check_password($pass)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result = $this->user->findOne(array('_id'=>new MongoId($user_id),'password'=>$pass));
		
		if(count($result)>0)
			return true;
		else
			return false;
	}

	public function insert_user_campaign($data)
	{
		$this->user_campaign->insert($data);
		return $data['_id'];
	}

	public function fetch_campaign_type(){
		return $result = $this->campaign_type->find();
	}

	public function set_password($new_pass){
		$user_id = $this->session->email_lookup_user_id;
		$this->user->update(array('_id' => new MongoId($user_id)), array('$set'=> array('password' => $new_pass)), array("multiple" => false));
	}

	public function total_contact_count()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$sum=0;
		$result = $this->user_group->find(array('user'=>new MongoId($user_id)));
		foreach ($result as  $result_value) {
			$sum = $result_value['total_contacts'] + $sum;
		}
		return $sum;
	}
	public function total_group_count()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->user_group->find(array('user'=>new MongoId($user_id)))->count();
	}
	public function campaign_success_count_by_day($parm1)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$sum=0;
		$date_2 = new DateTime(date('Y-m-d H:i:s'));
		$date_2->sub(new DateInterval($parm1));
		$date_1_str = date('Y-m-d H:i:s');
		$date_2_str = $date_2->format('Y-m-d 00:00:00');
		
		$date_1_iso = new MongoDate(strtotime($date_1_str));
		$date_2_iso = new MongoDate(strtotime($date_2_str));

		$result =  $this->user_campaign->find(array('user'=>new MongoId($user_id),"status"=>'processed',"created_at" => array('$gt' => $date_2_iso, '$lte' => $date_1_iso)));
		//$collection->find(array("ts" => array('$gt' => $start, '$lte' => $end)));
		foreach ($result as  $result_value) {
			$sum = $result_value['total_successful'] + $sum;
		}
		return $sum;
	}

	public function contact_upload_file_api_response_mdl($request,$response,$fileID)
	{
		$fileID = new MongoId($fileID);
		$date_time = date("Y-m-d H:i:s");
		$date_time_iso = new MongoDate(strtotime($date_time));
		$data = array(
			'file_id'=>$fileID,
			'request'=>$request,
			'response'=>$response,
			'created_at'=>$date_time_iso,
			);
		 $this->api_log->insert($data);
	}
	public function deploy_campaign_api_response_mdl($request,$response,$campaign_id,$campaign_name)
	{
		$campaign_id = new MongoId($campaign_id);
		$date_time = date("Y-m-d H:i:s");
		$date_time_iso = new MongoDate(strtotime($date_time));
		$data = array(
			'campaign_id'=>$campaign_id,
			'campaign_name'=>$campaign_name,
			'request'=>$request,
			'response'=>$response,
			'created_at'=>$date_time_iso,
			);
		 $this->campaign_api_log->insert($data);
	}

	public function get_api_log_single($id)
	{
		$result = array();
		$result = $this->api_log->findOne(array('file_id'=>new MongoId($id)));
		return $result;

	}


	public function fetch_price_per_credit($userID){
		$result = $this->user->findOne(array('_id'=>new MongoId($userID)));
		return $result;
	}

	public function transaction_insert($data){
		$result = $this->transaction->insert($data);
		return $result;
	}

	public function get_campaign_detail_by_id($id,$limit,$start)
	{
		//$id = new MongoId($id);
		$i=0;
		$result_2 = array();
		$result = $this->bulk_broadcast_candidate->find(array('campaign'=>new MongoId($id)))->limit($limit)->skip($start)->sort(array('_id' => 1));
		foreach ($result as $result_key => $result_value) {

			$result_2[$i]['status_message'] =  $result_value['status_message'];
			$result_2[$i]['time'] =  $result_value['time'];
			$result_2[$i]['status'] =  $result_value['status_code'];
			$result_2[$i]['total'] =  $result_value['total'];
			$result_2[$i]['refund'] =  '';
			if($result_value['status_code'] != 200)
			{
				$result_3 = $this->bulk_broadcast_candidate_failed->findOne(array('bulk_broadcast_candidate'=>$result_value['_id']));
					if($result_3)
					{
						
						$result_2[$i]['refund'] =  $result_3['status'];
					}
			}
			$i++;
		}
		return $result_2;

	}

	public function count_all_rows_this_campaign_details($id)
	{
		return $this->bulk_broadcast_candidate->find(array('campaign'=>new MongoId($id)))->count();
		
	}
	public function count_all_rows_instant_lookup()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->instant_lookup->find(array('user'=>new MongoId($user_id)))->count();
		
	}
	
	public function count_all_rows_expense()
	{
		$user_id = $this->session->email_lookup_user_id;
		return $this->transaction->find(array('user'=>new MongoId($user_id)))->count();
		
	}

	public function count_all_rows_expense_by_date ($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		 //$this->transaction->find(array('user_id'=>new MongoId($user_id)))->count();
		 return $this->transaction->find(array('user'=>new MongoId($user_id),"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		
	}

	public function get_all_transaction($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result =  $this->transaction->find(array('user'=>new MongoId($user_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}
	
	public function get_all_instant_lookup($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result =  $this->instant_lookup->find(array('user'=>new MongoId($user_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}
	
	public function instant_lookup_by_id($id)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result =  $this->instant_lookup->findOne(array('_id'=>new MongoId($id),'user'=>new MongoId($user_id)));
		
		return $result;
	}





	/*****************************************************************************/
	/* BEGIN : This function get User's number file transactions and returns csv */
	/*****************************************************************************/
	public function numberfile_lookup_by_id($id)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result =  $this->api_log->findOne(array('file_id'=>new MongoId($id)));

		$columns = "";
		$all_values = "";
		$i=0;
		foreach($result["response"] as $single_trans) {
			$single_values = "";
			foreach($single_trans["transaction"] as $key => $val) {
				// echo $key ." = "."\"" .addslashes($val) ."\" ";
				if($key=="validNumber") {
					$val = ($val==1) ? "true" : "false";
				}
				if($i==0) {
					// set columns 
					$columns = (strlen($columns)==0) ? "\"".addslashes($key) ."\"" : ($columns ."," ."\"" .addslashes($key) ."\"");
				}
				$single_values = (strlen($single_values)==0) ? "\"" .addslashes($val) ."\"" : ($single_values ."," ."\"" .addslashes($val) ."\"");
			}
			// echo "<br><br>";
			// if($i==0) echo $columns ."<br><br>";
			// echo $single_values ."<br><br>";
			$i++;
			$all_values = (strlen($all_values)==0) ? $single_values : ($all_values ."\n" .$single_values);
		}
		$final_result = $columns ."\n" .$all_values;
		// echo $final_result;
		// die();

		return array("_id" => $result["_id"],  "final_result" => $final_result);
	}
	/******************************************************************************/
	/* // END : This function get User's number file transactions and returns csv */
	/******************************************************************************/
	



	public function get_all_transaction_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}

	public function get_all_transaction_price_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result =  $this->transaction->find(array('user'=>new MongoId($user_id)));
		foreach ($result as $result_key => $result_value) {
			if($result_value['price'])
			$result_2[] = $result_value['price'];
		}
		return array_sum($result_2);
	}
	public function get_all_transaction_price_sum_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['price'];
		}
		return array_sum($result_2);
	}
	public function get_all_transaction_credit_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$result =  $this->transaction->find(array('user'=>new MongoId($user_id)));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}
	public function get_all_transaction_credit_sum_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function fetch_campaign_by_id($id){
		$result = $this->user_campaign->findOne(array('_id'=>new MongoId($id)));
		return $result;
	}

	public function insert_any_collection($collection,$data)
	{
		$this->db->$collection->insert($data);
	}

	public function fetch_transaction_by_date_to_date($from,$to,$limit,$start)
	{

		//$result =  $this->user_campaign->find(array('user'=>new MongoId($user_id),"status"=>'processed',"created_at" => array('$gt' => $date_2_iso, '$lte' => $date_1_iso)));
		
	}




	



	/// report expense
	/// report expense
	/// report expense

	public function count_all_transaction_credit_expense()
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->count();
		
		return $result;
	}
	
	public function get_all_transaction_credit_expense_credit_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_credit_expense($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}


	// report expense by date
	// report expense by date
	// report expense by date


	public function count_all_transaction_credit_expense_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		$result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		return $result;
	}

	
	public function get_all_transaction_credit_expense_by_date_credit_sum($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}
	public function get_all_transaction_credit_expense_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				array('notes'=>"Credit reduced for File Cleanup"),  //false
				array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}










	/// report buy
	/// report buy
	/// report buy

	public function count_all_transaction_credit_buy()
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->count();
		
		return $result;
	}
	
	public function get_all_transaction_credit_buy_credit_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_credit_buy($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}


	// report buy by date
	// report buy by date
	// report buy by date


	public function count_all_transaction_credit_buy_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		$result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		return $result;
	}

	
	public function get_all_transaction_credit_buy_by_date_credit_sum($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}
	public function get_all_transaction_credit_buy_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}






	/// start package report
	/// start package report
	/// start package report

	public function count_all_transaction_daily_limit_expense()
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->count();
		
		return $result;
	}
	
	public function get_all_transaction_daily_limit_expense_credit_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_daily_limit_expense($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}

	public function count_all_transaction_daily_limit_expense_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		$result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		return $result;
	}

	
	public function get_all_transaction_daily_limit_expense_by_date_credit_sum($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_daily_limit_expense_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}









	public function count_all_transaction_package_buy()
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->count();
		
		return $result;
	}
	
	public function get_all_transaction_package_buy_credit_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_package_buy($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$result =  $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or))->limit($limit)->skip($start)->sort(array('_id' => -1));
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}

	public function count_all_transaction_package_buy_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		$result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		return $result;
	}

	
	public function get_all_transaction_package_buy_by_date_credit_sum($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				//array('notes'=>"Stripe"),  // true
				array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['credit'];
		}
		return array_sum($result_2);
	}

	public function get_all_transaction_package_buy_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$or = array( 
				//array('notes' =>"Daily limit reduced for Instant Lookup"),  //false
				//array('notes' =>"Daily limit reduced for File Cleane Up"),  //false
				array('notes'=>"Stripe"),  // true
				//array('notes'=>"Stripe Credit Buy"), //true
				//array('notes'=>"Credit Refund"),  // false
				//array('notes'=>"Credit reduced for File Cleanup"),  //false
				//array('notes'=>"Credit reduced for Instant Lookup")  //false
			);

		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		
		  $result = $this->transaction->find(array('user'=>new MongoId($user_id),'$or' => $or,"time" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}
		return $result_2;
	}

	// end package report
	// end package report
	// end package report





	public function fetch_sa_data()
	{
		$result = $this->db->super_admin->findOne(array('admin'=> 1));
		return $result;
	}

	public function invoice_id_generate()
	{
		$from = date('y-m-d 00:00:00');
		$to = date('y-m-d 23:59:59');
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));

		$result = $this->invoice->find(array("datetime" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		$result = $result+10001;
		$date = date('dmy');
		$result = $result.$date;
		return $result;
	}

	public function count_all_invoice()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = $this->invoice->find(array('user_id'=>new MongoId($user_id)))->count();
		
		return $result;
	}
	public function count_all_invoice_by_date($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));

		$result = $this->invoice->find(array('user_id'=>new MongoId($user_id),"datetime" => array('$gte' => $from_iso, '$lte' => $to_iso)))->count();
		
		return $result;
	}

	public function get_invoice_by_id($id)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		
		$result = $this->invoice->findOne(array('_id'=>new MongoId($id),'user_id'=>new MongoId($user_id)));
		
		return $result;
	}

	public function get_all_invoice($limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		
		$result = $this->invoice->find(array('user_id'=>new MongoId($user_id)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}

		return $result_2;
	}

	public function get_all_invoice_price_sum()
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		
		
		  $result = $this->invoice->find(array('user_id'=>new MongoId($user_id)))->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['price'];
		}
		return array_sum($result_2);
	}
	
	public function get_all_invoice_by_date($from,$to,$limit,$start)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));
		

		$result = $this->invoice->find(array('user_id'=>new MongoId($user_id),"datetime" => array('$gte' => $from_iso, '$lte' => $to_iso)))->limit($limit)->skip($start)->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value;
		}

		return $result_2;
	}

	public function get_all_invoice_by_date_price_sum($from,$to)
	{
		$user_id = $this->session->email_lookup_user_id;
		$result = array();
		$result_2 = array();
		
		$from_iso = new MongoDate(strtotime($from));
		$to_iso = new MongoDate(strtotime($to));

		  $result = $this->invoice->find(array('user_id'=>new MongoId($user_id),"datetime" => array('$gte' => $from_iso, '$lte' => $to_iso)))->sort(array('_id' => -1));
		
		foreach ($result as $result_key => $result_value) {
			$result_2[] = $result_value['price'];
		}
		return array_sum($result_2);
	}



	



	








}

?>