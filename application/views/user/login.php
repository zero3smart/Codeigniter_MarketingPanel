<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>| Login |</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <?php require_once('includes/header.php');?>
        <style type="text/css">
        .nopadding{padding: 0 !important;}
         *::-moz-selection {
              background: #E02F00;
              color:#fff;
            }
        *::-ms-selection {
                      background: #E02F00;
                      color:#fff;
                    }
        *::-webkit-selection {
                      background: #E02F00;
                      color:#fff;
                    }
        *::-o-selection {
                      background: #E02F00;
                      color:#fff;
                    }

        *::selection {
              background: #E02F00;
              color:#fff;
            }
        .login{background:#ccc !important;margin:0 !important;}
        .login_layer_2{background:url('');background-size:auto 150px;position:fixed;top:0;left:0;width:100%;height:100%;}
        .login_layer_1{background:radial-gradient(circle, #fff 0%, rgba(0,0,0,0) 100%);position:fixed;top:0;left:0;width:100%;height:100%;}
        .login_panel{
            background:#fff;
            border-radius:3px !important;
            box-shadow: 2px 2px 4px rgba(0,0,0,.15);
        }
        .login_panel{padding:10px 25px;}
        .login_panel .form-title{font-weight:800;color:#E02F00 !important;width:100%;text-align:center;}
        .login_panel input{border-radius: 2px !important;color:#E02F00;background:#F3F3F4 !important;transition:.5s ease-in;border:1px solid #D1D1D3;padding:15px 15px;height: auto;margin-top:20px !important;}
        .login_panel input:hover,.login_panel input:focus{border:1px solid #E02F00;background:#f6f6f6 !important;box-shadow:0px 0px 2px rgba(0,0,0,.3) !important;}

        .login_panel button{border-radius: 2px !important;background:#E02F00 !important;font-weight:bold;border:none;padding:15px 15px;height: auto;margin-top:20px !important;width:100%;}
        .login_panel button:hover{background:#C12901 !important;}
        .login_panel a{color:#999;}
        .login_panel a:hover{color:#666 !important;text-decoration:none;}
        .copyright{color:#999 !important;text-decoration:none;}
        .login_panel_con{padding:20px 60px;}
        @media (max-width:767px)
        {
            .login_panel_con{padding:20px 0;}
        }
        </style>
         </head>
    <!-- END HEAD -->
<div class="login_layer_2"></div>
<div class="login_layer_1"></div>
    <body class="login">

        <!-- BEGIN LOGO -->
        <div class="container-fluid nopadding">
        <div class="logo">
            <div class="col-xs-10 col-sm-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                    <a href="" class="col-xs-10 col-sm-8 col-xs-offset-1 col-sm-offset-2" style="height:100%">
                        <img src="<?php echo base_url();?>assets/user/images/verify_rocket_logo_small.png"  alt="logo" class="logo-default col-xs-12" style="padding:0;" /> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
            </div>
        </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="container-fluid nopadding">
        <div class="col-xs-10 col-sm-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4 login_panel_con" style="" >
            <div class="col-xs-12 login_panel">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?php echo base_url(); ?>user_login" method="post">
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <?php echo $error;?>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
                    <input class="form-control form-control-solid placeholder-no-fix" type="hidden"  value="<?php echo base_url().'dashboard';// echo $request; ?>" name="request" /> </div>
                <!--<div class="form-group">
                    <a href="">Forgot Password?</a>
                </div>-->
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>

                </div>

                <div class="create-account">
                    <p>

                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->

            </div>
        </div>
        </div>
        <div class="container-fluid nopadding">
            <div class="copyright col-xs-12 nopadding"> 2016 © Verify Rocket. </div>
        </div>
    </body>

</html>