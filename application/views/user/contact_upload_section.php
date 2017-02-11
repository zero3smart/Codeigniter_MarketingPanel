<?php 
  /*    app.snapiq.com/application/view/user/contact_upload_section     */
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url();?>assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
        .drop_area{background:transparent;transition:.5s;box-shadow: 0px 0px 0px rgba(0,0,0,.5),0px 0px 0px rgba(0,0,0,.1) inset;}
        .drop_area:hover,.drop_area.mouse-over:hover{background:rgba(3,167,214,.1);transition:.5s;box-shadow: 0px 0px 10px rgba(0,0,0,.2),0px 0px 50px rgba(0,0,0,.01) inset;}
        .drop_area.mouse-over{background:rgba(3,167,214,.3);transition:.5s;box-shadow: 0px 0px 10px rgba(0,0,0,.5),0px 0px 50px rgba(0,0,0,.03) inset;}
        #instant_check_field{height:40px !important;margin-top:1px !important;border:none;background:#e4eaf1 !important;color:#6c7784 !important;}
        .instant_check_btn{height:40px !important;margin-top:1px !important;}
        .search-bar {padding: 0 15px !important;margin-bottom:0 !important;}
        #instant_check_field_respose_con{margin-top:15px !important;}
        </style>
        <!-- END PAGE LEVEL PLUGINS -->
        <?php 
                    
                        if($view['msg'] != "" ) 
                            echo msg($view['msg'],$view['msg_type']); 
                    
                    ?>
