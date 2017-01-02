<style type="text/css">
	.custom_edit_single_field_form .fa{float:right;opacity:.5;cursor:pointer;margin-left:30px;transition:.5s ease-in;border:1px solid #36c6d3;color:#36c6d3;border-radius: 100%;width:30px;height:30px;line-height: 30px;text-align:center;}
	.custom_edit_single_field_form .fa:hover{opacity:1;box-shadow:0px 0px 3px #000;}
	.custom_edit_single_field_form .value{float:left;}
	.custom_edit_single_field_form .form_element{display:none;}
	.custom_edit_single_field_form .field_element{}
	.custom_edit_table .td_1,.custom_edit_table .td_2{vertical-align: middle;}
	.custom_edit_table .td_1{width:30%;}
	.custom_edit_table .td_2{width:70%;}
	.custom_edit_single_field_form .form-control{width:100%;float:left;margin:0;}
	.custom_edit_single_field_form .btn{width:50%;float:left;margin:0;}
	.profile_pic_wrapper{width:300px;height:auto;margin:20px auto;}
	.absolute_full{position:absolute;top:0;left:0;width:100%;height:100%;}
	.profile_pic_holder{position:relative;top:0;left:0;width:100%;height:300px;transition:.5s ease-in;perspective: 500px;}
	.profile_pic{object-fit:cover;width:100%;height:100%;transition:1s ease-in;box-shadow:0px 0px 7px rgba(0,0,0,.4);}
	.profile_pic_holder .mask{opacity:0;background:rgba(0,0,0,.3);transition:.5s ease-in;}
	.profile_pic_holder:hover .mask{opacity:1;}
	.center_center{position:absolute;left:50%;top:50%;float:left;transform:translateX(-50%) translateY(-50%);}
	.inner_title{font-size:20px; font-weight:bold;color:#fff;text-shadow:0px 0px 5px #000;}
	input.fake_file{cursor:pointer;opacity:0;}
	.profile_picture_update_btn{display:none;}
	.rotate_360{animation-name:rotate_360;animation-duration:2s;animation-iteration-count:infinite;animation-fill-mode:forwards;animation-timing-function:linear;}
	.rotate_360_1{animation-name:rotate_360_1;animation-duration:1s;animation-iteration-count:1;animation-timing-function:ease-in;}
	@keyframes rotate_360
	{
		from{transform:rotateY(0deg);	transform-style: preserve-3d;transform-origin:50% 50%;}
		to{transform:rotateY(360deg);	transform-style: preserve-3d;transform-origin:50% 50%;}
	}
	@keyframes rotate_360_1
	{
		from{transform:rotateY(360deg);	transform-style: preserve-3d;transform-origin:50% 50%;	}
		to{transform:rotateY(0deg);	transform-style: preserve-3d;transform-origin:50% 50%;	}
	}
</style>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .mt-overlay-1{height:200px !important;}
    @media(min-width:300px){.mt-overlay-1{height:300px !important;}}
    @media(min-width:400px){.mt-overlay-1{height:400px !important;}}
    @media(min-width:500px){.mt-overlay-1{height:500px !important;}}
    @media(min-width:600px){.mt-overlay-1{height:600px !important;}}
    @media(min-width:768px){.mt-overlay-1{height:350px !important;}}
    @media(min-width:992px){.mt-overlay-1{height:200px !important;}}
    @media(min-width:1200px){.mt-overlay-1{height:300px !important;}}
    .mt-overlay-1 .img_holder{position:absolute;top:0;left:0;width:100%;height:100%;transition:.5s;} 
    .mt-element-overlay .mt-overlay-1 img {object-fit:cover;width:100%;height:100% !important;}
    .payment_method_body .fa{font-size:600%;margin:60px 30px;}
    .payment_method_body a:hover{text-decoration: none;}
    .payment_method_body a:focus{text-decoration: none;}
</style>
<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 text-center" style="padding-bottom:15px">
			<div class="profile_pic_wrapper">
				<form id="profile_picture_update" action="<?php echo base_url();?>profile_picture_update" method="post" enctype="multipart/form-data">
				<div class="profile_pic_holder">
					<img class="profile_pic" src="<?php echo base_url().$profile_document['avater'];?>">
					<div class="absolute_full mask">
						<span class="center_center inner_title">Click to Browse new Photo</span>
							<input type="file" class="absolute_full fake_file profile_picture_update_change"  name="profile_picture" accept="image/x-png, image/gif, image/jpeg" >
							
						
					</div>
				</div>
				<button type="submit" class="col-xs-12 btn green profile_picture_update_btn">Upload</button>
				</form>
			</div>
		</div>
		<table class="table custom_edit_table">
		<?php 
		echo '
			<tr><td class="text-right td_1">
					Username :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['username'].'</span>
						</div>
					</div>
				</td>
			</tr>
			<tr><td class="text-right td_1">
					Email :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['email'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['email'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="email" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>
			<tr><td class="text-right td_1">
					Password :
				</td>
				<td class="custom_edit td_2" data_field="password">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form password_update" action="'.base_url().'password_update" method="post">
						<div class="col-xs-12 field_element">
							<span class="value">******</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="" name="field_old_password" placeholder="Old Password" autocomplete="off" required id="check_old_password" onkeyup="fn_check_old_password(this.value)" onchange="fn_check_old_password(this.value)">
							<div class="error_result_form_element check_old_password_result col-xs-12" style="display:none">* Password Incorrect.</div>
							<input class="form-control hidden_tmp" style="display:none" value="" name="field_new_password" autocomplete="off" readonly required placeholder="New Password" id="check_password_match_1" onkeyup="fn_check_password_match_1(this.value)">
							<div class="error_result_form_element check_new_password_length col-xs-12"  style="display:none">* Password length should be atleast 6 Characters.</div>
							<input class="form-control hidden_tmp" style="display:none" value="" name="field_new_password_again" autocomplete="off" readonly required placeholder="New Password Again" id="check_password_match_2" onkeyup="fn_check_password_match_2(this.value)">
							<div class="error_result_form_element check_match_password col-xs-12"  style="display:none">* Passwords doesn\'t match.</div>
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="button" class="btn green change" id="password_update_btn">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>

			<tr><td class="text-right td_1">
					First Name :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['firstname'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['firstname'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="firstname" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>
			<tr><td class="text-right td_1">
					Last Name :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['lastname'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['lastname'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="lastname" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>
			
			<tr><td class="text-right td_1">
					Contact :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.(isset($profile_document['contact']) ? $profile_document['contact'] : "").'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['contact'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="contact" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>

			<tr><td class="text-right td_1">
					Address :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.nl2br($profile_document['address']).'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<textarea class="form-control" style="" name="field_value">'.$profile_document['address'].'</textarea>
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="address" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>

			<tr><td class="text-right td_1">
					Zip Code :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['zip'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['zip'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="zip" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>

			<tr><td class="text-right td_1">
					State :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['state'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['state'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="state" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>

			<tr><td class="text-right td_1">
					Country :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span class="value">'.$profile_document['country'].'</span>
							<i class="fa fa-pencil pull_field_form"></i>
						</div>
						<div class="col-xs-12 form_element">
							<input class="form-control" style="" value="'.$profile_document['country'].'" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="country" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="btn green change">Change</button>
							<button type="button" class="btn red cancel">Cancel</button>
						</div>
					</form>
					</div>
				</td>
			</tr>
			
			<tr><td class="text-right td_1">
					API Key :
				</td>
				<td class="custom_edit td_2" data_field="username">
					<div class="col-xs-12 col-md-8">
					<form class="custom_edit_single_field_form">
						<div class="col-xs-12 field_element">
							<span id="set_api_key_profile" style="margin-top:10px;" class="value">'.$profile_document['api_key'].'</span>
							<input type="hidden" style="" value="" name="field_value">
							<input type="hidden" value="user" name="collection">
							<input type="hidden" value="api_key" name="field">
							<input type="hidden" value="'.$profile_document['_id'].'" name="_id">
							<button type="submit" class="pull-right btn green change" style="width:auto;">Change</button>
						</div>
					</form>
					</div>
				</td>
			</tr>


		';
		?>
		</table>
	</div>
</div>