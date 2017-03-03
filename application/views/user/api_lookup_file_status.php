<div class="row">
    <div class="col-xs-12">


        <div class="note note-info">
            <h4 class="block">Example</h4>

            <p> This is a GET Method HTTP API. If You get a file status then use this API. Copy this code and write a
                html file. Please Write YOUR_API_KEY( <b
                    style="color:#3d3d3d"><?php echo $dash_profile['api_key']; ?></b> ) and YOUR_FILE_ID in the target
                url. When you run this api you will get a Response. Like below
                <br><br>
                You Can Change your API KEY from the bottom of <a href="<?php echo base_url(); ?>profile">this page</a>.
            </p>
        </div>
        <p style="color:#009; font-size:18px">PHP CODE</p>
                <pre style="padding-left:30px">
               
//// ## THIS IS LOOKUP FILE STATUS API ##//////

$target = 'http://54.187.12.50:8080/EmailCleanupRESTAPI/file/status?api_key= <b
                        style="color:#3d3d3d"><?php echo $dash_profile['api_key']; ?></b>&file_id=YOUR_FILE_ID';

$curl = curl_init($target);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//// ## GET API RESPONSE ##//////

$curl_response = curl_exec($curl);
curl_close($curl);
$decoded = json_decode($curl_response);
print_r($decoded);
                
                </pre>
        <p>&nbsp;</p>

        <div class="note note-danger">
            <h4 class="block">Response</h4>

            <p style="padding-left:30px"> {
                "status": "processed",
                "success": true
                }
            </p>
        </div>


        <h4 class="block">HTTP GET to STATUS</h4>
        <table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%"
               style="word-break:break-all;" id="" cellspacing="0">
            <thead>
            <tr>
                <th>PARAMETER</th>
                <th>DESCRIPTION</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>API KEY</td>
                <td>This is a Required Field. Please enter your API KEY in the HTTP url. Your API KEY : <b
                        style="color:#3d3d3d"><?php echo $dash_profile['api_key']; ?></b></td>
            </tr>
            <tr>
                <td>FILE ID</td>
                <td>This is a Required Field . Please enter your file id in HTTP url, Search a file with this FILE ID.
                    Example : 575531de7xxxxxxxxxxxxxxxxx
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>
</div>