<div class="row">

    <div class="col-xs-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div id="button_collapse" class="scrub-status-container expanded-button" onclick="toggleCollapse('file_process_progress', 'button_collapse')">&nbsp;</div>
                <div class="caption">
                    <i class="fa fa-globe"></i>Validating Files
                </div>
            </div>
            <div class="portlet-body" id="group_list" style="height: 150px;overflow: auto;">
                <div class="row">
                    <div class="col-xs-12 nopadding file_progress_row_all" id="file_process_progress" style="display: block"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Spamtrap Lookup 
                </div> 
            </div>
            <div class="portlet-body" id="group_list">
                <div class="row">
                    <!--<div class="col-xs-12">
                        <form id="instant_check_form" action="<?php echo base_url();?>sendInstantCheckupRequest" method="post">
                            <input  class="col-xs-12 col-md-9"  id="instant_check_field" name="email" type="email" placeholder="Enter email . . . (Example1@domain.com)">
                            <div class="col-xs-12 col-md-3 nopadding text-right"><button   type="submit" class="btn dark col-xs-12 instant_check_btn" id="">Check</button></div>
                        </form>
                    </div>-->
                    <div class="search-page search-content-2  nopadding">
                    <div class="search-bar">
                        <div class="row">
                            <div class="col-md-12">
                                <!--<form id="instant_check_form" action="<?php /*echo base_url();*/?>sendInstantCheckupRequest" method="post">-->
                                <form id="instant_check_form" action="http://205.134.243.198:3001/search" method="GET">
                                <div class="input-group">
                                    <input type="email" id="instant_check_field" required name="email" class="form-control" placeholder="Enter email . . . (Example1@domain.com)">
                                    <span class="input-group-btn">
                                        <button class="btn dark bold instant_check_btn submit_btn" type="submit">CHECK</button>
                                    </span>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-xs-12" id="set_invalid_numbers"></div>
                    
                    <div class="col-xs-12">
                    <div class="col-xs-12" id="instant_check_field_respose_con">
                        <div class="col-xs-12 col-sm-4" id="">
                            <h4 style="color:#27a4b0">Request</h4>
                            <div id="instant_check_field_request" style="word-break:break-all;"></div>
                        </div>
                        <div class="col-xs-12  col-sm-8" id="">
                            <h4 style="color:#27a4b0;padding-left:30px;">Response</h4>
                            <pre id="instant_check_field_response"></pre>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
                        <div class="col-xs-12" >
                            <h3 class="page-title" style="margin-top:20px;margin-bottom:30px;"> File Upload
                                <small></small>
                                <a class="btn red pull-right" href="<?php echo base_url();?>failed_file_delete">Clear Failed Upload</a>
                            </h3>
                            <form class="" id="contact_upload_form<?php //if($dash_profile['username'] == 'mohiolmis') echo 'contact_upload_for'; else echo 'contact_upload_form'; ?>" action="<?php echo base_url();?>upload_file" method="POST" enctype="multipart/form-data">
                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                <div class="col-xs-12 nopadding fileupload-buttonbar">
                                    <!--<div class="col-xs-12 text-center" style="font-size:130%;color:red;margin-bottom:20px;">
                                        Email should be present at first column in CSV file.
                                    </div> -->
                                    <div class="col-xs-12">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <!--<span class="btn green fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span> Browse File... </span>
                                            <input name="contactfile" id="contact_upload_file" onchange="fn_contact_upload_file_name_set(event)"  type="file" accept=".csv"> 
                                        </span>-->
                                        
                                        <!--[if !IE]>-->

                                        <div id="drop-zone" class="drop_area">
                                            <span style="font-size:16px">Drag CSV or TXT file with email addresses here to upload and begin list verification.</span><br>or
                                            
                                            <div  id="clickHere">
                                                <i class="fa fa-plus"></i>
                                                <span> Browse File... </span>
                                                <input name="contactfile" id="contact_upload_file" onchange="fn_contact_upload_file_name_set(event)"  type="file" accept=".txt,.csv">
                                            </div>
                                        </div>
                                        <!--<![endif]-->
                                            
                                        <!--<button type="reset" class="btn warning cancel">
                                            <i class="fa fa-ban-circle"></i>
                                            <span> Cancel upload </span>
                                        </button>
                                        <button type="button" class="btn red delete">
                                            <i class="fa fa-trash"></i>
                                            <span> Delete </span>
                                        </button>
                                        <input class="toggle" type="checkbox">
                                        <span class="fileupload-process"> </span>-->
                                    </div>
                                    <!-- The global progress information -->
                                    <div class="col-lg-5 fileupload-progress fade">
                                        <!-- The global progress bar -->
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
                                        </div>
                                        <!-- The extended global progress information -->
                                        <div class="progress-extended"> &nbsp; </div>
                                    </div>
                                    <!--<div class="col-xs-12">
                                        <div class="form-group col-xs-12">
                                            <div class="col-xs-12 col-md-6 col-lg-4" style="padding-left:0">
                                                <label>Split at :</label>
                                                <input type="number" class="form-control" name="split_at" required min="1">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input id="radio6" name="clean_up_status" class="md-radiobtn" value="true"  type="radio">
                                                    <label for="radio6">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Upload with Clean Up </label>
                                                </div>
                                                <div class="md-radio">
                                                    <input id="radio7" name="clean_up_status" class="md-radiobtn" value="false" checked  type="radio">
                                                    <label for="radio7">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Upload <strong>without</strong> Clean Up </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                </div>
                                <!-- The table listing the files available for upload/download -->
                                <div class="col-xs-12 " style="display:none;" id="show_contacts_status_at_file">
                                    <!--<h4 style="margin:20px 0;"><span id="suggetion_part"></span>
                                    <div class="col-xs-12" style="margin:20px 0;" >
                                        <div class="col-xs-6 text-right">
                                            <span id="command_part"></span>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="number" required value="" name="column_number" class="form-control col-xs-12" id="set_column_number">
                                        </div>
                                        <div class="col-xs-3 text-left">
                                            <a class="btn yellow" href="#" id="get_column_number" onclick="fn_contact_upload_file()">Change</a>
                                        </div>
                                        <div class="col-xs-12 text-center" style="margin:20px 0;">
                                            <span id="balance_deduction_part"></span>
                                        </div>



                                    </div>
                                    <table class="table_all_center table table-bordered table-striped table-condensed flip-content">
                                        <tbody>
                                            <tr><td colspan="3">
                                                <span id="suggetion_part"></span>
                                            </td></tr>
                                            <tr>
                                                <td><span id="command_part"></span></td>
                                                <td>
                                                <input type="number" required value="" name="column_number" class="form-control col-xs-12" id="set_column_number">
                                                <input value="1" name="column_number_2" type="hidden" id="set_column_number_2">
                                                </td>
                                                <td class="text-right"><a class="btn yellow" href="#" id="get_column_number" onclick="fn_contact_upload_file()">Change</a></td>
                                            </tr>
                                            <tr><td colspan="3" ><span id="balance_deduction_part"></span></td></tr>
                                        </tbody>

                                    </table>-->
                                    <div class="note note-success col-xs-12" style="margin:0;">
                                       
                                            <span id="suggetion_part"></span>
                                       
                                    </div>
                                    <div class="note note-danger col-xs-12" style="margin:0;">
                                        <div class="col-xs-12" style="padding:0;">
                                            <div class="col-xs-6" style="padding:0;margin-top:7px;">
                                                <span id="command_part"></span>
                                            </div>
                                            <div class="col-xs-3">
                                            <input type="number" required value="" name="column_number" class="form-control col-xs-12" id="set_column_number">
                                                <input value="1" name="column_number_2" type="hidden" id="set_column_number_2">
                                            </div>
                                            <div class="col-xs-3 text-left">
                                                <a class="btn yellow" href="#" id="get_column_number" onclick="fn_contact_upload_file()">Change</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="note note-danger col-xs-12" style="margin:0;">
                                        <div class="col-xs-12" style="padding:0;">
                                            <div class="col-xs-6" style="padding:0;margin-top:7px;">
                                                <span>This file contains header</span>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="checkbox" name="header" value="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="note note-warning  col-xs-12" style="margin:0;">
                                            <span id="balance_deduction_part"></span>
                                        
                                    </div>


                                </div>

                                <div class="col-xs-12 show_file_upload_button text-center" style="display:none;margin:20px 0 30px 0;">
                                    <input id="set_csv_files_total_row" type="hidden" readonly required name="csv_files_total_row">
                                    <button type="submit" class="btn btn-lg blue start" style="padding:15px 50px;">
                                            <i class="fa fa-upload"></i>
                                            <span> Start upload </span>
                                        </button>
                                </div>
                                <div class="col-xs-12 nopadding file_details" style="display:none;margin-bottom:20px;">
                                    <div class="col-xs-3 word_wrap" style="font-weight:bold" id="contact_upload_file_name_set"></div>
                                    <div class="col-xs-3 word_wrap" style="font-weight:bold" id="contact_upload_file_size_set"></div>
                                    <div class="col-xs-6">
                                        <div class="progress">
                                          <div class="progress-bar progress-bar-success progress-bar-striped " role="progressbar"
                                          aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 nopadding get_data_from_csv_file_container" style="display:none;">

                                    <div class="portlet box purple">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                Sample Data from Your CSV File
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-scrollable" id="get_data_from_csv_file">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </form>
                            

                            <style type="text/css">
                            .file_progress_wrapper{position:relative;float:left;left:50%;margin-left:-175px;width:350px;height:150px;border-bottom:3px solid #0E848E !important;overflow:hidden;}
                            .file_progress_con{position:absolute;float:left;left:50%;width:300px;margin-left:-150px;height:300px;border:0px solid #000;}
                            .file_progress_up{overflow:hidden;position:absolute;float:left;left:0;top:0;width:100%;height:150px;}
                            .file_progress_down{transition:1s;transform:rotate(0deg);transform-origin: 50% 0%;overflow:hidden;position:absolute;float:left;left:0;top:150px;width:100%;height:150px;border:0px solid #000;}
                            .file_progress_up .file_progress_circle,.file_progress_down .file_progress_circle{position:absolute;float:left;left:0;width:100%;height:300px;border-radius:100% !important;}
                            .file_progress_up .file_progress_circle{top:0;background:#fff;border:3px solid #26a1ab;}
                            .file_progress_down .file_progress_circle{top:-150px;background:#26a1ab;box-shadow:0px 0px 30px rgba(0,0,0,.5) inset;}
                            
                            /*.file_progress_wrapper:hover .file_progress_down{transition:2s;transform:rotate(180deg);transform-origin: 50% 0%;}*/
                            
                            .inner_circle{position:absolute;float:left;left:50%;top:50%;width:200px;height:200px;margin-top:-100px;margin-left:-100px;background:#eef1f5;border-radius:100% !important;border:3px solid #26a1ab;z-index:10;}
                            #file_progress_circle{font-size:300%;text-align:center;padding-top:40px;}
                            .file_progress_row{margin-bottom:50px;overflow: hidden;box-shadow:0px 0px 30px rgba(0,0,0,.1) inset;}
                            .file_progress_row .file_data{text-align:center;font-size:100%;}

                            .file_progress_row .icon{font-size:60px;border:none;color:rgba(0,0,0,1);text-align: center;}
                            .file_progress_row .icon span{margin-right:40px;line-height:60px;}
                            @media(min-width:768px)
                            {
                                .file_progress_row .icon{text-align: right;}
                               .file_progress_row .file_data{font-size:110%;text-align:left;} 
                            }
                            @media(min-width:992px)
                            {
                               .file_progress_row .file_data{font-size:110%;text-align:left;} 
                            }
                            @media(min-width:1200px)
                            {
                               .file_progress_row .file_data{font-size:130%;text-align:left;} 
                            }

                            </style>
                            <!--<div class="col-xs-12 nopadding file_progress_row_all" id="file_process_progress">



                            </div>-->
                            <div class="col-xs-12"  >
                            <p>&nbsp;</p>
                            </div>
                            <div class="col-xs-12 nopadding">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Notes</h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul>
                                            <!--<li> The maximum file size for uploads is
                                                <strong>16 MB</strong> .
                                            </li>-->
                                            <li> Only files (
                                                <strong>CSV, TXT</strong>) are allowed. 
                                            </li>
                                            <li>Max File Upload is 50 MB</li>
                                            <li>Contact support if you require help with a larger file</li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


