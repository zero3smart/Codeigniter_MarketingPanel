<div class="row">
    <div class="col-xs-12">


        <div class="note note-info">
            <h4 class="block">Example</h4>

            <p> This is a GET Method HTTP API. If You Downlaod a File then use this API. Copy this code and write a html
                file. Please Write YOUR_API_KEY <b style="color:#3d3d3d">( <?php echo $dash_profile['api_key']; ?></b> )
                in the target url and write YOUR_FILE_ID in the target url. When you run this api you will get a
                Response. Like below
                <br><br>
                You Can Change your API KEY from the bottom of <a href="<?php echo base_url(); ?>profile">this page</a>.
            </p>
        </div>
        <p style="color:#009; font-size:18px">PHP CODE</p>
                <pre style="padding-left:30px">
//// ## THIS IS DOWNLOAD LOOKUP  API ##//////  
            
$target = 'http://54.187.12.50:8080/EmailCleanupRESTAPI/file/download?api_key= <b
                        style="color:#3d3d3d"><?php echo $dash_profile['api_key']; ?></b>&file_id=YOUR_FILE_ID';

$curl = curl_init($target);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//// ## GET API RESPONSE ##//////

$curl_response = curl_exec($curl);

curl_close($curl);


//// ## FOR DOWNLOAD ##//////

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=YOUR_FILE_NAME.csv");
header("Pragma: no-cache");
header("Expires: 0");
echo str_replace("\n","\",\n",$curl_response);
                
                </pre>
        <p>&nbsp;</p>

        <div class="note note-danger">
            <h4 class="block">Response(Downloads Automatically in this Format)</h4>

            <p style="padding-left:30px"> AGUILARDAVI@YAHOO.COM,DAVI,AGUILAR,1013 KINGS
                CT,HERNDON,VA,20170,7035859910,M,7/8/2016,7:58:01,96.255.39.202,MOBILE
                gatlingal@sc.rr.com,Teresa,Crawford,318 COMMERCIAL
                ST,COLUMBIA,SC,29203,8035464329,F,7/8/2016,18:53:25,174.107.168.153,MOBILE
                larae.bowman@excite.com,LARAE,BOWMAN,688 NEWPORT
                CIRCLE,TERRYTOWN,LA,70056,5044957917,F,7/8/2016,16:56:11,64.34.130.244,MOBILE
            </p>
        </div>


        <h4 class="block">HTTP GET to DOWNLOAD</h4>
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
                <td>This is a Required Field. Please enter your API KEY in the HTTP url. Your API KEY :
                    <b style="color:#3d3d3d"><?php echo $dash_profile['api_key']; ?></b></td>
            </tr>
            <tr>
                <td>FILE ID</td>
                <td>This is a Required Field. Please enter your file id in HTTP url, Search a file with this FILE ID.
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