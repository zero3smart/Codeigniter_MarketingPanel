
        <link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    
</style>


<!--
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>File List </div>
                                </div>
                                <div class="portlet-body" id="group_list">
                                <div class="table-responsive" >
                                    <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="">Name</th>
                                                <th class="">Uploaded at</th>
                                                <th class="">Completed at</th>
                                                <th class="">Total Contact</th>
                                                <th class="">Total Successful</th>
                                                <th class="">Total Failed</th>
                                                <th class="">Total Invalid</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <script>
                                                        var carrier_json = [];
                                                        </script>
                                            <?php
                                                /*$i=$serial+1;

                                                foreach ($file_status as $file_status_key => $file_status_value) {
                                                    foreach ($file_status_value as $file_status_value_key => $file_status_value_value) {

                                                        $api_log = array();
                                                        $api_log = $this->Mdl_user->get_api_log_single($file_status_value_value['_id']);
                                                        $row = 'odd';
                                                        if($i%2==0)     $row = 'even';
                                                        $date = "";
                                                        $date_array = array();
                                                        if($file_status_value_value['process_end_time'] != "")
                                                        {
                                                            $date_array = explode(" ",$file_status_value_value['process_end_time']);
                                                            $date = date('F j, Y, g:i a',$date_array[1]);
                                                        }
                                                        $carrier_json = json_encode($file_status_value_value['carrier']);
                                                        $carrier_json = str_replace('"name":','name:',$carrier_json);
                                                        $carrier_json = str_replace('"value":','y:',$carrier_json);

                                                        $carrier_type_json = json_encode($file_status_value_value['carrier_type']);
                                                        $carrier_type_json = str_replace('"name":','name:',$carrier_type_json);
                                                        $carrier_type_json = str_replace('"value":','y:',$carrier_type_json);

                                                        $state_json = json_encode($file_status_value_value['state']);
                                                        $state_json = str_replace('"name":','name:',$state_json);
                                                        $state_json = str_replace('"value":','y:',$state_json);


                                                        $city_json = json_encode($file_status_value_value['city']);
                                                        $city_json = str_replace('"name":','name:',$city_json);
                                                        $city_json = str_replace('"value":','y:',$city_json);


                                                        $country_json = json_encode($file_status_value_value['country']);
                                                        $country_json = str_replace('"name":','name:',$country_json);
                                                        $country_json = str_replace('"value":','y:',$country_json);


                                                        echo '
                                                        <script>
                                                          var  carrier_json_'.$file_status_value_value['_id'].' = '.$carrier_json.';
                                                          var  carrier_type_json_'.$file_status_value_value['_id'].' = '.$carrier_type_json.';
                                                          var  state_json_'.$file_status_value_value['_id'].' = '.$state_json.';
                                                          var  city_json_'.$file_status_value_value['_id'].' = '.$city_json.';
                                                          var  country_json_'.$file_status_value_value['_id'].' = '.$country_json.';
                                                        </script>
                                                        ';
                                                        echo '
                                                        <tr class="'.$row.'" role="row">
                                                            <td>'.$file_status_value_value['file_name'].'</td>
                                                            <td>'.$file_status_value_value['upload_time'].'</td>
                                                            <td>'.$date.'</td>
                                                            <td>'.$file_status_value_value['total_contacts'].'</td>
                                                            <td>'.$file_status_value_value['total_successful'].'</td>
                                                            <td>'.$file_status_value_value['total_failed'].'</td>
                                                            <td>'.$file_status_value_value['total_invalid'].'</td>
                                                            <td>
                                                            <a class="btn yellow" target="new" href="'.base_url().'report/file_upload_status_chart/'.$file_status_value_value['fs_file_id'].'" >Statics</a>
                                                            <!--<a class="btn yellow"  onclick="show_pie_chart(\''.$file_status_value_value['file_name'].'\',\''.$file_status_value_value['_id'].'\','.$file_status_value_value['total_contacts'].','.$file_status_value_value['total_successful'].','.$file_status_value_value['total_failed'].','.$file_status_value_value['total_invalid'].',carrier_json_'.$file_status_value_value['_id'].',carrier_type_json_'.$file_status_value_value['_id'].',state_json_'.$file_status_value_value['_id'].',city_json_'.$file_status_value_value['_id'].',country_json_'.$file_status_value_value['_id'].',event)">Statics</a>-->
                                                            </td>
                                                            
                                                            <td><!--'.base_url().'file_download/'.$file_status_value_value['fs_file_id'].'-->
                                                            <a class="btn green" data-toggle="modal" href="#download_'.$file_status_value_value['_id'].'"><i class="fa fa-download"></i> Download</td>
                                                        </tr>

                                                        ';
                                                            echo '<div id="download_'.$file_status_value_value['_id'].'" class="modal fade" tabindex="-1" data-width="760">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                    <h4 class="modal-title">Download <span style="color:#27a4b0">'.$file_status_value_value['file_name'].'</span></h4>
                                                                                </div>
                                                                                <div class="modal-body payment_method_body">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12">
                                                                                            <div class="col-xs-12 col-md-8 col-md-offset-2 file_download_section">
                                                                                                <div class="col-xs-12">
                                                                                                    <a class="col-xs-12 btn btn-primary" href="'.base_url().'file_download/'.$file_status_value_value['fs_file_id'].'"><i class="fa fa-download"></i> Download All</a>
                                                                                                </div>
                                                                                                <div class="col-xs-12">
                                                                                                    <h3 class="col-xs-12 nomargin text-center">OR Download by Category</h3>
                                                                                                </div>
                                                                                                <form action="'.base_url().'file_download_as_criteria" method="post">
                                                                                                <input type="hidden" name="file_id" value="'.$file_status_value_value['fs_file_id'].'">
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As Carrier : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <!--onchange="document.location.href=\''.base_url().'file_download/'.$file_status_value_value['fs_file_id'].'/carrier/\'+this.value;" carrier_type state city wireless -->
                                                                                                        <select class="form-control" name="carrier" >
                                                                                                            <option value="">Select Carrier</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['carrier'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As Carrier Type : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="carrier_type" >
                                                                                                            <option value="">Select Carrier Type</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['carrier_type'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                

                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As State : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="state" >
                                                                                                            <option value="">Select State</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['state'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As City : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="city">
                                                                                                            <option value="">Select City</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['city'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>

                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">Wireless : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="wireless">
                                                                                                            <option value="">Select</option>
                                                                                                            <option value="TRUE">Yes</option>
                                                                                                            <option value="FALSE">No</option>
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <button class="btn green col-xs-12"><i class="fa fa-download"></i> Download</button>
                                                                                                </div>


                                                                                                </form>

                                                                                                

                                                                                            </div>
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
                                                */
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="pagination_box text-right">
                                        <?php /* echo $pagination_links;*/ ?>
                                    </div>
                                    </div>
                                </div>
                            </div>
    </div>
