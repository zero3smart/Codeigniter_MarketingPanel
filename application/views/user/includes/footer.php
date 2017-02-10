<?php 
  /*app.snapiq.com/application/view/user/includes/footer*/
?>
<div class="custom_spinner">
        <div class="custom_spinner_child"><!--sk-circle -->
          <div class="sk-circle1 sk-child"></div>
          <div class="sk-circle2 sk-child"></div>
          <div class="sk-circle3 sk-child"></div>
          <div class="sk-circle4 sk-child"></div>
          <div class="sk-circle5 sk-child"></div>
          <div class="sk-circle6 sk-child"></div>
          <div class="sk-circle7 sk-child"></div>
          <div class="sk-circle8 sk-child"></div>
          <div class="sk-circle9 sk-child"></div>
          <div class="sk-circle10 sk-child"></div>
          <div class="sk-circle11 sk-child"></div>
          <div class="sk-circle12 sk-child"></div>
        </div>
        </div>

        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

        <!-- BEGIN CORE PLUGINS -->
        <script type="text/javascript">
        
          //localStorage['name'] = 'somestring';
          if(!localStorage['name1'])
          {
              localStorage['name1'] = document.location.href;
          }
          else if(!localStorage['name2'])
          {
              localStorage['name2'] = document.location.href;
          }

          //alert(localStorage['name1']);


        </script>
        <!--<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script type="text/javascript">

                 $("#report_action_by_date_btn").click(function(event){
                            event.preventDefault();
                            report_action_from_date = document.getElementById('report_action_from_date').value;
                            report_action_to_date = document.getElementById('report_action_to_date').value;
                            report_action_url = document.getElementById('report_action_url').value;
                            if(report_action_from_date == '' || report_action_to_date == '')
                            {
                                alert('Please select 2 dates.');
                                return false;
                            }
                            report_action_from_date_arr = report_action_from_date.split('/');
                            report_action_to_date_arr = report_action_to_date.split('/');
                            report_action_from_date = report_action_from_date_arr[2]+'-'+report_action_from_date_arr[0]+'-'+report_action_from_date_arr[1];
                            report_action_to_date = report_action_to_date_arr[2]+'-'+report_action_to_date_arr[0]+'-'+report_action_to_date_arr[1];
                            
                            document.location.href = report_action_url+report_action_from_date+'/'+report_action_to_date;
                        });

        $(".confirm_delete").click(function(event){
              event.preventDefault();
              href_ = $(this).attr("href");
              var r = confirm("Are you sure, you want to delete this?");
              if (r == true) {
                  document.location.href = href_;
              }
        });
        function global_balance_set()
        {
          top_menu_global_balance = document.getElementById("top_menu_global_balance").innerHTML;
                                            $.ajax({
                                            type: 'GET',
                                            url: base_url+'global_balance',
                                            success:function(data){
                                                //alert(data);
                                                document.getElementById("top_menu_global_balance").innerHTML = data;
                                                console.log("balance_changed");
                                             },
                                            error:function(){
                                              document.getElementById("top_menu_global_balance").innerHTML = top_menu_global_balance;
                                             }
                                          });
        }
        function get_balance_and_limit(parm1)
        {
          top_menu_global_balance = document.getElementById("top_menu_global_balance").innerHTML;
          top_menu_global_usable_credit = document.getElementById("top_menu_global_usable_credit").innerHTML;
          top_menu_global_daily_limit = document.getElementById("top_menu_global_daily_limit").innerHTML;

                                            $.ajax({
                                            type: 'GET',
                                            dataType: 'JSON',
                                            url: base_url+'User_controller/get_balance_and_limit',
                                            success:function(data){
                                                //alert(data);
                                              document.getElementById("top_menu_global_balance").innerHTML = data['balance'];
                                              document.getElementById("top_menu_global_usable_credit").innerHTML = data['usable_credit'];
                                              document.getElementById("top_menu_global_daily_limit").innerHTML = data['daily_limit'];
                                              if(parseInt(data['daily_limit'])>0)
                                                if($("#top_menu_global_daily_limit").parent().hasClass('hidden'))
                                                  $("#top_menu_global_daily_limit").parent().removeClass("hidden");

                                              //console.log( data['balance'] +' | '+data['daily_limit'] +' | '+ data['usable_credit']);
                                             },
                                            error:function(){
                                              document.getElementById("top_menu_global_balance").innerHTML = top_menu_global_balance;
                                              document.getElementById("top_menu_global_usable_credit").innerHTML = top_menu_global_usable_credit;
                                              document.getElementById("top_menu_global_daily_limit").innerHTML = top_menu_global_daily_limit;
                                              console.log("error in get_balance_and_limit");
                                             }
                                          });
        }

        setInterval(get_balance_and_limit, 30000);
        //setInterval( function() { get_balance_and_limit(); }, 500 );
         function toggleCollapse(id, buttonId) {
             $('#'+id).slideToggle('slow');
             if(buttonId) {
                 var button = $('#' + buttonId);
                 button.toggleClass('expanded-button');
                 button.toggleClass('collapsed-button');
             }

         }
        function custom_spinner_show()
        {
            $(".custom_spinner_child").addClass("sk-circle");
            $(".custom_spinner").slideDown(5);
        }
        function custom_spinner_hide()
        {
            $(".custom_spinner").slideUp(300);
            $(".custom_spinner_child").removeClass("sk-circle");
            
        }
        function scroll_top()
        {
            var body = $("html, body");
            body.stop().animate({scrollTop:0}, '500', 'swing');
        }
        $(".toggle").click(function(){
            data_toggle = $(this).attr("data-toggle");
            data_duration = $(this).attr("data-duration");
            $(data_toggle).slideToggle(data_duration);
        });
        <?php  
            if($view['menu'] != ''){ echo '$(".menu_'.$view['menu'].'").addClass("active").addClass("open");$(".menu_'.$view['menu'].'>a>.arrow").addClass("open");'; }
            if($view['submenu'] != ''){  echo '$(".submenu_'.$view['submenu'].'").addClass("active").addClass("open");'; }
        ?>
        </script>

        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS
        <script src="<?php echo base_url(); ?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->

        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS
        <script src="<?php echo base_url(); ?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script src="<?php echo base_url(); ?>assets/pages/scripts/lock.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/scripts/custom.js" type="text/javascript"></script>

        <script type="text/javascript">


        $('input[autocomplete="off"]').val('');
        function nl2br (str, is_xhtml) {
                var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
            }
        </script>


        <?php if($view['section'] == 'packages') :?>

            <!--
                Test Secret Key:
                sk_test_oFbGeoPytgtzxqPR8Rvb8kaQ

                Test Publisher Key:
                pk_test_7YiSRN3rqjJFgJRayV27yzwS

                Live Secret Key:
                sk_live_YcgFvnhxHWCVl6JOMgIST7Ey

                Live Publisher Key:
                pk_live_89WxqqLqv9SY1RvJpr7pftHe
            -->
            <script type="text/javascript">
                $('#btn-stripe').click(function(){

                  var token = function(res){
                    var $input = $('<input type="hidden" name="stripeToken" />').val(res.id);

                    // show processing message, disable links and buttons until form is submitted and reloads
                    $('a').bind("click", function() { return false; });
                    $('button').addClass('disabled');
                    $('.overlay-container').show();

                    // submit form
                    $('#stripe_submit_form').append($input).submit();
                  };

                  // test publishable key is: pk_test_wRl9xX9XsOj1fUSwzsebPV05
                  StripeCheckout.open({
                    key:         'pk_live_oPE2lWuZcUJy3DNDAIh6aPvU',
                    address:     false,
                    amount:      parseFloat(document.getElementById("package_price").innerHTML)*100,
                    currency:    'usd',
                    name:        'Number Lookup',
                    description: 'Package : '+document.getElementById("package_name").innerHTML,
                    panelLabel:  'Checkout',
                    token:       token
                  });

                  return false;
                });

                function set_package_data(id,credit,price,name)
                {
                    $('#credit_top_up_modal').modal("show");
                    document.getElementById("package_id").value = id;
                    document.getElementById("package_name").innerHTML = name;
                    document.getElementById("package_credit").innerHTML = credit;
                    document.getElementById("package_price").innerHTML = price;
                }

                $('#credit_top_up_modal').on('hidden.bs.modal', function () {
                    document.getElementById("package_id").value = '';
                    document.getElementById("package_name").innerHTML = '';
                    document.getElementById("package_credit").innerHTML = '';
                    document.getElementById("package_price").innerHTML = '';
                });
            </script>
        <?php endif; ?>



        <!-- Profile Section Footer JS Start-->
        <?php if($view['section'] == 'profile') { ?>
        <script type="text/javascript">
            
            $(".pull_field_form").click(function(){
                $(this).parent().slideUp("slow");
                $(this).parents().eq(1).children(".form_element").addClass("form_element_show");
                $(this).parents().eq(1).children(".form_element").slideDown("slow");
            });
           //$(document).on('click', ".form_element_show", function() {
                //alert("ok");});
             // $(".form_element_show").click(function(){alert("ok");});
            $('.custom_edit_single_field_form .cancel').click(function() {
                form_element = $(this).parents().eq(1).children(".form_element");
                field_element = $(this).parents().eq(1).children(".field_element");
                
                    form_element.slideUp("slow");
                    field_element.slideDown("slow");
                    form_element.removeClass("form_element_show");
                
            });
            
            
            function fn_check_password_match_1(str)
            {
              for_return = false;
              new_1 = document.getElementById("check_password_match_1").value;
              document.getElementById("check_password_match_2").value = "";
              if(new_1.length < 6)
              {
                  $(".check_new_password_length").slideDown("slow");

                  document.getElementById("password_update_btn").setAttribute("type","button");
                  for_return = false;
              }
              else
              {
                  $(".check_new_password_length").slideUp("slow");
                  $("#check_password_match_2").removeAttr("readonly");

                  document.getElementById("password_update_btn").setAttribute("type","button");
                  for_return = true;
              }
              return for_return;
            }
            function fn_check_password_match_2(new_2)
            {
              for_return = false;
              new_1 = document.getElementById("check_password_match_1").value;
              if(new_1 == new_2)
              {

                  $(".check_match_password").slideUp("slow");
                  if( new_1.length>5)
                  document.getElementById("password_update_btn").setAttribute("type","submit");
                  for_return = true;
              }
              else
              {
                  $(".check_match_password").slideDown("slow");

                  document.getElementById("password_update_btn").setAttribute("type","button");
                  for_return = false;
              }
              return for_return;
              
            }

            function fn_check_old_password(str)
            {
                for_return = false;
             // alert(str);
              url_ = document.getElementById("base_url").innerHTML;
              $.ajax({
                      type: 'GET',
                      url: url_+'old_pass_check/'+str,
                      success:function(data){
                        data = parseInt(data);
                        //alert(data);
                          document.getElementById("password_update_btn").setAttribute("type","button");
                          if(data == 0)
                          {

                            $(".check_old_password_result").slideDown("slow");
                            document.getElementById("check_password_match_1").setAttribute("readonly","");
                            document.getElementById("check_password_match_2").setAttribute("readonly","");
                            
                            for_return = false;
                            return for_return;
                          }
                          else
                          {
                            $(".check_old_password_result").slideUp("slow");
                            $("#check_password_match_1,#check_password_match_2").slideDown("slow");
                            $("#check_password_match_1").removeAttr("readonly");
                            new_1 = document.getElementById("check_password_match_1").value;
                            new_2 = document.getElementById("check_password_match_2").value;
                            if(new_1.length>5)
                                $("#check_password_match_2").removeAttr("readonly");
                            new_2_check = fn_check_password_match_2(new_2);
                            if(new_2_check == true && new_2.length >5)
                            {
                              
                              document.getElementById("password_update_btn").setAttribute("type","submit");
                            }
                            for_return = true;
                            return for_return;
                          }

                          

                       },
                      error:function(){
                       }
                    });
                
            }

            $(document).on('submit', ".custom_edit_single_field_form", function() {
                form_element = $(this).children(".form_element");
                            field_element = $(this).children(".field_element");
                    if($(this).hasClass("password_update"))
                    {

                        old = document.getElementById("check_old_password").value;
                        /*

                        old_check = fn_check_old_password(old);
                        */
                        url_ = document.getElementById("base_url").innerHTML;
                        $.ajax({
                                type: 'GET',
                                url: url_+'old_pass_check/'+old,
                                success:function(data){
                                  data = parseInt(data);
                                  //alert(data);
                                    if(data == 0)
                                    {
                                      alert("Current Password is incorrect.")
                                    }
                                    else
                                    {
                                        new_1 = document.getElementById("check_password_match_1").value;
                                        new_2 = document.getElementById("check_password_match_2").value;
                                        
                                        if(new_1 == new_2 && new_1.length>5)
                                        {
                                            $.ajax({
                                            type: 'GET',
                                            url: url_+'password_update/'+old+'/'+new_1+'/'+new_2,
                                            success:function(data){
                                                //alert(data);
                                                
                                                  data = parseInt(data);
                                                  if(data == 1)
                                                  {
                                                    form_element.slideUp("slow");
                                                    field_element.slideDown("slow");
                                                    form_element.removeClass("form_element_show");
                                                    document.getElementById("check_old_password").value = "";
                                                    document.getElementById("check_password_match_1").value = "";
                                                    document.getElementById("check_password_match_2").value = "";
                                                  }
                                                  else
                                                    alert("Please, Try again.");
                                                  
                                             },
                                            error:function(){
                                             }
                                          });
                                        }
                                        else
                                        {
                                          return false;
                                        }
                                    }

                                    

                                 },
                                error:function(){
                                 }
                              });

                    }
                    else
                    {
                            
                    url_ = document.getElementById("base_url").innerHTML;
                    $.ajax({
                      type: 'POST',
                      url: url_+'profile_update',
                      data: $(this).serialize(),
                      success:function(data){
                            field_element.children(".value").html(nl2br(data));
                            form_element.children("input[name='field_value']").val(data);
                            form_element.slideUp("slow");
                            field_element.slideDown("slow");
                            form_element.removeClass("form_element_show");
                       },
                      error:function(){
                       }
                    });
                  }

                return false;
            });
            




                $(function () {
                $(".profile_picture_update_change").change(function () {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            function imageIsLoaded(e) {
                $('.profile_pic').attr('src', e.target.result);
                //$(".profile_picture_update_btn").slideDown("slow");
                $("#profile_picture_update").submit();
            };

            $("#profile_picture_update").on('submit',(function(e) {
                    url_ = document.getElementById("base_url").innerHTML;
                    e.preventDefault();
                        $.ajax({
                        url: url_+"profile_picture_update", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        dataType: 'json',
                        contentType: false,       // The content type used when sending data to the server.
                        cache: false,             // To unable request pages to be cached
                        processData:false,        // To send DOMDocument or non processed data file it is set to false
                        beforeSend:function(){
                            if($(".profile_pic").hasClass("rotate_360_1"))
                            $(".profile_pic").removeClass("rotate_360_1");
                            $(".profile_pic").addClass("rotate_360");
                            $(".profile_pic_holder .mask").css({"display":"none"});
                        },
                        success: function(data)   // A function to be called if request succeeds
                        {
                          console.log(data);
                            if(data == '0' )
                            {
                                alert("Sorry, There was some problem, Please Try again.")
                                $('.profile_pic').attr('src', url_+'assets/user/avater/default.jpg'); 
                            }
                        },
                        complete: function (data) {
                            console.log(data);
                            $(".profile_pic").removeClass("rotate_360").addClass("rotate_360_1");
                            $(".profile_pic_holder .mask").css({"display":"block"});
                        }
                    });
                })
                );

                
            
        </script>

        <?php } ?>
        <!-- Profile Section Footer JS End-->


        <!-- Contact Upload Section Footer JS Start-->
        <?php if($view['section'] == 'contact_upload_section') { ?>
        <script src="<?php echo base_url();?>assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>

        <script src="<?php echo base_url();?>assets/js/form-fileupload.js" type="text/javascript"></script>
        <script type="text/javascript">

        if(window.location.href == base_url+'contact_upload_section#file_process_progress')
          $("body,html").animate({scrollTop:$("#file_process_progress").offset().top-$(".page-top").outerHeight()-15+"px"},500);

        $(function () {
    var dropZoneId = "drop-zone";
    var buttonId = "clickHere";
    var mouseOverClass = "mouse-over";

    var dropZone = $("#" + dropZoneId);
    var ooleft = dropZone.offset().left;
    var ooright = dropZone.outerWidth() + ooleft;
    var ootop = dropZone.offset().top;
    var oobottom = dropZone.outerHeight() + ootop;
    var inputFile = dropZone.find("input");
    document.getElementById(dropZoneId).addEventListener("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.addClass(mouseOverClass);
        var x = e.pageX;
        var y = e.pageY;

        if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
            inputFile.offset({ top: y - 15, left: x - 100 });
        } else {
            inputFile.offset({ top: -400, left: -400 });
        }

    }, true);

    if (buttonId != "") {
        var clickZone = $("#" + buttonId);

        var oleft = clickZone.offset().left;
        var oright = clickZone.outerWidth() + oleft;
        var otop = clickZone.offset().top;
        var obottom = clickZone.outerHeight() + otop;

        $("#" + buttonId).mousemove(function (e) {
            var x = e.pageX;
            var y = e.pageY;
            if (!(x < oleft || x > oright || y < otop || y > obottom)) {
                inputFile.offset({ top: y - 15, left: x - 160 });
            } else {
                inputFile.offset({ top: -400, left: -400 });
            }
        });
    }

    document.getElementById(dropZoneId).addEventListener("drop", function (e) {
        $("#" + dropZoneId).removeClass(mouseOverClass);
    }, true);

})

        function validate_email(email)
        {
          var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
            if (email == '' || !re.test(email))
                return false;
            else
              return true;
            
        }

        function fn_contact_upload_file_name_set(event){
            event.preventDefault();
            document.getElementById("set_column_number").value = '';
            fn_contact_upload_file();
                    var control = document.getElementById("contact_upload_file");
            var i = 0,
                files = control.files,
                len = files.length;
                file_size = file_size_show(files[0].size);
                $(".file_details").slideDown("slow");
                $("#contact_upload_file_name_set").html("File Name: " + files[0].name);
                $("#contact_upload_file_size_set").html("Size: " + file_size);
                if($(".progress-bar").hasClass("progress-bar-warning"));
                {
                  $(".progress-bar").removeClass("progress-bar-warning");
                  $(".progress-bar").addClass("progress-bar-success");
                }
                $(".progress-bar").css({"width":"0%"});
                                    $(".progress-bar").html("");
                

 

        
    }
/*    window.onload = function () { 
 //Check the support for the File API support 
 if (window.File && window.FileReader && window.FileList && window.Blob) {
    */
    function fn_contact_upload_file(){
        //event.preventDefault();
        global_balance = parseInt(document.getElementById('top_menu_global_balance').innerHTML);
        global_daily_limit_left = parseInt(document.getElementById('top_menu_global_daily_limit').innerHTML);
        global_total_usable_credit = parseInt(document.getElementById('top_menu_global_usable_credit').innerHTML);


        //alert(global_balance+' | '+global_daily_limit_left+' | '+global_total_usable_credit);

        set_column_number = document.getElementById("set_column_number").value;
        set_column_number = parseInt(set_column_number);
        if(isNaN(set_column_number))
            set_column_number = 0;
    var fileSelected = document.getElementById('contact_upload_file');
         //Set the extension for the file 
         var fileExtension = 'application/vnd.ms-excel'; 
         var fileExtension_2 = 'text/csv'; 
         var fileExtension_3 = 1; 

         
         //Get the file object 
         var fileTobeRead = fileSelected.files[0];




        //Check of the extension match 
        
         if (fileExtension_3 == 1) { 
             //Initialize the FileReader object to read the 2file 
             var fileReader = new FileReader(); 
             fileReader.onload = function (e) { 
                 var fileContents = document.getElementById('filecontents');
                 fileContents_data_array = []; 
                 fileContents_data_array = fileReader.result.split("\n"); 
                 fileContents_data_str = "";
                 position_track = [];
                 get_data_from_csv_file = '<table class="table table-striped table-bordered table-hover"><tr>';
                 data_for_serial = [];
                 data_for_serial = fileContents_data_array[0].split(',');
                 for(i=1;i<=data_for_serial.length;i++)
                 {

                    get_data_from_csv_file = get_data_from_csv_file+'<th class="text-center column_'+i+'_for_selected">'+i+'</th>';
                 }
                 get_data_from_csv_file = get_data_from_csv_file+'</tr>';
                 if(fileContents_data_array.length > 11)
                  loop_length = 11;
                else
                  loop_length = fileContents_data_array.length;
                 for(i=0;i<loop_length;i++)
                 {

                    get_data_from_csv_file = get_data_from_csv_file+'<tr>';
                    
                    fileContents_data_array_2 = [];
                    fileContents_data_str = fileContents_data_str+fileContents_data_array[i]+"\n";
                    fileContents_data_array_2 =  fileContents_data_array[i].split(',');
                    
                        position_track[i] = false;
                    
                        for(j=0;j<fileContents_data_array_2.length;j++)
                        {
                            jj = j+1;
                            if(i>0)
                            get_data_from_csv_file = get_data_from_csv_file+'<td class="column_'+jj+'_for_selected">';
                            else
                            get_data_from_csv_file = get_data_from_csv_file+'<th class="column_'+jj+'_for_selected">';
                            
                                test = fileContents_data_array_2[j];
                                
                                test = test.replace(" ", '');
                                var isnum = validate_email(test);
                                
                                    if(isnum)
                                    {
                                        position_track[i] = j+1;
                                        console.log(position_track[i]);
                                    }
                            
                            if(i>0)
                            get_data_from_csv_file = get_data_from_csv_file+fileContents_data_array_2[j]+'</td>';
                            else
                            get_data_from_csv_file = get_data_from_csv_file+fileContents_data_array_2[j]+'</th>';
                            //if(fileContents_data_array_2[j].length )
                        }
                    

                    get_data_from_csv_file = get_data_from_csv_file+'</tr>';
                 }
                 position_track_str = position_track.join(",");
                 //document.getElementById("csv_contact_column_no").innerHTML = position_track_str;
                 test_column =  position_track[1];
                 test_column_check = 0;
                 for(i=1;i<position_track.length;i++)
                 {
                    if(position_track[i] != false)
                    {
                        if(test_column == position_track[i])
                            test_column_check = position_track[i];
                        else
                        {
                            test_column_check = 0;
                            break;
                        }
                    }
                    else
                    {
                        test_column_check = 0;
                        break;
                    }

                 }
                 console.log('here');
                 uploadable = 0;
                 have_balance = 0;

                 if(position_track[0] == false)
                    fileContents_data_array_count = fileContents_data_array.length-2;
                 else
                    fileContents_data_array_count = fileContents_data_array.length-1;

                  if(fileContents_data_array_count<=global_total_usable_credit)
                    have_balance = 1;

                 if(set_column_number == 0)
                 {
                     if(test_column_check != 0)
                     {
                        document.getElementById("suggetion_part").innerHTML = 'Your file appears to contain emails in column '+test_column_check;
                        document.getElementById("command_part").innerHTML = 'If this is wrong please enter the correct email column here : ';
                        document.getElementById("set_column_number").value = test_column_check;
                        document.getElementById("set_column_number_2").value = test_column_check;
                        document.getElementById("set_csv_files_total_row").value=fileContents_data_array_count;
                        $(".show_file_upload_button").slideDown("slow");
                        uploadable = 1;
                     }
                     else
                     {
                        $(".show_file_upload_button").slideUp("slow");
                        document.getElementById("set_csv_files_total_row").value=0;
                        document.getElementById("suggetion_part").innerHTML = 'Sorry, We can\'t recognize the column no of Emails.';
                        document.getElementById("command_part").innerHTML = 'Please write here the column number : ';
                        document.getElementById("set_column_number").value = '';
                        document.getElementById("set_column_number_2").value = '';
                     }
                 }
                 else if( set_column_number == test_column_check)
                 {
                        document.getElementById("set_csv_files_total_row").value=fileContents_data_array_count;
                        document.getElementById("suggetion_part").innerHTML = 'Yes, Your file appears to contain emails in column '+test_column_check;
                        document.getElementById("command_part").innerHTML = 'If this is wrong please enter the correct email column here : ';
                        document.getElementById("set_column_number").value = test_column_check;
                        document.getElementById("set_column_number_2").value = test_column_check;
                        $(".show_file_upload_button").slideDown("slow");
                        uploadable = 1;
                 }
                 else
                 {
                        document.getElementById("set_csv_files_total_row").value=0;
                        $(".show_file_upload_button").slideUp("slow");
                        document.getElementById("suggetion_part").innerHTML = 'Sorry, Something is going wrong';
                        document.getElementById("command_part").innerHTML = 'Please write here the Email\'s column number again : ';
                        document.getElementById("set_column_number").value = '';
                        document.getElementById("set_column_number_2").value = '';
                 }

                 if(uploadable == 1 )
                 {
                    if(have_balance == 0)
                    {
                      $(".show_file_upload_button").slideUp("slow");
                      document.getElementById("balance_deduction_part").innerHTML = "This file contains <b>"+fileContents_data_array_count+" Emails</b>, Sorry You do not have sufficient credit to process this file.";
                    }
                    else
                    {
                        remains_credit = global_balance;
                        if(fileContents_data_array_count > global_daily_limit_left)
                        remains_credit = global_total_usable_credit - fileContents_data_array_count;

                        $(".show_file_upload_button").slideDown("slow");
                        document.getElementById("balance_deduction_part").innerHTML = "This file contains <b>"+fileContents_data_array_count+" Emails</b>, You will have "+remains_credit+" credits after this process.";
                    
                    }
                 }
                 //fileContents.innerText = position_track_str;
                 get_data_from_csv_file = get_data_from_csv_file+'</table>';

                document.getElementById("get_data_from_csv_file").innerHTML = get_data_from_csv_file;
                if(test_column_check>0)
                 {
                    $(".column_"+test_column_check+"_for_selected").css({"background":"#DBF0F2"});
                 }
                $(".get_data_from_csv_file_container").slideDown("slow");
                $("#show_contacts_status_at_file").slideDown("slow");
             } //  fileReader.onload 
             
             fileReader.readAsText(fileTobeRead); 
         }   //if (fileTobeRead.type.match(fileExtension))
         else { 
             alert("Please select csv file"); 
         }
 
     //fileSelected.addEventListener('change', function (e) {
} 
/*
 else { 
     alert("Files are not supported"); 
 } 
 }*/
        function fn_file_process_progress()
        {
          //console.log("fn_file_process_progress");
           $.ajax({
                       
                        url: base_url+'User_controller/get_all_file_process_progress', // Url to which the request is send
                        type: "GET",
                        //dataType: "JSON",
                        success: function(progress){
                          /*progress = parseFloat(progress);
                          if(isNaN(progress))
                            progress = 0;
                          if(progress > 0)
                          progress_degree = (progress * 180)/100;
                          console.log(progress +' | '+progress_degree);
                          
                            $("#file_progress_circle").html(parseInt(progress)+"%");
                            $(".file_progress_down").css({"transform":"rotate("+progress_degree+"deg)"});

                            //setTimeout(function() {fn_file_process_progress(file_id,validity);}, 1000);
                            
                            for(var i=0;i<progress.length;i++)
                            {
                              console.log(progress[i]['_id']);
                            }*/
                            $(".file_progress_row_all").html(progress);
                          //console.log(progress);
                        }

                  });


        }

        fn_file_process_progress();
        setInterval(fn_file_process_progress,15000);

        function file_size_show(size)
        {
          size = parseInt(size);
            if(isNaN(size)) size = 0;

          temp = 1024*1024;
          if(size >= temp)
          {
            size_to_show = size/1024/1024;
            size_to_show = Math.round(size_to_show * 100) / 100;
            size_to_show = size_to_show+' MB';
          }
          else
          {
            size_to_show = size/1024;
            console.log(size_to_show);
            size_to_show = Math.round(size_to_show);
            size_to_show = size_to_show+' KB';
          }
          return size_to_show;

        }

        $("#contact_upload_form").on('submit',(function(event) {
                event.preventDefault();
                
                url_ = $(this).attr("action");
                send_form_data = new FormData(this);
                
                var files = document.getElementById("contact_upload_file").files;
                file_size = parseInt(files[0].size);
                if(isNaN(file_size))
                  file_size = 0;

                file_size_to_show = file_size_show(file_size);

                //alert(file_size_to_show);
                if(file_size > 52428800)
                {
                  alert('Sorry, Max File Upload is 50 MB. Contact support if you require help with a larger file');
                }
                else
                {
                  $.ajax({
                    type:"post",
                    url:'<?php echo base_url();?>check_file_status',
                    data:{file_name:files[0].name},
                    dataType:'JSON',
                    success:function(result)
                    {
                        //alert(JSON.stringify(result));
                        //return false;
                        /*if(result['file_existing'] == true)
                        {
                          alert("Sorry, You already uploded this file.");
                        }
                        else */if(result['current_processing'] >= 5)
                        {
                          alert("Sorry, You can't process more than 5 files at a moment.");
                        }
                        else
                        {
                          //alert('You can upload');
                            $.ajax({
                                xhr: function()
                                  {
                                    var xhr = new window.XMLHttpRequest();
                                    //Upload progress
                                    xhr.upload.addEventListener("progress", function(evt){
                                      if (evt.lengthComputable) {
                                        var percentComplete = (evt.loaded / evt.total) * 100;
                                        percentComplete = parseInt(percentComplete);
                                        if(percentComplete > 80) percentComplete = percentComplete-1;
                                        //Do something with upload progress
                                        $(".progress-bar").css({"width":percentComplete+"%"});
                                        $(".progress-bar").html(percentComplete+"% Complete");
                                      }
                                    }, false);
                                    //Download progress
                                    xhr.addEventListener("progress", function(evt){
                                      if (evt.lengthComputable) {
                                        var percentComplete =  (evt.loaded / evt.total) * 100;
                                        percentComplete = parseInt(percentComplete);
                                        if(percentComplete > 80) percentComplete = percentComplete-1;
                                        //Do something with download progress
                                        $(".progress-bar").css({"width":percentComplete+"%"});
                                      }
                                    }, false);
                                    return xhr;
                                  },
                                url: url_, // Url to which the request is send
                                type: "POST",             // Type of request to be send, called as method
                                data: send_form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                                
                                contentType: false,       // The content type used when sending data to the server.
                                cache: false,             // To unable request pages to be cached
                                processData:false,        // To send DOMDocument or non processed data file it is set to false
                                
                                success: function(result)   // A function to be called if request succeeds
                                {
                                  console.log(result);
                                    //document.getElementById("response_test").innerHTML = result;
                                    result_array = [];
                                    result_array = result.split('/');
                                    if($(".progress-bar").hasClass("progress-bar-success"));
                                    {
                                      $(".progress-bar").html("100% Complete");
                                      $(".progress-bar").removeClass("progress-bar-success");
                                      $(".progress-bar").addClass("progress-bar-warning");
                                    }
                                    //fn_file_process_progress(result_array[1],1);
                                    //console.log(result);
                                    //console.log("called fn_file_process_progress");
                                    alert(result_array[0]);
                                },
                                complete: function (result) {
                                    
                                }
                            
                            });
                        }

                       
                    }
                  });
                }
                


                    /*
                        
                    */




                })
                );
            </script>
        <?php } ?>
        <!-- Contact Upload Section Footer JS End-->



         <?php
          if(
            $view['section'] == 'report_credit_expense' || 
            $view['section'] == 'report_credit_expense_by_date' ||
            $view['section'] == 'report_credit_buy' ||
            $view['section'] == 'report_credit_buy_by_date' ||
            $view['section'] == 'report_package_buy' ||
            $view['section'] == 'report_package_buy_by_date' ||
            $view['section'] == 'report_daily_limit_expense' ||
            $view['section'] == 'report_daily_limit_expense_by_date' || 
            $view['section'] == 'report_invoice' || 
            $view['section'] == 'report_invoice_by_date'
            )
                    {
          ?>
              <script type="text/javascript">
                        $('.date-picker').datepicker();
                        $('.date-picker').on('change', function(ev){
                            $(this).datepicker('hide');
                        });

                        
                    </script>
          <?php 
            }
          ?>



           <?php
          if($view['section'] == 'dashboard')
                    {
          ?>

<script src="<?php echo base_url();?>assets/pages/scripts/highchart/highchart.js"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/highchart/exporting.js"></script>

          <script type="text/javascript">
            $(function () {
                    $('#transaction_heighchart').highcharts({
                        chart: {
                            type: 'areaspline'
                        },
                        title: {
                            text: 'Credit and Consumption Report'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            allowDecimals: false,
                            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
                        },
                        yAxis: {
                            title: {
                                text: 'Credit and Consumption Report'
                            },
                            labels: {
                                formatter: function() {
                                    return this.value / 1000 +'k';
                                }
                            }
                        },
                        tooltip: {
                            pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
                        },
                        plotOptions: {
                            area: {
                                pointStart: 1,
                                marker: {
                                    enabled: false,
                                    symbol: 'circle',
                                    radius: 2,
                                    states: {
                                        hover: {
                                            enabled: true
                                        }
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Credit',
                            data: [<?php echo $invoice_net_total_this_day; ?>]
                        }, {
                            name: 'Consumed',
                            data: [<?php echo $expense_total_this_day; ?>]
                        }]
                    });
                });
                


    function reset_highcharts()
    {
      console.log("changed");
      $('#transaction_heighchart').highcharts().reflow();
      $('#file_status_group_chart').highcharts().reflow();
    }


    $(".sidebar-toggler").click(function(){
        setTimeout(function() { reset_highcharts(); }, 100);
    });
    

    

                $(function () {
    $('#file_status_group_chart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Email Clean up Status'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
            <?php echo $total_dates; ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Contacts (number)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0;white-space:nowrap;">{series.name}: </td>' +
                '<td style="padding:0;white-space:nowrap;"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Email Uploaded',
            data: [<?php echo $total_contacts_chart; ?>]

        }, {
            name: 'Valid Emails',
            data: [<?php echo $total_successful_chart; ?>]

        }
        /*, {
            name: 'SMTP Exists',
            data: [<?php echo $total_smtp_clean_chart; ?>]

        }, {
            name: 'SMTP Not Exists',
            data: [<?php echo $total_failed_chart; ?>]

        }*/
        ]
    });
});


        </script>

<script src="<?php echo base_url(); ?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
          <?php 
            }
          ?>


         <?php
          if($view['section'] == 'file_upload_status')
                    {
          ?>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/highchart/highchart.js"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/highchart/highcharts-3d.js"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/highchart/exporting.js"></script>

<script type="text/javascript" src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
    
  
    
      <!--<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/base64.js"></script>
    
  
    
      <script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>-->


              
              <script type="text/javascript">
              /*
              $(".downalod_as_image").click(function(){
                container = $(this).attr("data-container");
                $(function() { 
                      html2canvas($(container), {
                          onrendered: function(canvas) {
                              theCanvas = canvas;
                              //document.body.appendChild(canvas);
                              img_link = canvas.toDataURL("image/png"); 
                              //$("#img-out").append(img);
                              // Clean up 
                              //document.body.removeChild(canvas);
                              $("#download_preview_image").attr("src",img_link);
                          }
                      });
              }); 

              });
*/


              $(function(){
                Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
              });

      function show_validation_pie_chart(validation_chart_data,validation_chart_data_title,container)
      {
          /*
          var validation_chart_data_array_genarate = [];
          for(i=0;i<validation_chart_data.length;i++)
          {
            validation_chart_data_array_genarate[i] = [];
            validation_chart_data_array_genarate[i]
          }
          */

          $(container).highcharts({
              chart: {
                  type: 'pie',
                  options3d: {
                      enabled: true,
                      alpha: 45,
                      beta: 0
                  }
              },
              title: {
                text: validation_chart_data_title
              },
              tooltip: {
                  pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
              },
              plotOptions: {
                  pie: {
                      allowPointSelect: true,
                      cursor: 'pointer',
                      depth: 35,
                      dataLabels: {
                          enabled: true,
                          format: '<b>{point.name}</b>: {point.y}'
                      }
                  }
              },
              series: [{
                  type: 'pie',
                  name: 'File Demograph',
                  data: validation_chart_data

                  /*[
                      {
                          name: 'Failed',
                          y: failed,
                          sliced: true,
                          selected: true
                      },
                      [validation_chart_data[0][0], validation_chart_data[0][1]],
                      [validation_chart_data[1][0], validation_chart_data[1][1]],
                      [validation_chart_data[2][0], validation_chart_data[2][1]],
                      //['SMTP Not Exists', validation_chart_data[2][1]-validation_chart_data[13][1]],
                      [validation_chart_data[3][0], validation_chart_data[3][1]],
                      [validation_chart_data[4][0], validation_chart_data[4][1]],
                      [validation_chart_data[5][0], validation_chart_data[5][1]],
                      [validation_chart_data[6][0], validation_chart_data[6][1]],
                      [validation_chart_data[7][0], validation_chart_data[7][1]],
                      [validation_chart_data[8][0], validation_chart_data[8][1]],
                      [validation_chart_data[9][0], validation_chart_data[9][1]],
                      [validation_chart_data[11][0], validation_chart_data[11][1]],
                      [validation_chart_data[12][0], validation_chart_data[12][1]]
                  ]
                  */
              }]
          });
          
      }

      $(window).load(function(){
          for (i = 0; i < validation_chart_data_conatiner.length; i++) {
            console.log("created "+validation_chart_data_conatiner[i]);
            show_validation_pie_chart(validation_chart_data[i],validation_chart_data_title[i],validation_chart_data_conatiner[i]);
          }
      });
      $(window).resize(function(){
          setTimeout(function() { 
            for (i = 0; i < validation_chart_data_conatiner.length; i++) {
              console.log("Resized "+validation_chart_data_conatiner[i]);
              show_validation_pie_chart(validation_chart_data[i],validation_chart_data_title[i],validation_chart_data_conatiner[i]);
              //show_validation_pie_chart(validation_chart_data_total[i],validation_chart_data_successful[i],validation_chart_data_failed[i],validation_chart_data_invalid[i],validation_chart_data_conatiner[i]);
            }
           }, 100);
          
      });

function show_pie_chart(file_name,id,total,successful,failed,invalid,invalid_from_api,carrier_json,carrier_type_json,state_json,city_json,country_json,event) {


        event.preventDefault();
        
        console.log(carrier_json);
        //carrier_json_data = document.getElementById(carrier_json).innerHTML;
        
        //carrier_jsonObj = $.parseJSON(carrier_json_data);
        //carrier_jsonObj = JSON.parse(carrier_json_data);
        //console.log(carrier_json_data);
        $("#chart_modal").modal("show");
        document.getElementById("carrier_chart_container").innerHTML = "";
        document.getElementById("carrier_type_chart_container").innerHTML = "";
        document.getElementById("state_chart_container").innerHTML = "";
        document.getElementById("city_chart_container").innerHTML = "";

        $('#chart_modal').on('shown.bs.modal', function () {
//$(this).parent().animate({scrollTop:$(this).offset().top+"px"},500);
//$(this).modal("show");
    // Radialize the colors
    

    // Build the chart
    document.getElementById('chart_file_name').innerHTML = file_name;
    document.getElementById('chart_total').innerHTML = total;
    document.getElementById('chart_successful').innerHTML = successful;
    document.getElementById('chart_failed').innerHTML = failed;

    $('#contact_chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Contacts Validation Chart'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Brands',
            data: [
                { 
                    name: 'Successful',
                    y: successful 
                },
                {
                    name: 'Invalid',
                    y: invalid
                },
                {
                    name: 'Invalid from API',
                    y: invalid_from_api
                }
            ]


            
        }]
    });



    $('#carrier_chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Carrier Chart'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Brands',
            data: carrier_json


            
        }]
    });



    $('#carrier_type_chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Carrier Type Chart'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Brands',
            data: carrier_type_json


            
        }]
    });


    $('#state_chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'State Chart'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Brands',
            data: state_json


            
        }]
    });


    $('#city_chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'City Chart'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} ',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Brands',
            data: city_json


            
        }]
    });





});
}
/*
                { name: 'Successful', y: 75 },
                {
                    name: 'Invalid',
                    y: 20
                },
                {
                    name: 'Invalid from API',
                    y: 15
                }
*/

                    </script>
          <?php 
            }
          ?>




         <?php
          if($view['section'] == 'contact_upload_section')
                    {
          ?>

          <script type="text/javascript">
          function getInputSelection(el) {
    var start = 0, end = 0, normalizedValue, range,
        textInputRange, len, endRange;

    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
    } else {
        range = document.selection.createRange();

        if (range && range.parentElement() == el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\r\n/g, "\n");

            // Create a working TextRange that lives only in the input
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());

            // Check if the start and end of the selection are at the very end
            // of the input, since moveStart/moveEnd doesn't return what we want
            // in those cases
            endRange = el.createTextRange();
            endRange.collapse(false);

            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\n").length - 1;

                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                }
            }
        }
    }

    return {
        start: start,
        end: end
    };
}

