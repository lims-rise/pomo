<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">SETTING WALLPAPER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                <table class='table table-bordered'>        
                    <tr>
                        <td width='150'>Wallpaper 1 <?php //echo form_error('images') ?></td>
                        <td> 
                        <div class="col-sm-8">
                            <input type="file" name="images1" class="images" id=image1 accept="image/*">
									<div class="input-group my-3"> 
									</div>
									<?php
                                        $photo = base_url("img/candyhouse1.jpg");
										echo "<img id='preview1' src='$photo' class='img-thumbnail' alt='Wallpaper1'>";
										?>
							<p class="help-block">*File types allowed only JPG | PNG | GIF files</p>
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td width='150'>Wallpaper 2</td>
                        <td> 
                        <div class="col-sm-8">
                            <input type="file" name="images2" class="images" id=image2 accept="image/*">
									<div class="input-group my-3"> 
									</div>
									<?php
                                        $photo = base_url("img/candyhouse2.jpg");
										echo "<img id='preview2' src='$photo' class='img-thumbnail' alt='Wallpaper2'>";
										?>
							<p class="help-block">*File types allowed only JPG | PNG | GIF files</p>
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td width='150'>Wallpaper 3</td>
                        <td> 
                        <div class="col-sm-8">
                            <input type="file" name="images3" class="images" id=image3 accept="image/*">
									<div class="input-group my-3"> 
									</div>
									<?php
                                        $photo = base_url("img/candyhouse3.jpg");
										echo "<img id='preview3' src='$photo' class='img-thumbnail' alt='Wallpaper3'>";
										?>
							<p class="help-block">*File types allowed only JPG | PNG | GIF files</p>
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Update <?php //echo $button ?></button> 
                            <a href="<?php echo site_url('welcome') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
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


	$(document).on("click", ".browse", function() {
		var file = $(this).parents().find(".file");
		file.trigger("click");
	});

// $('input[type="file"]').change(function(e) {
$('#image1').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#images1").val(fileName);
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview1").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});

$('#image2').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#images2").val(fileName);
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview2").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});


$('#image3').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#images3").val(fileName);
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview3").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});

});

</script>