</div>

<div id="chart_modal" class="modal fade" tabindex="-1" data-width="1300">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                    <h4 class="modal-title">Demograph of <span style="color:#27a4b0" id="chart_file_name"></span></h4>
                                                                                </div>
                                                                                <div class="modal-body payment_method_body">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12" id="file_upload_status_all_chart" style="padding:0;">
                                                                                            <div class="col-xs-12">

                                                                                                <div id="contact_chart_container" class="col-xs-12" style="min-height:400px;">

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <div id="carrier_chart_container" class="col-xs-12" style="min-height:400px;">

                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <div id="carrier_type_chart_container" class="col-xs-12" style="min-height:400px;">

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <div id="state_chart_container" class="col-xs-12" style="min-height:400px;">

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <div id="city_chart_container" class="col-xs-12" style="min-height:400px;">

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-xs-12">
                                                                                            <div class="col-xs-4 nopadding">
                                                                                                <div class="btn btn-lg purple col-xs-12">Total Contacts : <span id="chart_total"></span></div>
                                                                                            </div>
                                                                                            <div class="col-xs-4 nopadding">
                                                                                                <div class="btn btn-lg blue col-xs-12">Successful : <span id="chart_successful"></span></div>
                                                                                            </div>
                                                                                            <div class="col-xs-4 nopadding">
                                                                                                <div class="btn btn-lg dark col-xs-12">Failed : <span id="chart_failed"></span></div>
                                                                                            </div>

                                                                                        </div>
                                                                                        
                                                                                            
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <a data-dismiss="modal" class="btn btn-outline dark">Cancel</a>
                                                                                </div>
                                                                            </div>
-->

<?php 
                    
                        if($view['msg'] != "" ) 
                            echo msg($view['msg'],$view['msg_type']); 
                    
                    ?>
