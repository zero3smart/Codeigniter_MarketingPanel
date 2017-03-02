<!-- BEGIN PAGE LEVEL PLUGINS -->
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
{
    echo msg($view['msg'],$view['msg_type']); 
}
?>

<div class="row">
    
    <div class="col-xs-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Email Append
                </div> 
            </div>
            <div class="portlet-body" id="group_list">
                <div class="row">
                    <div class="search-page search-content-2  nopadding">
                    <div class="search-bar">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="instant_check_form" action="http://205.134.243.198:3001/search" method="GET">
                                    <div class="input-group">
                                        <input type="email" id="instant_check_field" required name="email" class="form-control" placeholder="Enter email . . . (Example1@domain.com)" />
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
</div>