<div class="row">

	<div class="col-xs-12">
		<div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Look up 
                </div>
            </div>
            <div class="portlet-body" id="group_list">
	            <div class="row">
	            	<div class="col-xs-12">
                        <form id="instant_check_form">
                            <textarea  class="col-xs-12 col-md-9" id="instant_check_field" onkeyup="instant_check_field_validation()" placeholder="Write Numbers here . . . Example (19419622134,12022002994)"></textarea>
                            <div class="col-xs-12 col-md-3 nopadding text-right"><button  type="submit" class="btn dark col-xs-12 instant_check_btn" id="">Check</button></div>
                        </form>
                    </div>
                    <div class="col-xs-12" id="set_invalid_numbers"></div>
                    <p>&nbsp;</p>
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
    	<p>&nbsp;</p>
    </div>

</div>