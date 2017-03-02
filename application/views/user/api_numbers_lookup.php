

<div class="row">
    <div class="col-xs-12">

    	
				<div class="note note-info">
                 <h4 class="block">Example</h4>
                       <p> This is a POST Method HTTP API. This API used for Check Valid or Invalid number,carrier,country,city etc. Copy this code and write a html file. Please Write  YOUR_API_KEY( <b style="color:#3d3d3d"><?php echo $dash_profile['api_key'];?></b> )  and Write a Email. When you run this api you will get a Response. Like below
                       <br><br>
                       You Can Change your API KEY from the bottom of <a href="<?php echo base_url();?>profile">this page</a>. 
                	  </p>
                </div>
                 <p style="color:#009; font-size:18px">PHP CODE</p>
               
                <pre style="padding-left:30px">
               
//// ## THIS IS EMAIL LOOKUP  API ##//////

$target = 'http://54.187.12.50:8080/EmailCleanupRESTAPI/email';

$curl = curl_init($target);

$curl_post_data = array(


        'api_key' => '<b style="color:#3d3d3d"><?php echo $dash_profile['api_key'];?></b>',
        'email' => 'YOUR_EMAIL'

);
$fields_string = http_build_query($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_POST, true);

curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

$curl_response = curl_exec($curl);


curl_close($curl);

//// ## GET API RESPONSE ##//////

$decoded = json_decode($curl_response);

print_r($decoded);   
                </pre>
                
                <p>&nbsp;</p>
                <div class="note note-danger">
                 <h4 class="block">Response</h4>
                       <p style="padding-left:30px"> 
{<br/>
   &nbsp;&nbsp;&nbsp;"message": "Request processed successfully",<br/>
   &nbsp;&nbsp;&nbsp;"status": "Threat String",<br/>
   &nbsp;&nbsp;&nbsp;"success": true<br/>
}<br/>
                	  </p>
                </div>
                
                
                <h4 class="block">HTTP POST to EMAIL CHECK </h4>
                <table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" id="" cellspacing="0">
                  <thead>
                       <tr>
                          <th>PARAMETER</th>
                          <th>DESCRIPTION</th>
                      </tr>
                   </thead>
                   <tbody>
                       <tr>
                          <td>API KEY</td>
                          <td>This is a Required Field. Please enter your API KEY in the HTTP url. Your API KEY : <b style="color:#3d3d3d"><?php echo $dash_profile['api_key'];?></b></td>
                      </tr>
                      <tr>
                           <td>EMAIL</td>
                          <td>This is a Required Field. Please Write an Email</td>
                      </tr>
                      
                       <tr>
                          <td></td>
                          <td></td>
                      </tr>                
                   </tbody>
                 </table>

	</div>
</div>