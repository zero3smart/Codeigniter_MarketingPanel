<link href="<?php echo base_url(); ?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
      rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"
      rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css"
      rel="stylesheet" type="text/css"/>

<style type="text/css">

</style>

<?php

if ($view['msg'] != "")
    echo msg($view['msg'], $view['msg_type']);

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
    $i = $serial + 1;
    $validation_chart_data_counter = 0;
    foreach ($file_status as $file_status_key => $file_status_value) {
        foreach ($file_status_value as $file_status_value_key => $file_status_value_value) {

            /*if (!isset($file_status_value_value['clean_file'])) {
                echo '<div class="col-xs-12" id="conatiner_full_row_chart_' . $file_status_value_value['_id'] . '">
                                        <div class="portlet box green">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-file-text-o"></i>' . $file_status_value_value['file_name'] . ' 
                                                </div>
                                            </div>
                                            <div class="portlet-body" id="group_list">
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-6 text-right text-danger"><h2>File processing not successful</h2></div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>';
            } else {*/

            echo '
                <script>
                validation_chart_data[' . $validation_chart_data_counter . '] = [];
                </script>
                ';
            $date = "";
            $date_array = array();
            $summary = $file_status_value_value["result"]["data"]['summary'];
            if ($summary['endTime'] != "") {
                //$date_array = explode(" ", $summary['endTime']);
                $date = date('F j, Y, g:i a', $summary['endTime']/1000);
            }

            $date_2 = "";
            $date_2_array = array();
            if ($file_status_value_value['upload_time'] != "") {
                $date_2_array = explode(" ", $file_status_value_value['upload_time']);
                $date_2 = date('F j, Y, g:i a', $date_2_array[1]);
            }

            echo '
                <script>
                        ';

            $inside_chart_index = 0;
            $total_summary_value = 0;
            $reports = $summary["files"][0]["reports"];

            $reports[]= array('reportName' => 'Total Clean Emails', 'numOfRecords' => ($summary['totalPreCleanRecords'] - $summary['totalRecordsAfterClean']));
            //$data_of_summary['Total_Clean_Emails']['name'] = 'Total Clean Emails';
            //$data_of_summary['Total_Clean_Emails']['value'] = $summary['totalPreCleanRecords'] - $summary['totalRecordsAfterClean'];


            foreach ($reports as $report_key => $report_value) {
                $chart_index = $report_value['reportName'];
                $chart_index = strtolower($chart_index);
                $chart_index = str_replace(" ", "_", $chart_index);

                $data_of_summary[$chart_index]['name'] = $report_value['reportName'];
                $data_of_summary[$chart_index]['value'] = $report_value['numOfRecords'];
                if ($chart_index != 'total_preclean_records') {
                    $total_summary_value = $total_summary_value + $report_value['numOfRecords'];
                    echo '
                                validation_chart_data[' . $validation_chart_data_counter . '][' . $inside_chart_index . '] = [];
                                validation_chart_data[' . $validation_chart_data_counter . '][' . $inside_chart_index . '][0] = "' . $report_value['reportName'] . '";
                                validation_chart_data[' . $validation_chart_data_counter . '][' . $inside_chart_index . '][1] = ' . $report_value['numOfRecords'] . ';

                                ';
                }
                $inside_chart_index++;
            }

            echo '
                            validation_chart_data_conatiner[' . $validation_chart_data_counter . '] = "#conatiner_validation_pie_chart_' . $file_status_value_value['_id'] . '";
                            validation_chart_data_title[' . $validation_chart_data_counter . '] = "' . $file_status_value_value['file_name'] . '";

                </script>

                ';

            //echo $total_summary_value;

            echo '

                <div class="col-xs-12" id="conatiner_full_row_chart_' . $file_status_value_value['_id'] . '">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o"></i>' . $file_status_value_value['file_name'] . ' 
                            </div>
                        </div>
                        <div class="portlet-body" id="group_list">
                            <div class="row">
                            ';
            if ($validation_chart_data_counter % 2 == 0) {
                echo '
                                <div class="col-xs-6">
                                    <div style="width:100%;min-height:300px;" id="conatiner_validation_pie_chart_' . $file_status_value_value['_id'] . '" >
                                    </div>';
                echo '
                                </div>
                                <div class="col-xs-6" >
                                    <div class="col-xs-12" >
                                        <table class="table nomargin text-right">
                                            <tr>
                                                <tr><td>Total preclean records : <b>' . $summary['totalPreCleanRecords'] . '</b></td></tr>
                                                <tr><td>Uploaded at : <b>' . $date_2 . '</b></td></tr>
                                                <tr><td>Completed at : <b>' . $date . '</b></td></tr>
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

                echo '

                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="col-xs-12 btn yellow" target="new" href="' . base_url() . 'clean_file_download/' . $file_status_value_value['clean_id'] . '" ><i class="fa fa-download"></i> Clean File Download</a>
                                                                    
                                        </div>
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="btn green col-xs-12" href="' . base_url() . 'report_file_download/' . $file_status_value_value['clean_id'] . '"><i class="fa fa-download"></i>  Report File Download</a>
                                        </div>
                                        <div class="col-xs-12">
                                            <a class="btn red col-xs-12 confirm_delete" href="' . base_url() . 'file_delete/' . $file_status_value_value['_id'] . '"><i class="fa fa-remove"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                                ';
            } else {
                echo '
                                <div class="col-xs-6" >
                                    <div class="col-xs-12" >
                                        <table class="table nomargin">
                                            <tr>
                                                <tr><td>' . $data_of_summary['total_preclean_records']['name'] . ' : <b>' . $data_of_summary['total_preclean_records']['value'] . '</b></td></tr>
                                                <tr><td>Uploaded at : <b>' . $date_2 . '</b></td></tr>
                                                <tr><td>Completed at : <b>' . $date . '</b></td></tr>
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
                echo '
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="col-xs-12 btn yellow" target="new" href="' . base_url() . 'clean_file_download/' . $file_status_value_value['clean_file'] . '" ><i class="fa fa-download"></i> Clean File Download</a>
                                                                    
                                        </div>
                                        <div class="col-xs-12" style="padding-bottom:5px;">
                                            <a class="btn green col-xs-12" href="' . base_url() . 'report_file_download/' . $file_status_value_value['report_file'] . '"><i class="fa fa-download"></i>  Report File Download</a>
                                        </div>
                                        <div class="col-xs-12">
                                            <a class="btn red col-xs-12 confirm_delete" href="' . base_url() . 'file_delete/' . $file_status_value_value['_id'] . '"><i class="fa fa-remove"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div style="width:100%;min-height:300px;" id="conatiner_validation_pie_chart_' . $file_status_value_value['_id'] . '" >
                                    </div>';
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


            $i++;
            $validation_chart_data_counter++;

        }
    }


    ?>
    <div class="col-xs-12">
        <div class="pagination_box text-right">
            <?php echo $pagination_links; ?>
        </div>
    </div>
</div>