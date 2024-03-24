<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>POMO Application</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" 
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                <!-- href="<?php //echo base_url() ?>assets/adminlte/dist/css/googleapis.css/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
        <style>
        #myVideo {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
                }
                .container {
                position: relative;
                }
            .card{
                background-color: #ffffff52 !important;
            }
            .h1{
                color: black !important;
            }

            .form-group label {
                font-size: 14px;
                color: #000000 !important;
                margin-bottom: 4px;
            }

            @keyframes glowing {
                0% { color: red; text-shadow: 0 0 10px red; }
                50% { color: orange; text-shadow: 0 0 20px orange; }
                100% { color: red; text-shadow: 0 0 10px red; }
            }

            .blinking {
                animation: blinking 2s infinite, glowing 2s infinite;
            }
            
        /* CSS to make the image cover the entire screen */
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }

        /* #toggleButton {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }         */
/* 
        .video-container {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            overflow: hidden; 
        } */

        /* Style the play/pause button */
        #toggleButton {
            position: absolute;
            bottom: 20px; /* Adjust this value to position the button vertically */
            right: 20px; /* Adjust this value to position the button horizontally*/
            /* background-color: #4CAF50; */
            background-color: transparent; 
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            z-index: 999; /* Ensure the button stays above the video*/
        } 


    </style>
    </head>

    <!-- <video autoplay muted loop id="myVideo">
        <source src="../img/dna.mp4" type="video/mp4">
    </video> -->

    <body class="hold-transition login-page">

    <div class="video-container">
        <video autoplay muted loop id="myVideo">
            <source src="../img/accnt.mp4" type="video/mp4">
        </video>
        <!-- Toggle switch -->
        <button id="toggleButton"><i class="fa fa-pause"></i></button>
        <!-- <label class="switch">
            <input type="checkbox" id="toggleButton">
             <span class="slider round"></span>
        </label> -->

    </div>
        
        <style>h1{
            color:white;
            font-size:55px;
            }
        </style>
        <!-- <div class="login-box"> -->
        <!-- </div> -->
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body" style="text-align: center;">
            <h1><div id="time"></div></h1>
            <div class="login-logo">
                <!-- <a href="<?php //echo base_url(); ?>"> -->
                <!-- <b><mark>LIMS</mark>2.0</b>|LOGIN -->
                <!-- <img src="../img/lims_logo2.png"> -->
                <!-- <b><span style="background-color: #bab8b8; color: #000000">ONE</span>WATER</b>|LOGIN -->
                <b>POMO</b>|LOGIN
            <!-- </a> -->
            </div>
            <!-- <span id="typed-text"></span> -->

                <?php
                $status_login = $this->session->userdata('status_login');
                if (empty($status_login)) {
                    // $message = "Laboratory Information Management System v.2.0";
                    $message = "Please enter your username and password";
                } else {
                    $message = $status_login;
                    $messageClass = 'blinking';
                }
                ?>
                <p class="login-box-msg <?php echo isset($messageClass) ? $messageClass : ''; ?>" style="font-size: 16px;"><?php echo $message; ?></p>


                <?php echo form_open('auth/cheklogin'); ?>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <!-- <div class="col-sm-4"> -->
                        <!-- <input type="password" class="form-control" name="password" placeholder="Password"> -->
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close bt1" style="cursor:pointer"></span>
                        <!-- </div> -->
                          <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                        <!-- <div class="col-xs-2">
                            <button type="submit" class="btn btn-danger btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                        </div> -->
                    </div>
                    <!-- <button type="submit" class="btn btn-danger btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button> -->
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                        <!-- <a href="auth/blokir_akses">Forget password?</a> -->

                    </div>
                    <!-- <div class="col-xs-4"> -->
                        <!-- For RISE only -->
                        <!-- <button type="submit" class="btn btn-warning btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button> -->
                    <!-- </div> -->
                    <div class="col-xs-8">
                        <p class="login-box-msg" style="text-align: right;">
                        <!-- Only for  -->
                        <a href="https://rise-program.org/" target="_blank">
                            <!-- RISE Program XXXXX -->
                            <span><img src="../assets/img/Project4.png" height='25px'></span>
                            </a>
                        </p>
                        <?php //echo anchor('#', '<i class="fa fa-eye-slash" aria-hidden="true"></i> Forget Password?', array('class' => 'btn btn-primary btn-block btn-flat')); ?>
                    </div>
                </div>

                </form>

                        <a href="#" id='addtombol'>Forget password?</a>

            </div>
            <!-- /.login-box-body -->
        </div>

    <!-- MODAL FORM -->
    <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header box">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Forget password?</h4>
                </div>
                <!-- <form id="formSample"  action= <?php //echo site_url('Auth/forgetpassword') ?> method="post" class="form-horizontal"> -->
                <form id="formSample" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                        <input id="mode" name="mode" type="hidden" class="form-control input-sm">
                            <label for="email" class="col-sm-4 control-label">Enter your POMO login email</label>
                            <div class="col-sm-8">
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" required>
                                <!-- <div class="val1tip"></div> -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div id="quickMessage" class="form-group"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Request code</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->        


    <!-- MODAL FORM 2-->
    <div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header box">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Reset Password</h4>
                </div>
                <form id="formSample"  action= <?php echo site_url('Auth/savepassword') ?> method="post" class="form-horizontal">
                    <div class="modal-body">
                        <p>6 digit Code has been sent to your email, please check your email</p>
                        <hr>
                        <input id="emailsend" name="emailsend" type="hidden" class="form-control input-sm">
                        <div class="form-group">
                            <label for="code" class="col-sm-4 control-label">Your Code?</label>
                            <div class="col-sm-8">
                                <input id="code" name="code" type="text" class="form-control" placeholder="Insert your code here" required>
                                <!-- <div class="val1tip"></div> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_pass" class="col-sm-4 control-label">New password</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="new_pass" name="new_pass" type="password" class="form-control" placeholder="New password" required>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close bt1" style="cursor:pointer"></span>
                                    <!-- <div class="val1tip"></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="re_pass" class="col-sm-4 control-label">Retype password</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="re_pass" name="re_pass" type="password" class="form-control" placeholder="Retype password" required>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close bt1" style="cursor:pointer"></span>
                                    <!-- <div class="val1tip"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Reset password</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->        

    
        <!-- /.login-box -->

        <!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/assets/adminlte/plugins/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>

