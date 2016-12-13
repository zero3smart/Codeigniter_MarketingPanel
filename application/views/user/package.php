<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/pages/css/pricing.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #btn-stripe{font-size:30px;margin-top:30px;margin-bottom:30px;border-radius:5px !important;}
    .teal-blue{background:#68a3a5 !important;border-color:#68a3a5 !important;}
    .bg-teal-blue{background:#68a3a5 !important;}
    .btn.teal-blue{color:#fff !important;}

    /*.font-teal-blue{color:;}
    .border-teal-blue{border-color:;}*/
    .border-top-teal-blue{border-top-color:#68a3a5 !important;}

    .price-column-container.column-red i{color:#e7505a !important;}
    .price-column-container.column-teal-blue i{color:#68a3a5 !important;}
</style>
                  
                    <?php 
                    if($view['buy'] == 2)
                    {
                        if($view['msg'] != "" ) 
                            echo msg($view['msg'],$view['msg_type']); 
                    }
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-green"></i>
                                        <?php
                                            if($view['buy'] == 1)
                                            {
                                                echo '<span class="caption-subject font-green bold uppercase">Payment Successfull</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="caption-subject font-green bold uppercase">SELECT YOUR PACKAGE</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="pricing-content-1">

                                        <div class="row">
                                        <?php
                                            //$view['msg_type'] = 'success';
                                            if($view['buy'] == 1)
                                            {
                                                $current_package = $this->Mdl_user->fetch_current_package();
                                                $packname = $this->Mdl_user->fetch_package_single($current_package['package_id']);
                                                echo '
                                                   <div class="col-xs-12 text-center" style="font-size:250%;font-weight:bold;color:#32c5d2 ;"><p>&nbsp;</p><p>&nbsp;</p><p>Thank you for buying package <span style="color:#703688;">'.$packname['packname'].'</span>.<br>Now Your daily limit is <span style="color:#703688;">'.$current_package['daily_limit'].'</span> credit.</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></div>
                                                ';
                                            }

                                            else
                                            {
                                             

                                        ?>
                                            <?php $i=1; foreach ($package_document as $package_document_key => $package_document_value) {
                                                
                                                if(isset($package_document_value['featured']))
                                                {

                                                     $color = 'red';
                                                }
                                                else
                                                {
                                                    $color = 'teal-blue';
                                                }
                                                
                                            echo '
                                            <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom:30px;">
                                                <div class="price-column-container column-'.$color.'  border-active">
                                                    <div class="price-table-head bg-'.$color.'">
                                                        <h2 class="no-margin">'.$package_document_value['packname'].'</h2>
                                                    </div>
                                                    <div class="arrow-down border-top-'.$color.'"></div>
                                                    <div class="price-table-pricing">
                                                        <p>&nbsp;</p>
                                                        <h3>$'.$package_document_value['price'].'</h3>
                                                        <p>&nbsp;</p>
                                                    </div>
                                                    <div class="price-table-content">
                                                        <div class="row mobile-padding">
                                                            <div class="col-xs-3 text-right mobile-padding">
                                                                <i class="fa fa-database"></i>
                                                            </div>
                                                            <div class="col-xs-9 text-left mobile-padding">Price $'.$package_document_value['price'].'</div>
                                                        </div>
                                                        <div class="row mobile-padding">
                                                            <div class="col-xs-3 text-right mobile-padding">
                                                                <i class="fa fa-database"></i>
                                                            </div>
                                                            <div class="col-xs-9 text-left mobile-padding">Daily Limit '.$package_document_value['credit'].'</div>
                                                        </div>
                                                        <div class="row mobile-padding">
                                                            <div class="col-xs-3 text-right mobile-padding">
                                                                <i class="fa fa-database"></i>
                                                            </div>
                                                            <div class="col-xs-9 text-left mobile-padding">Monthly Rate</div>
                                                        </div>

                                                    </div>
                                                    <div class="arrow-down arrow-grey"></div>
                                                    <div class="price-table-footer">
                                                        <a class="btn '.$color.' price-button sbold uppercase"  href="'.base_url().'buy_package/'.$package_document_value['_id'].'">Buy</a>
                                                    </div>
                                                </div>
                                            </div>
                                                ';
                                                     
                                            }
                                        }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            
                        <h2 class="text-center">Need more volume? <a href="#pricing_contact_us_modal" data-toggle="modal">Contact us</a> for Pricing</h2>
                        </div>
                    </div>




                                
                                    <!--<div id="responsive" class="modal fade" tabindex="-1" data-width="760">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Choose Payment Method</h4>
                                        </div>
                                        <div class="modal-body payment_method_body">
                                            <div class="row text-center">
                                                
                                                    <div class='web'>
<form action="<?php echo base_url('Stripe_payment/checkout');?>" method="POST">
<script src="https://checkout.stripe.com/checkout.js"
class="stripe-button"
data-key="pk_test_7YiSRN3rqjJFgJRayV27yzwS"
data-image="<?php echo base_url();?>assets/user/images/textingFireSMS_Logo2.png"
data-name="w3code.in"
data-description="Demo Transaction ($100.00)"
data-amount="10000" />
</script>
<input id="package_id_stripe" type="hidden" name="package_id" value=""></input>
<input id="package_price_stripe" type="hidden" name="package_price" value="100"></input>
<input id="" type="hidden" name="stripeToken" value="1"></input>
</form>
</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                                        </div>
                                    </div>-->

<div id="credit_top_up_modal" class="modal fade" tabindex="-1" data-width="760">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Payment Confirmation</h4>
                                        </div>
                                        <div class="modal-body payment_method_body">
                                            <div class="row text-center">
                                                
                                                <div class="col-xs-12" id="" >
                                                    <h4 class="col-xs-12 text-center">Package Name :  <span id="package_name"></span></h4>
                                                </div>

                                                <div class="col-xs-12" id="" >
                                                    <h4 class="col-xs-12 text-center">Package Price : $ <span id="package_price"></span></h4>
                                                </div>

                                                
                                                <div class="col-xs-12" id="" >
                                                    <h4 class="col-xs-12 text-center">Total Credits : <span id="package_credit"></span></h4>
                                                </div>



                                                <div class="col-xs-12 nopadding" id="payment_button_group">
                                                  <!--<div class="col-xs-6 text-right">
                                                    <a class="fa fa-cc-paypal" href="" data-href="<?php echo base_url();?>buy_credit/" id="top_up_paypal_link"></a>
                                                  </div>-->
                                                  <div class="col-xs-12 text-center">
                                                    <div class='web'>
                                                      <form id="stripe_submit_form" action="<?php echo base_url('Stripe_payment/checkout');?>" method="POST">
                                                      <script src="https://checkout.stripe.com/checkout.js"/></script>
                                                      <a class="btn btn-primary" id="btn-stripe"> &nbsp;  &nbsp;  &nbsp; <i class="fa fa-shopping-cart"></i> Pay &nbsp;  &nbsp;  &nbsp; </a>
                                                      <input id="package_id" type="hidden" name="package_id" value="">
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                                        </div>
                                    </div>




    <div id="pricing_contact_us_modal" class="modal fade" tabindex="-1" data-width="760">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Contact Us</h4>
        </div>
        <div class="modal-body payment_method_body" >
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2" style="padding-bottom:30px;">
                    <form action="<?php echo base_url();?>pricing_contact_us" method="post">
                        <div class="form-group">
                            <h3 class="text-center">Please provide details on how we can help.</h3>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="requirement" style="min-height:250px;resize:vertical;"></textarea>
                        </div>   
                        <div class="form-group">    
                            <button class="btn blue btn-block" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>