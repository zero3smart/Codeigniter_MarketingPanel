
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
                                    </div>
                                        <!--<div class="caption pull-right">Total Expense : <?php //echo $expense_price_sum; ?> $</div>-->
                                   <!-- <div class="tools"> </div> -->
                                </div>
                                <div class="portlet-body" id="group_list">
                                <div class="table-responsive" >
                                    <table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" id="" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Email</th>
                                                <th>Count</th>
                                                <th>Response</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                foreach ($instant_lookup_details as $instant_lookup_details_key => $instant_lookup_details_value) {
                                                    $serial++;
                                                    $date = "";
                                                    $type = '';
                                                                                                        $date_array = array();
                                                                                                        if($instant_lookup_details_value['time'] != "")
                                                                                                        {
                                                                                                            $date_array = explode(" ",$instant_lookup_details_value['time']);
                                                                                                            $date = date('F j, Y, g:i a',$date_array[1]);
                                                                                                        }
                                                    echo '
                                                    <tr>
                                                        <td class="text-center vertical-middle">'.$serial.'</td>
                                                        <td class="vertical-middle">'.nl2br(str_replace(",",",\n",$instant_lookup_details_value['numbers'])).'</td>
                                                        <td class="text-center vertical-middle">'.$instant_lookup_details_value['numbers_count'].'</td>
                                                        <td>
                                                            <div class="instant_lookup_response_con">
                                                                <pre style="" class="response_show_in_pre">'.$instant_lookup_details_value['response'].'</pre>
                                                                <div class="see_more_container text-right">
                                                                 &nbsp;&nbsp;&nbsp;<a href="'.base_url().'User_controller/instant_lookup_report_download_by_id/'.$instant_lookup_details_value['_id'].'"> [..Download..]</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="vertical-middle">'.$date.'</td>
                                                    </tr>
                                                    ';
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
                                                                <div id="date_range_modal" class="modal fade" tabindex="-1" data-width="760">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                    <h4 class="modal-title">Select Date Range</h4>
                                                                                </div>
                                                                                <div class="modal-body payment_method_body">
                                                                                    <div class="row">
                                                                                        
                                                                                            <div class="col-xs-12 col-md-8 col-md-offset-2">
                                                                                                <table class="table">
                                                                                                    <tr><td>From : </td><td><input id="expense_from_date" type="text" class="form-control date-picker" data-date-picker="yyyy-mm-dd" placeholder="Select Date From"></td></tr>
                                                                                                    <tr><td>To : </td><td><input id="expense_to_date" type="text" class="form-control date-picker" placeholder="Select Date To"></td></tr>                                                                                                
                                                                                                </table>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <!--<a class="btn btn-outline green" data-dismiss="modal">Select this</a>-->
                                                                                    <a data-dismiss="modal" class="btn btn-outline dark">Cancel</a>
                                                                                    <a  class="btn btn-outline green" id="expense_by_date_btn">Go</a>
                                                                                </div>
                                                                </div>