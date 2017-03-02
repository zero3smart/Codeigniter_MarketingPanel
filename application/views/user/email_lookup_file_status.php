
        <link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	
</style>


<div class="row">
    
	<div class="col-xs-12">
		<div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>File List 
                                    </div>
                                        <!--<div class="caption pull-right">Total Expense : <?php// echo $expense_price_sum; ?> $</div>-->
                                   <!-- <div class="tools"> </div> -->
                                </div>
                                <div class="portlet-body" id="group_list">
                                <div class="table-responsive" >
                                    <table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" id="" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Serail</th>
                                                <th>Name</th>
                                                <th>Upload at</th>
                                                <th>Clean File</th>
                                                <th>Report File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $i=$serial+1;
                                                $validation_chart_data_counter = 0;
                                                foreach ($file_status as $file_status_key => $file_status_value) 
                                                {
                                                    foreach ($file_status_value as $file_status_value_key => $file_status_value_value) 
                                                    {
                                                        $date = "";
                                                        $date_array = array();
                                                        if($file_status_value_value['upload_time'] != "")
                                                        {
                                                            $date_array = explode(" ",$file_status_value_value['upload_time']);
                                                            $date = date('F j, Y, g:i a',$date_array[1]);
                                                        }

                                                        echo '
                                                        <tr>
                                                            <td>'.$i.'</td>
                                                            <td>'.$file_status_value_value['file_name'].'</td>
                                                            <td>'.$date.'</td>
                                                            <td><a class="btn yellow" href="'.base_url().'clean_file_download/'.$file_status_value_value['clean_file'].'" ><span class="fa fa-download"></span> Clean File</a></td>
                                                            <td><a class="btn green" href="'.base_url().'report_file_download/'.$file_status_value_value['report_file'].'" ><span class="fa fa-download"></span> Report File</a></td>
                                                        </tr>
                                                        ';


                                                    }
                                                    $i++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="pagination_box text-right">
                                        <?php echo $pagination_links; ?>
                                    </div>
                                    </div>
                                </div>
                            </div>
	</div>
</div>
                                                               