<!-- <script src="<?php //echo base_url(); ?>assets/js/jquery.backstretch.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/js/templatemo-script.js"></script> -->
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var video = document.getElementById('myVideo');
        var button = document.getElementById('toggleButton');

        // Toggle play/pause on button click
        button.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                button.innerHTML = '<i class="fa fa-pause"></i>';
            } else {
                video.pause();
                button.innerHTML = '<i class="fa fa-play"></i>';
            }
        });
    });
                
    // Add event listener for toggle switch
    // document.getElementById('toggleButton').addEventListener('change', function() {
    //     var video = document.getElementById('myVideo');
    //     if (this.checked) {
    //         video.play();
    //     } else {
    //         video.pause();
    //     }
    // });

    $(document).ready(function() {

        // var options = {
        //     strings: ["Human samples (Blood and Feces)", "Enviroment samples (Water, Sedimen, Bootsock, Animal Feces)", "Ecology samples (Mosquito and Pupae)", "DNA Extraction, DNA Analysis and DNA Consentration"], // Array of strings to be typed
        //     typeSpeed: 100, // Typing speed in milliseconds
        //     loop: true // Whether to loop through the strings
        // };

        // var typed = new Typed('#typed-text', options);
        // document.getElementById('toggleButton').addEventListener('change', function() {
        //     var video = document.getElementById('myVideo');
        //     if (this.checked) {
        //         video.play();
        //     } else {
        //         video.pause();
        //     }
        // });
        var myVideo = document.getElementById("myVideo");
        if (myVideo.addEventListener) {
            myVideo.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            }, false);
        } else {
            myVideo.attachEvent('oncontextmenu', function() {
                window.event.returnValue = false;
            });
        }

        $('#code').on("change", function() {
            data1 = $('#code').val();
            data2 = $('#emailsend').val();
            $.ajax({
                type: "GET",
                url: "Auth/valid_code?id1="+data1+"&id2="+data2,
                dataType: "json",
                success: function(data) {
                    if (data.length == 0) {
                        $('#code').focus();
                        $('#code').val('');     
                        $('#code').css({'background-color' : '#FFE6E7'});
                        setTimeout(function(){
                            $('#code').css({'background-color' : '#FFFFFF'});
                            setTimeout(function(){
                                $('#code').css({'background-color' : '#FFE6E7'});
                                setTimeout(function(){
                                    $('#code').css({'background-color' : '#FFFFFF'});
                                }, 300);                            
                            }, 300);
                        }, 300);
                    }
                }
            });
        });

        // $('#email').on("change", function() {
        //     $('#emailsend').val($('#email').val());     
        // });

        $('#re_pass').on("change", function() {
            data1 = $('#new_pass').val();
            data2 = $('#re_pass').val();
            if (data1 != data2) {
                $('#re_pass').focus();
                $('#re_pass').val('');     
                $('#re_pass').css({'background-color' : '#FFE6E7'});
                setTimeout(function(){
                    $('#re_pass').css({'background-color' : '#FFFFFF'});
                    setTimeout(function(){
                        $('#re_pass').css({'background-color' : '#FFE6E7'});
                        setTimeout(function(){
                            $('#re_pass').css({'background-color' : '#FFFFFF'});
                        }, 300);                            
                    }, 300);
                }, 300);
            }
            });
        });

        $('#addtombol').click(function() {
            // $('.val1tip').tooltipster('hide');   
            $('#modal-title').html('<i class="fa fa-wpforms"></i> Forget Password ?<span id="my-another-cool-loader"></span>');
            $('#email').val('');
            $('#quickMessage').empty();
            $('#compose-modal').modal('show');
        });

        $('#formSample').submit(function(e) {
            $('#quickMessage').empty();
            var loadingMessage = $('<p></p>').addClass('text-info').text('Checking your email and sending your code, please wait...');
            $('#quickMessage').append(loadingMessage);

            $('#formSample button[type="submit"]').prop('disabled', true);
            e.preventDefault();
            // Get form data
            var formData = $(this).serialize();

            // Perform AJAX request to submit the form data
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('Auth/forgetpassword'); ?>',
                data: formData,
                dataType: 'json', // Change this based on your server response
                success: function(response) {
                    // Handle the server response here
                    // Show the second modal after the form is successfully submitted
                    if (response.status === 'success') {
                        // $('#responseMessage').html('<p class="text-' + response.status + '">' + response.message + '</p>');

                        $('#formSample button[type="submit"]').prop('disabled', false);
                        $('#modal-title').html('<i class="fa fa-wpforms"></i> Reset Password<span id="my-another-cool-loader"></span>');
                        $('#emailsend').val($('#email').val());
                        $('#code').val('');
                        $('#new_pass').val('');
                        $('#compose-modal').modal('hide');
                        $('#reset-modal').modal('show');
                    }
                    else {
                        // alert(response.message);
                        $('#quickMessage').empty();
                        var loadingMessage = $('<p></p>').addClass('text-info').text('Email not found, please enter the correct POMO login email');
                        $('#quickMessage').append(loadingMessage);
                        $('#email').val('');
                        $('#formSample button[type="submit"]').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error response here
                    console.error(xhr.responseText);
                }
            });
        });

        $(".bt1").bind("click", function() {
            if ($('#password').attr('type') =='password'){
                $('#password').attr('type','text');
                $('.bt1').removeClass('glyphicon-eye-close');
                $('.bt1').addClass('glyphicon-eye-open');
            }else if($('#password').attr('type') =='text'){
                $('#password').attr('type','password');
                $('.bt1').removeClass('glyphicon-eye-open');
                $('.bt1').addClass('glyphicon-eye-close');
            }

            if ($('#new_pass').attr('type') =='password'){
                $('#new_pass').attr('type','text');
                $('.bt1').removeClass('glyphicon-eye-close');
                $('.bt1').addClass('glyphicon-eye-open');
            }else if($('#new_pass').attr('type') =='text'){
                $('#new_pass').attr('type','password');
                $('.bt1').removeClass('glyphicon-eye-open');
                $('.bt1').addClass('glyphicon-eye-close');
            }                

            if ($('#re_pass').attr('type') =='password'){
                $('#re_pass').attr('type','text');
                $('.bt1').removeClass('glyphicon-eye-close');
                $('.bt1').addClass('glyphicon-eye-open');
            }else if($('#re_pass').attr('type') =='text'){
                $('#re_pass').attr('type','password');
                $('.bt1').removeClass('glyphicon-eye-open');
                $('.bt1').addClass('glyphicon-eye-close');
            }                

            });    

        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });


        $(function() {
            startTime();
            // $(".center").center();
            // $(window).resize(function() {
            //     $(".center").center();
            // });
        });

        /*  */
        function startTime()
        {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();

            // add a zero in front of numbers<10
            h = checkTime(h);
            m = checkTime(m);
            s = checkTime(s);

            //Check for PM and AM
            // var day_or_night = (h > 11) ? "PM" : "AM";

            //Convert to 12 hours system
            // if (h > 12)
            //     h -= 12;

            //Add time to the headline and update every 500 milliseconds
            // $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
            $('#time').html(h + ":" + m + ":" + s);
            setTimeout(function() {
                startTime()
            }, 500);
        }

        function checkTime(i)
        {
            if (i < 10)
            {
                i = "0" + i;
            }
            return i;
        }                        
    </script>
    </body>
</html>
