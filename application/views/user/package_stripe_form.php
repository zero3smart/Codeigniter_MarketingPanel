
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">
	    //Stripe.setPublishableKey('pk_test_wRl9xX9XsOj1fUSwzsebPV05'); //Test Publishable Key
	    Stripe.setPublishableKey('pk_live_oPE2lWuZcUJy3DNDAIh6aPvU'); //Live Publishable Key
	    $(function() {
	      var $form = $('#payment-form');
	      $form.submit(function(event) {
	        // Disable the submit button to prevent repeated clicks:
	        $form.find('.submit').prop('disabled', true);

	        // Request a token from Stripe:
	        Stripe.card.createToken($form, stripeResponseHandler);

	        // Prevent the form from being submitted:
	        return false;
	      });
	    });
	    function stripeResponseHandler(status, response) {
	      // Grab the form:
	      var $form = $('#payment-form');

	      if (response.error) { // Problem!

	        // Show the errors on the form:
	        $form.find('.payment-errors').text(response.error.message);
	        $form.find('.submit').prop('disabled', false); // Re-enable submission

	      } else { // Token was created!

	        // Get the token ID:
	        var token = response.id;

	        // Insert the token ID into the form so it gets submitted to the server:
	        $form.append($('<input type="hidden" name="stripeToken">').val(token));

	        // Submit the form:
	        $form.get(0).submit();
	      }
	    };
	</script>
	<style type="text/css">
		.container{padding:60px 20px 20px 20px;}
		.payment_form_box{/*box-shadow:0px 0px 5px rgba(0,0,0,.8),0px 0px 50px rgba(0,0,0,.2) inset;*/padding:25px 25px 0 25px;background:#fff;}
		.table td{vertical-align: middle;}
	</style>
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-offset-3 payment_form_box">
			   <form action="<?php echo base_url(); ?>Stripe_payment/checkout" method="POST" id="payment-form">
			   <h3>Package : <?php echo $package_document['packname']; ?></h3>
			   <h5>Price : $<?php echo $package_document['price']; ?></h5>
			   <h5>Daily Limit : <?php echo $package_document['credit']; ?></h5>
			   <table class="table">
			   		<tr>
			   			<td colspan="3">
			   				<span style="color:red;" class="payment-errors"></span>
			   				<input type="hidden" name="package_id" value="<?php echo $package_document['_id'];?>">
			   			</td>
			   		</tr>
			   		<tr>
			   			<td><span>Card Number</span></td>
			   			<td colspan="2">
												<div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-credit-card"></span>
                                                       </span>
                                                      <input class="form-control" type="text" size="20"  name="card_number" data-stripe="number" value="5555555555554444">
                                                  </div>
			   			</td>
			   		</tr>
			   		<tr>
			   			<td><span>Expiration (MM/YY)</span></td>
			   			<td>
			   				<div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar-o"></span>
                                                       </span>
                                                      <input class="form-control" type="text" placeholder="MM" data-stripe="exp_month" value="07">
                                                  </div>
			   			</td>
			   			<td><input class="form-control" type="text" placeholder="YY" data-stripe="exp_year" value="16"></td>
			   		</tr>
			   		<tr>
			   			<td><span>CVC</span></td>
			   			<td colspan="2">
			   				<div class="input-group">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-lock"></span>
                                                       </span>
                                                      <input class="form-control" type="text" data-stripe="cvc" value="123">
                                                  </div>
			   			</td>
			   		</tr>
			   		<tr>
			   			<td colspan="3"><button type="submit" class="col-xs-12 btn btn-lg green submit"><i class="fa fa-shopping-cart"></i> Pay</button></td>
			   		</tr>
			   		<tr>
			   			<td colspan="3">
			   			<img class="col-xs-12" style="padding:0;" src="<?php echo base_url();?>assets/user/images/credit-cards.png">
			   			</td>
			   		</tr>




			   </table>
			    </form>
		</div>
	</div>