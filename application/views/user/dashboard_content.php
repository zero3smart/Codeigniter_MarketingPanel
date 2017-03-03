<?php
/*app.snapiq.com/application/view/user/dashboard_content*/
?>
<style type="text/css">

    .dashboard-stat {
        position: relative;
    }

    .dashboard-stat.line > .visual, .dashboard-stat.line > .more {
        padding-left: 25px;
    }

    .dashboard-stat.line > .bar {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 8px;
        z-index: 10;
    }

    .dashboard-stat.red-c {
        border-left: 8px solid #e7505a;
    }

    .dashboard-stat.red-c .visual .fa {
        color: #e7505a;
        opacity: .2;
    }

    .dashboard-stat.blue-c {
        border-left: 8px solid #3598dc;
    }

    .dashboard-stat.blue-c .visual .fa {
        color: #3598dc;
        opacity: .2;
    }

    .dashboard-stat.green-c {
        border-left: 8px solid #32c5d2;
    }

    .dashboard-stat.green-c .visual .fa {
        color: #32c5d2;
        opacity: .2;
    }

    .dashboard-stat.purple-c {
        border-left: 8px solid #8E44AD;
    }

    .dashboard-stat.purple-c .visual .fa {
        color: #8E44AD;
        opacity: .2;
    }

</style>
<?php
$count_processing_user_file = $this->Mdl_user->count_processing_user_file();
?>
<div class="row">

    <div class="col-xs-12 nopadding">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="1349" data-counter="counterup"><?php echo $dash_profile['balance']; ?></span>
                    </div>
                    <div class="desc"> Credit Balance</div>
                </div>
                <a class="more" href="<?php echo base_url(); ?>buy_credit"> Buy more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="89" data-counter="counterup"><?php echo $daily_limit_left; ?></span></div>
                    <div class="desc"> Remaining Daily Limit</div>
                </div>
                <a class="more" href="<?php echo base_url(); ?>packages"> Change Plan
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="549" data-counter="counterup"><?php echo $total_usable_credit; ?></span>
                    </div>
                    <div class="desc"> Usable Credit</div>
                </div>
                <a class="more" href="<?php echo base_url(); ?>buy_credit"> Buy more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat purple-c white line">
                <div class="visual">
                    <?php
                    if ($count_processing_user_file > 0) {
                        echo '<i class="fa fa-spin fa-circle-o-notch"></i>';
                    }
                    ?>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="12,5"
                              data-counter="counterup"><?php echo $count_processing_user_file; ?></span></div>
                    <div class="desc"> Files Processing</div>
                </div>
                <a class="more invisible" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-c white line">
                <div class="visual">
                    <i class="fa fa-upload"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="12,5"
                              data-counter="counterup"><?php echo $file_summery_all['preclean_records']; ?></span></div>
                    <div class="desc"> Total Email Uploaded</div>
                </div>
                <a class="more invisible" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat green-c white line">
                <div class="visual">
                    <i class="fa fa-filter"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-value="12,5"
                              data-counter="counterup"><?php echo $file_summery_all['clean_records']; ?></span></div>
                    <div class="desc"> Total Valid Emails</div>
                </div>
                <a class="more invisible" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>


    </div>
    <div class="col-xs-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>File Clean up
                    Demograph <?php if ($total_graph_data_sum == 0) echo '( No Data Found to show in Graph )'; ?>
                </div>
            </div>
            <div class="portlet-body" id="group_list">
                <div class="row">
                    <div class="col-xs-12" id="file_status_group_chart" style="min-height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Transaction Demograph
                </div>
            </div>
            <div class="portlet-body" id="group_list">
                <div class="row">
                    <div class="col-xs-12" id="transaction_heighchart" style="min-height:500px;"></div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
    </div>


</div>