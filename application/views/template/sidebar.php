<?php
if ($this->session->userdata('id_user_level') == "") {
    redirect(base_url());
    // echo base_url() . 'auth';
}
?>

<!-- <style>
.a1 {
    color: white !important;
    /* background-color: #9CDCFE !important; */
    text-align: left;
    /* font-weight: 1300; */
}
</style> -->

<!-- <ul class="a1"> -->
    <!-- <li> -->
<!-- <i class='fa fa-circle'></i>  -->
<!-- <div class="sidebar-form" style="text-align: left;"> -->
<!-- <h4 class="box-title"> -->
    <!-- Select Country LAB  -->
<!-- </h4> -->
<!-- </div> -->
    <!-- </li> -->
<!-- </ul> -->

<section class="sidebar">
<div class="sidebar-form" style="text-align: center;">
    <select id='id_country' name="id_country" class="form-control">
        <?php
        $lvl = $this->session->userdata('id_user_level');  
        if (($lvl == 1) | 
            ($lvl == 4) | 
            ($lvl == 7)) {
            if ($this->session->userdata('lab') == 1) {
                echo "<option value='1' selected='selected'>Indonesia</option>";
                echo "<option value='2'>Fiji</option>";
            }
            else {
                echo "<option value='1'>Indonesia</option>";
                echo "<option value='2' selected='selected'>Fiji</option>";
            }
        }
        else if (($lvl == 2) | 
            ($lvl == 5)) {
            echo "<option value='1' selected='selected'>Indonesia</option>";
        }
        else if (($lvl == 3) | 
            ($lvl == 6)) {
            echo "<option value='2' selected='selected'>Fiji</option>";
        }
            ?>
    </select>
    <input type="hidden" id="id_user" value="<?php echo $this->session->userdata('id_users')?>">
</div>


<!-- <h4 class="box-title" id="box-title"> CLOUDSHEAVEN.ID <span id="my-cool-loader"></span></h4> -->
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">         -->
        <!-- <div class="input-group"> -->
            <!-- <div style="text-align: right">
            <img src="../img/ch_bw.png" height="200px"/>
            </div> -->
            <!-- <h4 class="box-title" id="box-title"> CLOUDSHEAVEN.ID <span id="my-cool-loader"></span></h4> -->
            <!-- <input type="text" name="q" class="form-control" placeholder="Search..."> -->
            <!-- <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span> -->
        <!-- </div> -->
    <!-- </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <?php
        // chek settingan tampilan menu
        $setting = $this->db->get_where('tbl_setting',array('id_setting'=>1))->row_array();
        if($setting['value']=='ya'){
            // cari level user
            $id_user_level = $this->session->userdata('id_user_level');
            // if($id_user_level!=''){
                $sql_menu = "SELECT * 
                FROM tbl_menu 
                WHERE id_menu in (select id_menu from tbl_hak_akses 
                                    where id_user_level=$id_user_level) 
                                and is_main_menu=0 and is_aktif='y'";
            // }
            // else {
            //     echo base_url() . 'auth';
                // echo anchor('auth/logout',"<i class='fa fa-sign-out'></i> LOGOUT");
            // }
        }else{
            $sql_menu = "select * from tbl_menu where is_aktif='y' and is_main_menu=0";
        }

        $main_menu = $this->db->query($sql_menu)->result();
        
        foreach ($main_menu as $menu){
            // chek is have sub menu
            $this->db->where('is_main_menu',$menu->id_menu);
            $this->db->where('is_aktif','y');
            $this->db->order_by('id_menu', 'ASC');
            $submenu = $this->db->get('tbl_menu');
            if($submenu->num_rows()>0){
                // display sub menu
                echo "<li class='treeview'>
                    <a href='#'>
                        <i class='$menu->icon'></i> <span>".strtoupper($menu->title)."</span>
                        <span class='pull-right-container'>
                            <i class='fa fa-angle-left pull-right'></i>
                        </span>
                    </a>
                    <ul class='treeview-menu' style='display: none'>";
                    foreach ($submenu->result() as $sub){
                        if ($sub->icon == 'sep'){
                            echo "<hr>";
                        }
                        else {
                            echo "<li>".anchor($sub->url,"<i class='$sub->icon'></i> ".($sub->title))."</li>"; 
                        }
                        // echo "<li>".anchor($sub->url,"<i class='$sub->icon'></i> ".($sub->title))."</li>"; 
                    }
                    echo" </ul>
                </li>";
            }else{
                // display main menu
                echo "<li>";
                echo anchor($menu->url,"<i class='".$menu->icon."'></i> ".strtoupper($menu->title));
                echo "</li>";
            }
        }
        ?>
        <!-- <li><?php //echo anchor('auth/logout',"<i class='fa fa-sign-out'></i> LOGOUT");?></li> -->
    </ul>
    <!-- <ul> -->
            <!-- <footer class="main-footer"> -->
            <!-- <div class="pull-right hidden-xs">
                <b>Version</b> 2.1.0
            </div> -->
                <!-- <strong>Copyright &copy; 2022-2023 LIMS-RISE | </strong> -->
            <!-- </footer> -->
        <!-- </ul> -->

</section>

<!-- /.sidebar -->

<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>

<script type="text/javascript">
        // alert("country :" + $("#id_country").val());
$(document).ready(function(){

    $(function() {
        $("#id_country").change(function() {
            // alert("country change :" + $("#id_country").val());
            var id = $('#id_user').val();
            var id_lab = $('#id_country').val();
            document.location.href="kelolamenu/clab?id="+id+'&id_lab='+id_lab;
        // });
                        // $this->session->set_userdata('lab',  $('#id_country').val());
        });

        // startTime();
        // $(".center").center();
        // $(window).resize(function() {
        //     $(".center").center();
        // });
    });

    /*  */
    // function startTime()
    // {
    //     var today = new Date();
    //     var h = today.getHours();
    //     var m = today.getMinutes();
    //     var s = today.getSeconds();

    //     // add a zero in front of numbers<10
    //     m = checkTime(m);
    //     s = checkTime(s);

    //     //Check for PM and AM
    //     var day_or_night = (h > 11) ? "PM" : "AM";

    //     //Convert to 12 hours system
    //     if (h > 12)
    //         h -= 12;

    //     //Add time to the headline and update every 500 milliseconds
    //     $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
    //     setTimeout(function() {
    //         startTime()
    //     }, 500);
    // }

    // function checkTime(i)
    // {
    //     if (i < 10)
    //     {
    //         i = "0" + i;
    //     }
    //     return i;
    // }

    /* CENTER ELEMENTS IN THE SCREEN */
    // jQuery.fn.center = function() {
    //     this.css("position", "absolute");
    //     this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
    //             $(window).scrollTop()) - 30 + "px");
    //     this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
    //             $(window).scrollLeft()) + "px");
    //     return this;
    // }
});

</script>