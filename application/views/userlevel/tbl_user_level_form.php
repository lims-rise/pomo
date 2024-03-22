<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA LEVEL USER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <table class='table table-bordered>'>        
                    <tr>
                    <td width='200'>Level name<?php echo form_error('nama_level') ?></td>
                        <td><input type="text" class="form-control" name="nama_level" id="nama_level" placeholder="Level name" value="<?php echo $nama_level; ?>" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="id_user_level" value="<?php echo $id_user_level; ?>" /> 
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('userlevel') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Close</a>
                        </td>
                    </tr>
                </table>
            </form>        
        </div>
    </section>
</div>