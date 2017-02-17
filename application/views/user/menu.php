<ul class="page-sidebar-menu  page-header-fixed  " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <!--<li class="nav-item start active open">
                            <a class="nav-link nav-toggle" href="javascript:;">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start active open">
                                    <a class="nav-link " href="index.html">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard 1</span>
                                        <span class="selected"></span>
                                    </a>n
                                </li>
                                <li class="nav-item start ">
                                    <a class="nav-link " href="dashboard_2.html">
                                        <i class="icon-bulb"></i>
                                        <span class="title">Dashboard 2</span>
                                        <span class="badge badge-success">1</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a class="nav-link " href="dashboard_3.html">
                                        <i class="icon-graph"></i>
                                        <span class="title">Dashboard 3</span>
                                        <span class="badge badge-danger">5</span>
                                    </a>
                                </li>
                            </ul>
                        </li>-->

    <li class="nav-item menu_dashboard">
        <a class="nav-link nav-toggle" href="<?php echo base_url(); ?>dashboard">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
        </a>                 
    </li>
    <li class="nav-item menu_profile">
        <a class="nav-link nav-toggle" href="<?php echo base_url(); ?>profile">
            <i class="icon-user"></i>
            <span class="title">Profile</span>
        </a>                 
    </li>
    
    <li class="nav-item menu_contact">
        <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-upload"></i>
            <span class="title">Process Data</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item submenu_contact_upload_section">
                <a class="nav-link " href="<?php echo site_url('contact_upload'); ?>">
                    <i class="fa fa-upload"></i>
                    <span class="title">Email Validation</span>
                </a>
            </li>
            <li class="nav-item submenu_email_verification_section">
                <a class="nav-link " href="<?php echo site_url('email_verification'); ?>">
                    <i class="fa fa-envelope"></i>
                    <span class="title">Email Verification</span>
                </a>
            </li>                                                            
            <li class="nav-item submenu_phone_upload_section">
                <a class="nav-link " href="<?php echo site_url('phone_upload'); ?>">
                    <i class="fa fa-search"></i>
                    <span class="title">Carrier Lookup</span>
                </a>
            </li>
            
            <li class="nav-item submenu_data_append_section">
                <a class="nav-link " href="<?php echo site_url('data_append'); ?>">
                    <i class="fa fa-search"></i>
                    <span class="title">Data Append</span>
                </a>
            </li>                        

        </ul>
    </li>
    
    <!--<li class="nav-item menu_instant_lookup">
        <a class="nav-link nav-toggle" href="<?php echo base_url(); ?>instant_lookup">
            <i class="fa fa-search"></i>
            <span class="title">Instant Lookup</span>
        </a>                 
    </li>-->
    <li class="nav-item menu_store">
        <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-database"></i>
            <span class="title">Purchase Credit</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item submenu_packages">
                <a class="nav-link " href="<?php echo base_url(); ?>packages">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Monthly Package</span>
                </a>
            </li>
            <li class="nav-item submenu_buy_credit">
                <a class="nav-link " href="<?php echo base_url(); ?>buy_credit">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Pay as you go</span>
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-item menu_report">
        <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-file-text-o"></i>
            <span class="title">Reports</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item submenu_file_upload_status">
                <a class="nav-link" href="<?php echo base_url(); ?>report/file_upload_status">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Cleaned Files</span>
                </a>
            </li>
            <li class="nav-item submenu_file_upload_status">
                <a class="nav-link" href="<?php echo base_url(); ?>report/failed_upload">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Failed Upload</span>
                </a>
            </li>
            <li class="nav-item submenu_report_instant_lookup">
                <a class="nav-link" href="<?php echo base_url(); ?>report/instant_lookup">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Instant Lookup</span>
                </a>
            </li>
            
            <li class="nav-item submenu_report_invoice">
                <a class="nav-link" href="<?php echo base_url(); ?>report/invoice">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Invoices</span>
                </a>
            </li>
            <li class="nav-item submenu_report_credit_buy">
                <a class="nav-link" href="<?php echo base_url(); ?>report/credit/buy">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Credit Purchases</span>
                </a>
            </li>
            <li class="nav-item submenu_report_credit_expense">
                <a class="nav-link" href="<?php echo base_url(); ?>report/credit/expense">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Credit Usage</span>
                </a>
            </li>
            <li class="nav-item submenu_report_package_buy">
                <a class="nav-link" href="<?php echo base_url(); ?>report/package/buy">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Package Purchases</span>
                </a>
            </li>
            <li class="nav-item submenu_report_daily_limit_expense">
                <a class="nav-link" href="<?php echo base_url(); ?>report/daily_limit/expense">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Daily Limit Expense</span>
                </a>
            </li>


            
            

        </ul>
    </li>
    <li class="nav-item menu_api">
        <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-file-text-o"></i>
            <span class="title">API</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item submenu_api_lookup_file">
                <a class="nav-link" href="<?php echo base_url(); ?>api/lookup_file">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Lookup FIle</span>
                </a>
            </li>
            <li class="nav-item submenu_api_download_lookup_file">
                <a class="nav-link" href="<?php echo base_url(); ?>api/download_lookup_file">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Download Lookup FIle</span>
                </a>
            </li>
            <li class="nav-item submenu_api_numbers_lookup">
                <a class="nav-link" href="<?php echo base_url(); ?>api/email_lookup">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Email Lookup</span>
                </a>
            </li>
            <li class="nav-item submenu_api_lookup_file_status">
                <a class="nav-link" href="<?php echo base_url(); ?>api/lookup_file_status">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Lookup File Status</span>
                </a>
            </li>


        </ul>
    </li>



</ul>


<!--<div class="hor-menu">
                        <ul class="nav navbar-nav">
                            <li class="menu-dropdown classic-menu-dropdown menu_dashboard">
                                <a href="<?php echo base_url(); ?>dashboard"> Dashboard
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown menu_contact_upload_section">
                                <a href="<?php echo base_url(); ?>contact_upload_section"> Lookup Check
                                    <span class="arrow"></span>
                                </a>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown menu_instant_lookup">
                                <a href="<?php echo base_url(); ?>instant_lookup"> Instant Lookup
                                    <span class="arrow"></span>
                                </a>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown   menu_store">
                                <a href="javascript:;"> Credit
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li class="submenu_packages">
                                        <a href="<?php echo base_url(); ?>packages" class="nav-link  "> Purchase </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown   menu_report">
                                <a href="javascript:;"> Report
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li class="submenu_expense">
                                        <a href="<?php echo base_url(); ?>report/expense" class="nav-link  "> Expense </a>
                                    </li>
                                    <li class="submenu_file_upload_status">
                                        <a href="<?php echo base_url(); ?>report/file_upload_status" class="nav-link  "> Lookup Statics </a>
                                    </li>
                                    <li class="submenu_report_instant_lookup">
                                        <a href="<?php echo base_url(); ?>report/instant_lookup" class="nav-link  "> Instant Lookup </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>

                    </div>
                    -->