function offsetToRangeCharacterMove(el, offset) {
    return offset - (el.value.slice(0, offset).split("\r\n").length - 1);
}

function setInputSelection(el, startOffset, endOffset) {
    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        el.selectionStart = startOffset;
        el.selectionEnd = endOffset;
    } else {
        var range = el.createTextRange();
        var startCharMove = offsetToRangeCharacterMove(el, startOffset);
        range.collapse(true);
        if (startOffset == endOffset) {
            range.move("character", startCharMove);
        } else {
            range.moveEnd("character", offsetToRangeCharacterMove(el, endOffset));
            range.moveStart("character", startCharMove);
        }
        range.select();
    }
}






          function instant_check_numbers_validation(numbers)
          {

            numbers = numbers.replace(/[^\d,]/g,'');
            numbers_array = numbers.split(",");
            
              keep_invalid_data = "";
              if(numbers.length > 0)
              {
                for(i=0;i<numbers_array.length;i++)
                {
                  if(numbers_array[i].length == 11 || numbers_array[i].length == 10)
                  {
                    if(numbers_array[i].length == 11)
                    {
                      check = numbers_array[i].substring(0, 1);
                      if(check != "1")
                      keep_invalid_data = keep_invalid_data+'<span>'+numbers_array[i]+'</span>';
                    }
                  }
                  else
                  {
                    keep_invalid_data = keep_invalid_data+'<span>'+numbers_array[i]+'</span>';
                  }
                }
              }
              console.log(keep_invalid_data);
              return keep_invalid_data;
          }

          function instant_check_field_validation(){

             var t = document.getElementById("instant_check_field");
              var sel = getInputSelection(t);
              var data = t.value;
              data = data.replace(/[^\d,]/g,'');
              t.value = data;
              setInputSelection(t, sel.end, sel.end);
             /*data = document.getElementById("instant_check_field").value;
             data = data.replace(/[^\d,]/g,'');
             document.getElementById("instant_check_field").value = data;
             /*console.log(data);
             data_array = [];
             data_array = data.split(",");
             //console.log(data_array.length);
             data_str = data_array.join('</span>,<span class="invalid_in_instant_check">');
             data_str = '<span class="invalid_in_instant_check">'+data_str+'</span>';
             document.getElementById("instant_check_field_validation_show").innerHTML = data_str;
             //console.log(data_str);*/
          }
            function instant_check_request(data){

              //document.location.href = base_url+'sendInstantCheckupRequest/'+data;
//console.log(data);
dataSend = [];
dataSend[0] = data;
jsonDataSend = JSON.stringify(dataSend);
console.log(jsonDataSend);
                                        $.ajax({
                                            /*type: 'post',
                                            dataType: 'JSON',
                                            data : {data : jsonDataSend},
                                            url: base_url+'sendInstantCheckupRequest',*/
                                            type: 'GET',
                                            dataType: 'JSON',
                                            data: data,
                                            url: 'http://205.134.243.198:3001/search',
                                            success:function(result){
                                                //alert(data);
                                                console.log(result);
                                                
                                                result_json = JSON.stringify(result,undefined,4);
                                                

                                                //document.getElementById("instant_check_field_request").innerHTML = base_url+'sendInstantCheckupRequest';
                                                document.getElementById("instant_check_field_response").innerHTML = result_json;
                                                custom_spinner_hide();
                                                $("#instant_check_field_respose_con").slideDown("slow");
                                                
                                             }
                                          });




            }
            $("#instant_check_form").submit(function(e){
              e.preventDefault();
              //console.log("here");
              form = $(this);
              $("#instant_check_field_respose_con").slideUp("slow");
              submit_btn = form.find('.submit_btn');
              submit_btn_text = submit_btn.html();
              submit_btn.html('<i class="fa fa-spin fa-circle-o-notch"></i> '+submit_btn_text);
              submit_btn.attr('type','button').addClass('disabled');
              instant_check_field = document.getElementById("instant_check_field").value;
              data_email = instant_check_field;
              //dataSend = [];
//dataSend[0] = data;
//jsonDataSend = JSON.stringify(dataSend);
console.log(data_email);
                                        $.ajax({
                                            type: 'GET',
                                            dataType: 'JSON',
                                            data: {
                                                email: data_email
                                            },
                                            url: 'http://205.134.243.198:3001/search',
                                            success:function(result){
                                                //alert(data);
                                                submit_btn.html(submit_btn_text);
                                                submit_btn.attr('type','submit').removeClass('disabled');
                                                console.log(result);
                                                //alert(result);
                                                
                                                result_json = JSON.stringify(result,undefined,4);
                                                

                                                //document.getElementById("instant_check_field_request").innerHTML = base_url+'sendInstantCheckupRequest/';
                                                document.getElementById("instant_check_field_response").innerHTML = result_json;
                                                custom_spinner_hide();
                                                $("#instant_check_field_respose_con").slideDown("slow");
                                                
                                             }
                                          });


               console.log("here");
            });

          </script>

        <?php 
            }
          ?>

          <?php
          if($view['section'] == 'report_instant_lookup')
                    {
          ?>
            <script type="text/javascript">
              $(".response_show_in_pre").each(function(){
                  data = $(this).html();
                  var obj_array = $.parseJSON(data);
                  
                  obj = JSON.stringify(obj_array,undefined,4);
                  $(this).html(obj);
                  if($(this).height()>150)
                  {
                    $(this).parent().children(".see_more_container").append('<a class="response_pre_full_height" href="#">[..See more..]</a>');
                    $(this).css({"height":"150px","overflow":"hidden","transition":".5s"});
                  }
              });

              $(document).on("click",".response_pre_full_height",function(event){
                event.preventDefault();
                $(this).parent().parent().children(".response_show_in_pre").css({"height":"auto","transition":".5s"});
                $(this).addClass("response_pre_fixed_height").removeClass("response_pre_full_height");
              });

              $(document).on("click",".response_pre_fixed_height",function(event){
                event.preventDefault();
                $(this).parent().parent().children(".response_show_in_pre").css({"height":"150px","transition":".5s"});
                $(this).addClass("response_pre_full_height").removeClass("response_pre_fixed_height");
              });

            </script>

          <?php
          }
          ?>



          <?php
          if($view['section'] == 'buy_credit')
                    {
          ?>
          <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
          <script type="text/javascript">
              //Stripe.setPublishableKey('pk_test_wRl9xX9XsOj1fUSwzsebPV05'); // test publishable key
              Stripe.setPublishableKey('pk_live_oPE2lWuZcUJy3DNDAIh6aPvU'); //live publishable key
              $(function() {
                var $form = $('#payment-form');
                $form.submit(function(event) {
                    if(changePrice) {
                        changePrice();
                    }
                  // Disable the submit button to prevent repeated clicks:
                  price_during_buy = document.getElementById("price_during_buy").innerHTML;
                  credit_count = document.getElementById("credit_count").value;
                  credit_count = parseInt(credit_count); if(isNaN(credit_count)) credit_count=0;
                  price_during_buy = parseInt(price_during_buy); if(isNaN(price_during_buy)) price_during_buy=0;
                  //alert(price_during_buy);
                  document.getElementById("credit_count").value=credit_count;
                  if(price_during_buy < 47)
                  {
                    $form.find('.payment-errors').text("You have to buy credits of at least $47.");
                    
                  }
                  else
                  {
                    $form.find('.submit').prop('disabled', true);

                    // Request a token from Stripe:
                    Stripe.card.createToken($form, stripeResponseHandler);
                  }
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
                  console.log("here");
                  $form.get(0).submit();
                }
              };
          </script>

          <script type="text/javascript">
            function set_total_price_during_buy(unit,credit)
            {
              unit = parseFloat(unit);
              credit = parseInt(credit);
              if(isNaN(credit))
                credit = 0;
              price = unit*credit;
              price = price.toFixed(2);
              document.getElementById("price_during_buy").innerHTML = price;
              document.getElementById("price_during_buy").innerHTML = price;
            }

            </script>

          <?php
          }
          ?>