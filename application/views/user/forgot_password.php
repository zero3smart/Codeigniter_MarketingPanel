<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>| Forgot Password |</title>
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
        .password{background:#ccc !important;margin:0 !important;}
        .password_layer_2{background:url('');background-size:auto 150px;position:fixed;top:0;left:0;width:100%;height:100%;}
        .password_layer_1{background:radial-gradient(circle, #fff 0%, rgba(0,0,0,0) 100%);position:fixed;top:0;left:0;width:100%;height:100%;}
        .password_panel{
            background:#fff;
            border-radius:3px !important;
            box-shadow: 2px 2px 4px rgba(0,0,0,.15);
        }
        .password_panel{padding:10px 25px;}
        .password_panel .form-title{font-weight:800;color:#E02F00 !important;width:100%;text-align:center;}
        .password_panel input{border-radius: 2px !important;color:#E02F00;background:#F3F3F4 !important;transition:.5s ease-in;border:1px solid #D1D1D3;padding:15px 15px;height: auto;margin-top:20px !important;}
        .password_panel input:hover,.password_panel input:focus{border:1px solid #E02F00;background:#f6f6f6 !important;box-shadow:0px 0px 2px rgba(0,0,0,.3) !important;}

        .password_panel button{border-radius: 2px !important;background:#E02F00 !important;font-weight:bold;border:none;padding:15px 15px;height: auto;margin-top:20px !important;width:100%;}
        .password_panel button:hover{background:#C12901 !important;}
        .password_panel a{color:#999;}
        .password_panel a:hover{color:#666 !important;text-decoration:none;}
        .copyright{color:#999 !important;text-decoration:none;}
        .password_panel_con{padding:20px 60px;}
        .loginLink {text-align: center; margin-top:20px;}
        .loginLinkUrl{color:#E02F00 !important}
        @media (max-width:767px)
        {
            .password_panel_con{padding:20px 0;}
        }
        .logo {margin:60px auto 0;padding:15px;text-align:center}
        .copyright{text-align:center;margin:0 auto 30px 0;padding:10px;color:#7a8ca5;font-size:13px}
    </style>
</head>
<!-- END HEAD -->
<div class="password_layer_2"></div>
<div class="password_layer_1"></div>
<body class="password">

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
    
    <!-- BEGIN password -->
    <div class="container-fluid nopadding">
        <div class="col-xs-10 col-sm-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4 password_panel_con" style="" >
            <div class="col-xs-12 password_panel">
                <!-- BEGIN password FORM -->
                <form class="password-form" action="<?php echo base_url(); ?>forgot_password" method="post">
                    <h3 class="form-title font-green">Forgot Password</h3>
                    <div class="form-group" style="color: red;">
                        <?php echo $this->session->flashdata('flash_message');?>
                    </div>

                    <div class="form-group">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9">Email</label>
                        <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" />
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn green uppercase">Submit</button>
                    </div>

                    <div class="loginLink">
                        <a href="<?php echo base_url(); ?>" class="loginLinkUrl">Log In</a>
                    </div>

                </form>
                <!-- END password FORM -->
            </div>
        </div>
    </div>
    <div class="container-fluid nopadding">
        <div class="copyright col-xs-12 nopadding"> 2016 © Verify Rocket. </div>
    </div>
</body>

</html>