<div class="row">

    <script type="text/javascript">
        validation_chart_data = [];
        validation_chart_data_total = [];
        validation_chart_data_successful = [];
        validation_chart_data_failed = [];
        validation_chart_data_invalid = [];
        validation_chart_data_conatiner = [];
        validation_chart_data_title = [];
    </script>
    <?php
        $i=$serial+1;
        $validation_chart_data_counter = 0;
        foreach ($file_status as $file_status_key => $file_status_value) 
        {
            foreach ($file_status_value as $file_status_value_key => $file_status_value_value) 
            {

                if(!isset($file_status_value_value['clean_file']))
                            {
                                echo '<div class="col-xs-12" id="conatiner_full_row_chart_'.$file_status_value_value['_id'].'">
                                        <div class="portlet box green">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-file-text-o"></i>'.$file_status_value_value['file_name'].' 
                                                </div>
                                            </div>
                                            <div class="portlet-body" id="group_list">
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-6 text-right text-danger"><h2>File processing not successful</h2></div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>'     
                                        ;
                            }

                else{ 

                echo '
                <script>
                validation_chart_data['.$validation_chart_data_counter.'] = [];
                </script>
                ';
                $date = "";
                $date_array = array();
                if($file_status_value_value['process_end_time'] != "")
                {
                    $date_array = explode(" ",$file_status_value_value['process_end_time']);
                    $date = date('F j, Y, g:i a',$date_array[1]);
                }
                
                $date_2 = "";
                $date_2_array = array();
                if($file_status_value_value['upload_time'] != "")
                {
                    $date_2_array = explode(" ",$file_status_value_value['upload_time']);
                    $date_2 = date('F j, Y, g:i a',$date_2_array[1]);
                }

                echo '
                <script>
                        ';
                        
                        $inside_chart_index = 0;
                        $total_summary_value = 0;
                        foreach ($file_status_value_value['summary'] as $summary_key => $summary_value) {
                            $chart_index = $summary_value['name'];
                            $chart_index = strtolower($chart_index);
                            $chart_index = str_replace(" ","_",$chart_index);
                            
                            $data_of_summary[$chart_index]['name'] = $summary_value['name'];
                            $data_of_summary[$chart_index]['value'] = $summary_value['value'];
                            if($chart_index != 'total_preclean_records')
                            {
                                $total_summary_value = $total_summary_value + $summary_value['value'];
                                echo '
                                validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'] = [];
                                validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][0] = "'.$summary_value['name'].'";
                                validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][1] = '.$summary_value['value'].';

                                ';
                            }
                            $inside_chart_index++;
                        }
                        

                        /*$total_email_exists = 0;
                            if(isset($file_status_value_value['total_email_exists']))
                                $total_email_exists = $file_status_value_value['total_email_exists'];
                            
                        echo '
                            validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'] = [];
                            validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][0] = "Total Email Exists";
                            validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][1] = '.$total_email_exists.';
                        ';
                        */
                        echo '
                            validation_chart_data_conatiner['.$validation_chart_data_counter.'] = "#conatiner_validation_pie_chart_'.$file_status_value_value['_id'].'";
                            validation_chart_data_title['.$validation_chart_data_counter.'] = "'.$file_status_value_value['file_name'].'";

                </script>

                ';

                //echo $total_summary_value;

                echo '

                <div class="col-xs-12" id="conatiner_full_row_chart_'.$file_status_value_value['_id'].'">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o"></i>'.$file_status_value_value['file_name'].' 
                            </div>
                        </div>
                        <div class="portlet-body" id="group_list">
                            <div class="row">
                            ';
                            if($validation_chart_data_counter%2 == 0)
                            {
                            echo '
                                <div class="col-xs-6">
                                    <div style="width:100%;min-height:300px;" id="conatiner_validation_pie_chart_'.$file_status_value_value['_id'].'" >
                                    </div>';
                                    /*
                                    <script>
                                    ';
                                    
                                    $inside_chart_index = 0;
                                    foreach ($file_status_value_value['summary'] as $summary_key => $summary_value) {
                                        $chart_index = $summary_value['name'];
                                        $chart_index = strtolower($chart_index);
                                        $chart_index = str_replace(" ","_",$chart_index);

                                        

                                        echo '
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'] = [];
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][0] = "'.$summary_value['name'].'";
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][1] = '.$summary_value['value'].';

                                        ';
                                        $inside_chart_index++;
                                    }

                                    echo '
                                        validation_chart_data_conatiner['.$validation_chart_data_counter.'] = "#conatiner_validation_pie_chart_'.$file_status_value_value['_id'].'";
                                        validation_chart_data_title['.$validation_chart_data_counter.'] = "'.$file_status_value_value['file_name'].'";

                                    </script>*/
                                    echo '
                                </div>
                                <div class="col-xs-6" >
                                    <div class="col-xs-12" >
                                        <table class="table nomargin text-right">
                                            <tr>
                                                <tr><td>'.$data_of_summary['total_preclean_records']['name'].' : <b>'.$data_of_summary['total_preclean_records']['value'].'</b></td></tr>
                                                <tr><td>Uploaded at : <b>'.$date_2.'</b></td></tr>
                                                <tr><td>Completed at : <b>'.$date.'</b></td></tr>
                                                <tr><td></td></tr>
                                            </tr>
                                         </table>
                                         <div class="col-xs-12" style="margin-bottom:10px;border-bottom:2px solid #ddd;"></div>
                                    </div>
                                    
                                    <div class="col-xs-6 hidden">
                                        <table class="table hidden">
                                            
                                            <tr><td>Successfull</td><td></td></tr>
                                        
                                            <tr><td>Failed</td><td></td></tr>
                                            <tr><td>Invalid</td><td></td></tr>
                                            
                                        </table>
                                    </div>                      
                                    <div class="col-xs-8 col-xs-offset-4 nopadding">
                                        ';
                                        /*if(isset($file_status_value_value['smtp_clean_file']))
                                        {
                                            echo '
                                            <div class="col-xs-12" style="padding-bottom:5px;">
                                                <a class="col-xs-12 btn purple" target="new" href="'.base_url().'smtp_clean_file_download/'.$file_status_value_value['smtp_clean_file'].'" ><i class="fa fa-download"></i> SMTP Clean File Download</a>
                                                                        
                                            </div>
                                            ';
                                        }
                                        */
                                        echo '

                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="col-xs-12 btn yellow" target="new" href="'.base_url().'clean_file_download/'.$file_status_value_value['clean_file'].'" ><i class="fa fa-download"></i> Clean File Download</a>
                                                                    
                                        </div>
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="btn green col-xs-12" href="'.base_url().'report_file_download/'.$file_status_value_value['report_file'].'"><i class="fa fa-download"></i>  Report File Download</a>
                                        </div>
                                        <div class="col-xs-12">
                                            <a class="btn red col-xs-12 confirm_delete" href="'.base_url().'file_delete/'.$file_status_value_value['_id'].'"><i class="fa fa-remove"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                                ';
                                }
                                else
                                {
                                    echo '
                                <div class="col-xs-6" >
                                    <div class="col-xs-12" >
                                        <table class="table nomargin">
                                            <tr>
                                                <tr><td>'.$data_of_summary['total_preclean_records']['name'].' : <b>'.$data_of_summary['total_preclean_records']['value'].'</b></td></tr>
                                                <tr><td>Uploaded at : <b>'.$date_2.'</b></td></tr>
                                                <tr><td>Completed at : <b>'.$date.'</b></td></tr>
                                                <tr><td></td></tr>
                                            </tr>
                                         </table>
                                         <div class="col-xs-12" style="margin-bottom:10px;border-bottom:2px solid #ddd;"></div>
                                    </div>
                                    <div class="col-xs-6 hidden">
                                        <table class="table hidden">
                                            
                                            <tr><td>Successfull</td><td></td></tr>
                                        
                                            <tr><td>Failed</td><td></td></tr>
                                            <tr><td>Invalid</td><td></td></tr>
                                            
                                        </table>
                                    </div>                      
                                    <div class="col-xs-8 nopadding">
                                        ';
                                        /*if(isset($file_status_value_value['smtp_clean_file']))
                                        {
                                            echo '
                                            <div class="col-xs-12" style="padding-bottom:5px;">
                                                <a class="col-xs-12 btn purple" target="new" href="'.base_url().'smtp_clean_file_download/'.$file_status_value_value['smtp_clean_file'].'" ><i class="fa fa-download"></i> SMTP Clean File Download</a>
                                                                        
                                            </div>
                                            ';
                                        }*/
                                        echo '
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="col-xs-12 btn yellow" target="new" href="'.base_url().'clean_file_download/'.$file_status_value_value['clean_file'].'" ><i class="fa fa-download"></i> Clean File Download</a>
                                                                    
                                        </div>
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="btn green col-xs-12" href="'.base_url().'report_file_download/'.$file_status_value_value['report_file'].'"><i class="fa fa-download"></i>  Report File Download</a>
                                        </div>
                                        <div class="col-xs-12">
                                            <a class="btn red col-xs-12 confirm_delete" href="'.base_url().'file_delete/'.$file_status_value_value['_id'].'"><i class="fa fa-remove"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div style="width:100%;min-height:300px;" id="conatiner_validation_pie_chart_'.$file_status_value_value['_id'].'" >
                                    </div>';
                                    /*
                                    <script>
                                    ';
                                    $inside_chart_index = 0;
                                    foreach ($file_status_value_value['summary'] as $summary_key => $summary_value) {
                                        $chart_index = $summary_value['name'];
                                        $chart_index = strtolower($chart_index);
                                        $chart_index = str_replace(" ","_",$chart_index);
                                        echo '
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'] = [];
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][0] = "'.$summary_value['name'].'";
                                        validation_chart_data['.$validation_chart_data_counter.']['.$inside_chart_index.'][1] = '.$summary_value['value'].';

                                        ';
                                        $inside_chart_index++;
                                    }
                                    
                                    
                                    echo '
                                        validation_chart_data_conatiner['.$validation_chart_data_counter.'] = "#conatiner_validation_pie_chart_'.$file_status_value_value['_id'].'";

                                    </script>*/
                                    echo '
                                </div>
                                
                                ';
                                }
                                echo '
                            </div>

                        </div>
                    </div>
                </div>

                ';


                /*
                echo '<div id="download_'.$file_status_value_value['_id'].'" class="modal fade" tabindex="-1" data-width="760">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                    <h4 class="modal-title">Download <span style="color:#27a4b0">'.$file_status_value_value['file_name'].'</span></h4>
                                                                                </div>
                                                                                <div class="modal-body payment_method_body">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12">
                                                                                            <div class="col-xs-12 col-md-8 col-md-offset-2 file_download_section">
                                                                                                <div class="col-xs-12">
                                                                                                    <a class="col-xs-12 btn btn-primary" href="'.base_url().'file_download/'.$file_status_value_value['fs_file_id'].'"><i class="fa fa-download"></i> Download All</a>
                                                                                                </div>
                                                                                                <div class="col-xs-12">
                                                                                                    <h3 class="col-xs-12 nomargin text-center">OR Download by Category</h3>
                                                                                                </div>
                                                                                                <form class="file_download_as_criteria" action="'.base_url().'file_download_as_criteria" method="post">
                                                                                                <input type="hidden" name="file_id" value="'.$file_status_value_value['fs_file_id'].'">
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As Carrier : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <!--onchange="document.location.href=\''.base_url().'file_download/'.$file_status_value_value['fs_file_id'].'/carrier/\'+this.value;" carrier_type state city wireless -->
                                                                                                        <select class="form-control" name="carrier" >
                                                                                                            <option value="">Select Carrier</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['carrier'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As Carrier Type : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="carrier_type" >
                                                                                                            <option value="">Select Carrier Type</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['carrier_type'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                

                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As State : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="state" >
                                                                                                            <option value="">Select State</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['state'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">As City : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="city">
                                                                                                            <option value="">Select City</option>
                                                                                                            ';
                                                                                                            foreach ($file_status_value_value['city'] as $carrier_key => $carrier_value) {
                                                                                                                echo '<option value="'.$carrier_value['name'].'">'.$carrier_value['name'].' ('.$carrier_value['value'].')</option>';
                                                                                                            }
                                                                                                            echo '
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>

                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <div class="col-xs-6">Wireless : </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <select class="form-control" name="wireless">
                                                                                                            <option value="">Select</option>
                                                                                                            <option value="TRUE">Yes</option>
                                                                                                            <option value="FALSE">No</option>
                                                                                                            
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class="col-xs-12 nopadding">
                                                                                                    <button class="btn green col-xs-12"><i class="fa fa-download"></i> Download</button>
                                                                                                </div>


                                                                                                </form>

                                                                                                

                                                                                            </div>
                                                                                        </div>
                                                                                            
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <!--<a class="btn btn-outline green" data-dismiss="modal">Select this</a>-->
                                                                                    <a data-dismiss="modal" class="btn btn-outline dark">Cancel</a>
                                                                                </div>
                                                                            </div>';
                                                        */


          
            $i++;
            $validation_chart_data_counter++;

                }  // END ELSE
            }
        }


    ?>
    <div class="col-xs-12">
    <div class="pagination_box text-right">
                                        <?php echo $pagination_links; ?>
                                    </div>
                                    </div>
</div>