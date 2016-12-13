<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title> Email Lookup</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php require_once("includes/header.php");?>
        <style type="text/css">
        
            .page-content{min-height:400px;}
            .page-header.navbar .page-logo
            {
                background: #b5f1dd;
                position: relative;
                padding-right:10px;padding-left: 10px;
            }
            .page-header.navbar .menu-toggler.sidebar-toggler{
                float: right;
                margin: 23px 0px 0 0;
                position: absolute;
                right: -40px;
                background-image:url('<?php echo base_url();?>assets/layouts/layout2/img/sidebar-toggler-2.png');
            }
            .page-sidebar-closed.page-sidebar-closed-hide-logo .page-header.navbar .menu-toggler.sidebar-toggler{
                right: 0px;
            }
            .teal-blue{background:#68a3a5 !important;border-color:#68a3a5 !important;}
            .btn.teal-blue{color:#fff !important;}
        </style>
    </head>
    <!-- END HEAD -->
        <?php
            
            function msg($msg,$type)
            {
                $msg = '
                    <div class="alert alert-'.$type.' alert-dismissable col-xs-12" style="margin:15px 0;">
                        <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">
                                  &times;
                        </button>
                    '.$msg.'
                    </div>
                ';
                return $msg;
            }

            $dash_profile = $this->Mdl_user->fetch_user_profile();
            $current_package = $this->Mdl_user->fetch_current_package();
            $daily_limit = $this->Mdl_user->fetch_user_daily_limit();

            if($daily_limit > -1){
                $daily_limit_left = $current_package['daily_limit'] - $daily_limit;
            }
            else
            {
                $daily_limit_left= 0;
            }

            $total_usable_credit = $daily_limit_left + $dash_profile['balance'];

            if($current_package)
            {
                echo '
                <script>
                    var global_id = "'.$dash_profile['_id'].'";
                    var global_username = "'.$dash_profile['username'].'";
                    var global_balance = '.$dash_profile['balance'].';
                    var global_daily_limit_left = '.$daily_limit_left.';
                    var global_total_usable_credit = '.$total_usable_credit.';
                    var base_url = "'.base_url().'";
                    
                    //localStorage[]
                </script>
                ';
            }
            else
            {
                echo '
                <script>
                    var global_id = "'.$dash_profile['_id'].'";
                    var global_username = "'.$dash_profile['username'].'";
                    var global_balance = '.$dash_profile['balance'].';
                    var global_daily_limit_left = 0;
                    var global_total_usable_credit = '.$dash_profile['balance'].';
                    var base_url = "'.base_url().'";
                    
                    //localStorage[]
                </script>
                ';
            }


        

        ?>
    <body class="page-sidebar-closed-hide-logo page-container-bg-solid page-header-fixed page-sidebar-fixed">
        <div  class="hide" id="base_url"><?php echo base_url(); ?></div> 
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="" style="width:100%;">
                        <img style="height:45px;max-width:100%;margin:15px 0 0 0;" src="<?php echo base_url();?>assets/user/images/verify_rocket_logo_small.png" alt="logo" class="logo-default" /> 

                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN PAGE ACTIONS -->
                <!-- DOC: Remove "hide" class to enable the page header actions -->
                
                <!-- END PAGE ACTIONS -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                           
                                
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="<?php echo base_url().$this->session->email_lookup_user_avater;?>">
                                    <span class="username username-hide-mobile"><?php echo $this->session->email_lookup_user_username; ?></span>
                                </a>
                                
                            </li>

                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER
                            <li class="dropdown dropdown-extended quick-sidebar-toggler"  style="padding:0 4px;">
                                <a href="<?php echo base_url();?>logout" class="dropdown-toggle">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>
                             END QUICK SIDEBAR TOGGLER -->
                        </ul>
                        <div class="pull-right" style="padding-top:10px;">
                        	<a href="javascript:;" class="btn teal-blue btn-lg">
                                Credit : <span id="top_menu_global_balance"><?php echo $dash_profile['balance'] ; ?></span>
                            </a>
                            <span id="top_menu_global_usable_credit" class="hidden"><?php echo $total_usable_credit ; ?></span>
                            <?php
                             if($daily_limit > -1)
                             {
                                echo '<a href="javascript:;" class="btn teal-blue btn-lg">
                                    Daily Limit : <span id="top_menu_global_daily_limit">'.$daily_limit_left.'</span>
                                </a>';

                             } 
                             else
                             {
                                echo '<a href="javascript:;" class="hidden btn teal-blue btn-lg">
                                    Daily Limit : <span id="top_menu_global_daily_limit">0</span>
                                </a>';
                             }
                             ?>
                            <a  href="<?php echo base_url();?>logout" class="btn red btn-lg">
                                <i class="icon-key"></i> Log Out 
                            </a>
                        </div>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->

                    <?php include_once("menu.php");?>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <?php
                        if($view['page_title'] != '')
                        {
                            echo '
                            <h3 class="page-title"> '.$view['page_title'].'
                                <small>'.$view['page_sub_title'].'</small>
                                ';
                                if($view['section'] == 'profile')                         
                                {
                                    if($view['first'] == 1)
                                        echo '<span class="pull-right">Welcome &nbsp; <b>'.$dash_profile['username'].'</b></span>';
                                }
                                echo '
                            </h3>
                            ';
                         } 
                         ?>
                    <?php

                        if($view['section'] == 'dashboard')                         
                        {
                            include_once'dashboard_content.php';
                        }

                        if($view['section'] == 'packages')                         
                        {
                            include_once'package.php';
                        }

                        if($view['section'] == 'profile')                         
                        {
                            include_once'profile.php';
                        }

                        if($view['section'] == 'contact_upload_section')
                        {
                            include_once'contact_upload_section.php';
                    
                        }
                           


                        if($view['section'] == 'file_upload_status')
                        {
                            include_once'file_upload_status.php';
                        }     

                        
                        if($view['section'] == 'file_status')
                        {
                            include_once'email_lookup_file_status.php';
                        }     

                        
                        if($view['section'] == 'instant_lookup')
                        {
                            include_once'instant_lookup.php';
                        }     

                        
                        if($view['section'] == 'report_instant_lookup')
                        {
                            include_once'report_instant_lookup.php';
                        }     

                        if($view['section'] == 'package_stripe_form')
                        {
                            include_once'package_stripe_form.php';
                        }  

                        if($view['section'] == 'buy_credit')
                        {
                            include_once'buy_credit.php';
                        }     

                        if($view['section'] == 'report_credit_expense')
                        {
                            include_once'report_credit_expense.php';
                        }

                        if($view['section'] == 'report_credit_expense_by_date')
                        {
                            include_once'report_credit_expense_by_date.php';
                        }

                        if($view['section'] == 'report_credit_buy')
                        {
                            include_once'report_credit_buy.php';
                        }

                        if($view['section'] == 'report_credit_buy_by_date')
                        {
                            include_once'report_credit_buy_by_date.php';
                        }

                         if($view['section'] == 'report_daily_limit_expense')
                        {
                            include_once'report_daily_limit_expense.php';
                        }

                        if($view['section'] == 'report_daily_limit_expense_by_date')
                        {
                            include_once'report_daily_limit_expense_by_date.php';
                        }

                        if($view['section'] == 'report_package_buy')
                        {
                            include_once'report_package_buy.php';
                        }

                        if($view['section'] == 'report_package_buy_by_date')
                        {
                            include_once'report_package_buy_by_date.php';
                        }

                        if($view['section'] == 'report_invoice')
                        {
                            include_once'report_invoice.php';
                        }
                        if($view['section'] == 'report_invoice_by_date')
                        {
                            include_once'report_invoice_by_date.php';
                        }
                        

                        if($view['section'] == 'api_lookup_file')
                        {
                            include_once'api_lookup_file.php';
                        }
                        if($view['section'] == 'api_download_lookup_file')
                        {
                            include_once'api_download_lookup_file.php';
                        }
                        if($view['section'] == 'api_numbers_lookup')
                        {
                            include_once'api_numbers_lookup.php';
                        }
                        if($view['section'] == 'api_lookup_file_status')
                        {
                            include_once'api_lookup_file_status.php';
                        }
                        
                        if($view['section'] == 'pricing_contact_us')
                        {
                            include_once'pricing_contact_us.php';
                        }
                        



                        ?>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2016 &copy; Verify Rocket.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        
        <!-- END THEME LAYOUT SCRIPTS -->
        <?php require_once("includes/footer.php");?>
    </body>

</html>