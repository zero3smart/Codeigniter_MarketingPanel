
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
                                        <i class="fa fa-globe"></i>Transaction List 
                                    </div>
                                    <div class="pull-right">
                                    <a class="btn dark" data-toggle="modal" href="#date_range_modal" style="margin:3px 5px 0 15px;">Search by Date</a>
                                    </div>
                                    <div class="caption pull-right">Total Credit Usage : <?php echo $expense_price_sum; ?> </div>
                                   <!-- <div class="tools"> </div> -->
                                </div>
                                <div class="portlet-body" id="group_list">
                                <div class="table-responsive" >
                                    <table class="table_all_center table table-bordered table-striped table-condensed flip-content" width="100%" style="word-break:break-all;" id="" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Credits</th>
                                                <th>Notes</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                foreach ($expense_details as $expense_details_key => $expense_details_value) {
                                                    $serial++;
                                                    $date = "";
                                                    $type = '';
                                                                                                        $date_array = array();
                                                                                                        if($expense_details_value['time'] != "")
                                                                                                        {
                                                                                                            $date_array = explode(" ",$expense_details_value['time']);
                                                                                                            $date = date('F j, Y, g:i a',$date_array[1]);
                                                                                                        }
                                                    echo '
                                                    <tr>
                                                        <td>'.$serial.'</td>
                                                        <td>'.$expense_details_value['credit'].'</td>
                                                        <td>'.$expense_details_value['notes'].'</td>
                                                        <td>'.$date.'</td>
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

                                                                                                    <tr><td>From : </td><td><input id="report_action_from_date" type="text" class="form-control date-picker" data-date-picker="yyyy-mm-dd" placeholder="Select Date From"></td></tr>
                                                                                                    <tr>
                                                                                                        <td>To : </td>
                                                                                                        <td>
                                                                                                            <input id="report_action_to_date" type="text" class="form-control date-picker" placeholder="Select Date To">
                                                                                                            <input id="report_action_url" type="hidden" value="<?php echo base_url();?>report/credit/expense_by_date/">

                                                                                                        </td>
                                                                                                    </tr>                                                                                                
                                                                                                </table>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <!--<a class="btn btn-outline green" data-dismiss="modal">Select this</a>-->
                                                                                    <a data-dismiss="modal" class="btn btn-outline dark">Cancel</a>
                                                                                    <a  class="btn btn-outline green" id="report_action_by_date_btn">Go</a>
                                                                                </div>
                                                                </div>