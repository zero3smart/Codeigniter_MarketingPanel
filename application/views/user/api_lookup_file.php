

<div class="row">
    <div class="col-xs-12">

    	
				<div class="note note-info">
                 <h4 class="block">Example</h4>
                       <p> This is a POST Method HTTP API. This API used for file uploading and file Proccessing. Copy this code and write a html file. Please Write  YOUR_API_KEY( <b style="color:#3d3d3d"><?php echo $dash_profile['api_key'];?></b> )  and Select YOUR_FILE from Browser. When you run this api you will get a Response. Like below <br><br>
                       You Can Change your API KEY from the bottom of <a href="<?php echo base_url();?>profile">this page</a>.
                	  </p>
                </div>
                 <p style="color:#009; font-size:18px">PHP CODE</p>
               
<pre >           
    //// ## THIS IS LOOKUP FILE API ##//////
    
    if(isset($_POST['submit']))
    {
    	$target = 'http://54.187.12.50:8080/EmailCleanupRESTAPI/file';
    
    	$tmpfile = $_FILES['file']['tmp_name'];
        $post = array(
        	'api_key' => <b style="color:#3d3d3d"><?php echo $dash_profile['api_key'];?></b>,
            	'file' => '@'.$tmpfile
           	);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$target);
    	curl_setopt($ch, CURLOPT_POST,1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
    	//// ## GET API RESPONSE ##//////
        
    	$result=curl_exec ($ch);
    	curl_close ($ch);
    }
    
  </pre>
  <p style="color:#009; font-size:18px">HTML CODE</p> 
  <pre>
    &ltform action="" method="post" enctype="multipart/form-data"&gt
      &ltinput type="file" name="file"&gt
      &ltinput type="submit" name="submit"&gt
    &ltform&gt
  </pre> 
  <p>&nbsp;</p> 

  
             
                
                <div class="note note-danger">
                 <h4 class="block">Response</h4>
                       <p style="padding-left:20px"> 
                       		{<br/>
                       			&nbsp;&nbsp;&nbsp;"message":"File has been scheduled",<br/>
                            	&nbsp;&nbsp;&nbsp;"file_id":"57863aba364eaxxxxxxxxxx",<br/>
                            	&nbsp;&nbsp;&nbsp;"success":true<br/>
                            }
                	  </p>
                </div>
                
                
                <h4 class="block">HTTP POST to FILE PROCCESSING </h4>
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
                           <td>FILE</td>
                          <td>This is a Required Field . Please Select a File From your Browser.</td>
                      </tr>
                      
                       <tr>
                          <td></td>
                          <td></td>
                      </tr>                
                   </tbody>
                 </table>

	</div>
</div>