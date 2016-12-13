<style type="text/css">
    #btn-stripe{font-size:30px;margin-top:30px;margin-bottom:30px;border-radius:5px !important;}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Custom Pricing Contact</span>                                    </div>
            </div>
            <div class="portlet-body">
                <div class="pricing-content-1">

                    <div class="row">
                    <?php if($view['msg_type'] == true){
                        echo '
                             <div class="col-xs-12 text-center" style="font-size:250%;font-weight:bold;color:#32c5d2 ;"><p>&nbsp;</p><p>&nbsp;</p><p>'.$view['msg'].'</p><p>&nbsp;</p><p>&nbsp;</p></div>
                        ';
                    }
                    else{
                        echo '
                             <div class="col-xs-12 text-center" style="font-size:250%;font-weight:bold;color:#e7505a ;"><p>&nbsp;</p><p>&nbsp;</p><p>'.$view['msg'].'</p><p>&nbsp;</p><p>&nbsp;</p></div>
                        ';
                    }

                     ?>
                              
                </div>
            </div>
        </div>
    </div>
</div>