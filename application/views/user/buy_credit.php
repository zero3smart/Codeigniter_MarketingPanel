<style type="text/css">
    .container {
        padding: 20px;
    }

    .payment_form_box { /*box-shadow:0px 0px 5px rgba(0,0,0,.8),0px 0px 50px rgba(0,0,0,.2) inset;*/
        background: #fff;
        padding: 35px 25px 0 25px;
    }

    .table td {
        vertical-align: middle;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.js"></script>
<script type="text/javascript">
    function changePrice() {
        var package = document.getElementById("package");
        var price_during_buy = document.getElementById('price_during_buy');
        var total_price = document.getElementById('total_price');
        var credit_count = document.getElementById('credit_count');
        var selectedPrice = package.options[package.selectedIndex].value;
        var selectedCredits = 0;
        switch (selectedPrice) {
            case '47':
                selectedCredits = 50000;
                break;
            case '97':
                selectedCredits = 100000;
                break;
            case '247':
                selectedCredits = 250000;
                break;
            case '497':
                selectedCredits = 500000;
                break;
            case '997':
                selectedCredits = 1000000;
                break;
            case '2497':
                selectedCredits = 2500000;
                break;
            case '4997':
                selectedCredits = 5000000;
                break;
            default:
                selectedCredits = 50000;
                break;
        }
        price_during_buy.textContent = selectedPrice;
        total_price.value = selectedPrice;
        credit_count.value = selectedCredits;
    }
    
    $(document).ready(function(){
        changePrice();
        $('select[name=payment_type]').change(function(){
                var tval = $(this).val();
                var $form = $('#payment-form');
                if(tval == 'stripe')
                {
                    $('.hide_stripe').css('display','');
                    $('.hide_paypal').css('display','none');
                    $form.attr('action','<?php echo base_url(); ?>Stripe_payment/checkout_buy_credit');
                }else if(tval == 'paypal')
                {
                    $('.hide_paypal').css('display','');
                    $('.hide_stripe').css('display','none');
                    $form.attr('action','<?php echo base_url(); ?>paypal_payment/checkout_buy_credit');
                }
          });
          
          $('button.paypal_submit').click(function(){
                var $form = $('#payment-form');
                // Submit the form:
	           $form.get(0).submit();
          });
    });
</script>

<?php
if ($view['buy'] == 2) {
    if ($view['msg'] != "")
        echo msg($view['msg'], $view['msg_type']);
}
?>
<div class="row">
    <?php
    if ($view['buy'] == 1) {
        echo '
                                                <div class="col-xs-12">
                                                <div class="col-xs-12 payment_form_box">
                                                   <div class="col-xs-12 text-center" style="font-weight:bold;color:#32c5d2 ;">
                                                   <p>&nbsp;</p>
                                                   <p>&nbsp;</p>
                                                   
                                                   <h1 style="font-size:300% !important;font-weight:bold;">Thank You!</h1>
                                                   <h4 style="font-size:150% !important;" ><span style="color:#703688;">' . $view['credit'] . '</span>  Credits Added to your Account.</h4>
                                                   <h4 style="font-size:150% !important;">Your current Credit Balance is <span style="color:#703688;">' . $dash_profile['balance'] . '</span>.</h4>
                                                   <p>&nbsp;</p>
                                                   <p>&nbsp;</p>
                                                   <p>&nbsp;</p>
                                                   <p>&nbsp;</p>
                                                   <p>&nbsp;</p>
                                                   </div>
                                                </div>
                                                </div>
                                                ';
    } else {


        ?>
        <div class="col-xs-12 col-md-6 col-md-offset-3 payment_form_box">
            <form action="<?php echo base_url(); ?>Stripe_payment/checkout_buy_credit" method="POST" id="payment-form">
                <input type="hidden" name="total_price" id="total_price" value="0" />
                <input type="hidden" name="credit_count" id="credit_count" value="0" />
                <div style="margin-bottom:15px;"><span style="color:red;" class="payment-errors"></span></div>
                <table class="table">
                    <!--<tr>
			   			<td>Price per Credit</td>
			   			<td colspan="2"><?php /*echo $dash_profile['price_per_credit']; */
                    ?></td>
			   		</tr>
			   		<tr>
			   			<td>Credit</td>
			   			<td colspan="2"><input class="form-control" id="get_credit_count" type="number" name="credit_count" onkeyup="set_total_price_during_buy(<?php /*echo $dash_profile['price_per_credit']; */
                    ?>,this.value)"></td>
			   		</tr>-->
                    <tr>
                        <td>
                            Credit
                        </td>
                        <td colspan="2">
                            <select id="package" name="package" onchange="changePrice()">
                                <option value="47" selected>50K</option>
                                <option value="97">100K</option>
                                <option value="247">250K</option>
                                <option value="497">500K</option>
                                <option value="997">1mm</option>
                                <option value="2497">2.5mm</option>
                                <option value="4997">5mm</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td colspan="2">$ <span id="price_during_buy">47</span></td>
                    </tr>
                    
                    <tr>
			   			<td><span>Payment type</span></td>
			   			<td colspan="2">
						   <select id="payment_type" name="payment_type">
                                <option value="stripe" selected="">Credit Card</option>
                                <option value="paypal">Paypal</option>
                            </select>
			   			</td>
			   		</tr>   

                    <tr class="hide_stripe">
                        <td><span>Card Number</span></td>
                        <td colspan="2">
                            <div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-credit-card"></span>
                                                       </span>
                                <input class="form-control" type="text" size="20" name="card_number"
                                       data-stripe="number" value="">
                            </div>
                        </td>
                    </tr>
                    <tr class="hide_stripe">
                        <td><span>Expiration (MM/YY)</span></td>
                        <td>
                            <div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar-o"></span>
                                                       </span>
                                <input class="form-control" type="text" placeholder="MM" data-stripe="exp_month"
                                       value="">
                            </div>
                        </td>
                        <td><input class="form-control" type="text" placeholder="YY" data-stripe="exp_year" value="">
                        </td>
                    </tr>
                    <tr class="hide_stripe">
                        <td><span>CVC</span></td>
                        <td colspan="2">
                            <div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-lock"></span>
                                                       </span>
                                <input class="form-control" type="text" data-stripe="cvc" value="">
                            </div>
                        </td>
                    </tr>
                    <tr class="hide_stripe">
                        <td colspan="3">
                            <button type="submit" class="col-xs-12 btn btn-lg green submit"><i
                                        class="fa fa-shopping-cart"></i> Pay
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hide_paypal" style="display: none;">
			   			<td colspan="3"><button type="button" class="col-xs-12 btn btn-lg green paypal_submit"><i class="fa fa-shopping-cart"></i> Pay</button></td>
			   		</tr>
                    
                    <tr>
                        <td colspan="3">
                            <img class="col-xs-12" style="padding:0;"
                                 src="<?php echo base_url(); ?>assets/user/images/credit-cards.png">
                        </td>
                    </tr>


                </table>
            </form>
        </div>
    <?php } ?>
</div>
