<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">USER PROFILE</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                <table class='table table-bordered'>        
                    <tr>
                        <td width='200'>Full Name <?php echo form_error('full_name') ?></td>
                        <td>
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width='200'>Email <?php echo form_error('email') ?></td>
                        <td>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width='200'>Password <?php //echo form_error('password') ?></td>
                        <td>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" required/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close bt1" style="cursor:pointer"></span>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width='200'>Confirm Password <?php //echo form_error('password') ?></td>
                        <td>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm Password" value=""/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close bt2" style="cursor:pointer"></span>
                        </div>
                        </td>
                    </tr>

                    <tr>
                        <td width='200'>Profile Picture <?php //echo form_error('images') ?></td>
                        <td> 
                        <!-- <input type="file" name="images"> -->
                        <div class="col-sm-4">
								<input type="file" name="images" class="images" id=filex accept="image/*">
									<div class="input-group my-3"> 
									<!-- <input type="hidden" class="form-control" disabled placeholder="Upload File" id="receipt"> -->
									</div>
									<!-- <img src="../img/white.jpg" id="preview" class="img-thumbnail"> -->
									<?php
										if (empty($images)) {
										    $photo = base_url("assets/receipt/no_image.jpg");
										}
										else {
											$photo = base_url("assets/foto_profil/". $images);
										}
										echo "<img id='preview' src='$photo' class='img-thumbnail' alt='Image Receipt'>";
										?>
								<p class="help-block">*File types allowed only JPG | PNG | GIF files <?php //echo $images ?></p>
								<!-- <input type="submit" value="Upload File" /> -->
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="id_users" value="<?php echo $id_users; ?>" /> 
                            <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i> Update <?php //echo $button ?></button> 
                            <a href="<?php echo site_url('welcome') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Close</a>
                        </td>
                    </tr>
                </table>
            </form>        
        </div>
</div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

<script type="text/javascript">

$(document).ready(function() {

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
        });    

    $(".bt2").bind("click", function() {
        if ($('#password2').attr('type') =='password'){
            $('#password2').attr('type','text');
            $('.bt2').removeClass('glyphicon-eye-close');
            $('.bt2').addClass('glyphicon-eye-open');
        }else if($('#password2').attr('type') =='text'){
            $('#password2').attr('type','password');
            $('.bt2').removeClass('glyphicon-eye-open');
            $('.bt2').addClass('glyphicon-eye-close');
        }
        });    


	$(document).on("click", ".browse", function() {
		var file = $(this).parents().find(".file");
		file.trigger("click");
	});

    $("#password2").on("change", function() {
        if ($("#password2").val() != $("#password").val()){
            $("#password").val("");
            $("#password2").val("");
        }
    });

$('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#images").val(fileName);
    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
});

}
);

</script>
