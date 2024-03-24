<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RISE PO-Monash Application</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery-ui/themes/base/minified/jquery-ui.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- Theme style -->
        <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/AdminLTE.min.css"> -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/bootstrap-clockpicker.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/tooltipster.bundle.css">

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
    </head>
    <style>
    @media print{
        .noprint{
            display:none;
        }
    @page { margin: 0; }
    body { margin: 1.6cm; }
    }
    h6 {
        /* display: block; */
        /* position: relative; */
        padding: 5px 15px 0 15px;
        /* background-color: #08C; */
        font-size: 20px;
        color: white;
    }
    .tab1 { tab-size: 2; }
    .table tbody tr.active td,
    .table tbody tr.active th {
        background-color: #08C;
        color: white;
        /* cursor: pointer; */
    }

    </style>
    <body class="hold-transition skin-red-light sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url() ?>index.php/welcome" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">R<b>PM</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">RISE|<b>POMO</b></span>
                    <!-- <span class="logo-lg">RISE|<b><mark>LIMS</mark>2.0</b></span> -->
                    <!-- <span class="logo-lg">RISE|<b><span style="background-color: #FFFFFF; color: #000000">LIMS</span>2.0</b></span> -->
                    
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">                          
                            <!-- User Account: style can be found in dropdown.less -->
                            <!-- <ul class="nav navbar-nav navbar-right"> -->
                            <!-- <input type="hidden" id="id_lab" value=<?php //$this->session->userdata('lab') ?>> -->
                            <?php 
                                // $id_user_level = $this->session->userdata('id_user_level');
                                // $sql_menu = "SELECT * 
                                // FROM tbl_menu 
                                // WHERE id_menu in(select id_menu from tbl_hak_akses where id_user_level=$id_user_level) and is_main_menu=0 and is_aktif='y'";                            
                                //Notification Dropdown
                                // if($id_user_level!='3'){
                                //     echo "<li class=\"dropdown\">";
                                //     echo "<a href=\"\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"label label-pill label-danger count\" style=\"border-radius:10px;\"> </span> <span class=\"glyphicon glyphicon-bell\" style=\"font-size:18px;\"></span></a>";
                                //     echo "<ul class=\"dropdown-menu notif-panel\"> </ul>";
                                // }
                            ?>
                            <!-- <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"> </span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
                            <ul class="dropdown-menu notif-panel"> </ul> -->
                            </li>
                            <!-- </ul> -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url() ?>assets/foto_profil/<?php echo $this->session->userdata('images'); ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $this->session->userdata('full_name'); ?> </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url() ?>assets/foto_profil/<?php echo $this->session->userdata('images'); ?> " class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $this->session->userdata('full_name'); ?>                                         
                                            <small><?php echo $this->session->userdata('email'); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php echo anchor('tbl_user_profile', 'Profile', array('class' => 'btn btn-warning btn-flat')); ?>
                                            <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                                        </div>
                                         <div class="pull-left">
                                            <!-- <button id="btn1">Alert</button> -->
                                        </div>
                                        <!-- <div class="pull-left">
                                            <?php //echo anchor('tbl_user_profile', 'Indonesia', array('class' => 'btn btn-default btn-flat')); ?>
                                        </div>
                                        <div class="pull-left">
                                            <?php //echo anchor('auth/logout', 'Fiji', array('class' => 'btn btn-default btn-flat')); ?>
                                        </div> -->
                                        <div class="pull-right">
                                            <?php echo anchor('auth/logout', 'Logout', array('class' => 'btn btn-danger btn-flat')); ?>
                                            <!--<a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- <marquee behavior="scroll" direction="left" scrollamount="30">
                        <h6><i class='fa fa-qrcode'></i><b> Indonesia</b> Lab data </h6>
                    </marquee> -->
                    <?php 
 
                        if ($this->session->userdata('lab') == 1) {
                            // echo "<span class=\"\"><b>Welcome to the LIMS2.0</b>RISE Indonesia</span>
                            // <h6><i class='fa fa-flag'></i> Indonesia Lab data </h6>
                            echo "<h6><i class='fa fa-qrcode'></i> Indonesia Accounting </h6>";
                        }
                        else {
                            echo "<h6><i class='fa fa-qrcode'></i> Fiji Accounting </h6>";
                            // echo "<span class=\"\"><b>Welcome to the LIMS2.0</b>RISE Fiji</span>";
                        }
                    ?>


                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php $this->load->view('template/sidebar'); ?>
            </aside>

            <?php
            echo $contents;
            ?>


            <!-- /.content-wrapper -->
            <div class="noprint">
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.1.0
                </div>
                <strong><img src="../img/lims_logo4.png" height='25px' onerror="this.src='../../../img/lims_logo4.png'">  Copyright &copy; 2023-2024 POMO-RISE | 
                <a href="https://www.linkedin.com/in/zainal-enal-452b4414a/" target="_blank">RISE Data Team</a>.</strong> All rights reserved.
            </footer>
            </div>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Application Information</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-free-code-camp bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Objectives</h4>

                                        <p>Contain a module from RISE objectives activities (O3, O2A and O2B)</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-refresh bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Process</h4>

                                        <p>A module to processing sample from the field such as Water, DNA, Freezer and Sample External </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-text bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Reports</h4>

                                        <p>Contain a module to print a report</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-table bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Master</h4>

                                        <p>A module to entry master data such as Person, Sample type, DNA sample, etc.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Objectives progress
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Processing
                                        <span class="label label-warning pull-right">100%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 100%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        History Reports
                                        <span class="label label-primary pull-right">100%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 100%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Master Integration
                                        <span class="label label-success pull-right">50%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Some information about this general settings option
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Allow mail redirect
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Other sets of options are available
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Expose author name in posts
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Allow the user to show his name in blog posts
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Chat Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Show me as online
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Turn off notifications
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Delete chat history
                                    <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-clockpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/jquery-ui/ui/minified/jquery-ui.min.js"></script>
        <!-- jQuery 3
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
         -->
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>assets/adminlte/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url() ?>assets/adminlte/dist/js/demo.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url() ?>assets/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>

        <script src="<?php echo base_url() ?>assets/adminlte/dist/js/tooltipster.bundle.js"></script>
        <!-- page script -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
        <script>

            //Notif ================

        $(document).ready(function(){

            // $("#btn1").click(function() {
            //     alert("Lab ID :" + $("#id_country").val());
                // $this->session->userdata('lab');
                // $this->session->set_userdata('lab',  $('#id_country').val());
            // });

        
            // function load_unseen_notification(view = '')
            // {
            // $.ajax({
            //     url: "<?php echo base_url()?>index.php/kelolamenu/notif",
            //     method:"POST",
            //     // data:{view:view},
            //     dataType:"json",
            //     success:function(data)
            //     {
            //         $('.notif-panel').html(data.notification);
            //         if(data.unseen_notification > 0)
            //         {
            //         $('.count').html(data.unseen_notification);
            //         }
            //     }
            // });
            // }
            
            // load_unseen_notification();

            // $(document).on('click', '.dropdown-toggle', function(){
            //     $('.count').html('');
            //     load_unseen_notification('yes');
            // });
            
            // setInterval(function(){ 
            //    load_unseen_notification();
            // }, 60000);

        });
            //================

            // $(function () {
            //     $('.select2').select2()
            //     $('#example1').DataTable()
            //     $('#example2').DataTable({
            //         'paging'      : true,
            //         'lengthChange': false,
            //         'searching'   : false,
            //         'ordering'    : true,
            //         'info'        : true,
            //         'autoWidth'   : false
            //     })
            // })
        </script>
    </body>
</html>
