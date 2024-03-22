<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">USER DATA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <table class='table table-bordered'>        
                    <tr>
                        <td width='200'>Full Name <?php echo form_error('full_name') ?></td>
                        <td><input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>Email <?php echo form_error('email') ?></td>
                        <td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>Password <?php //echo form_error('password') ?></td>
                        <td><input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php // echo $password; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>User Level<?php echo form_error('id_user_level') ?></td>
                        <td><?php echo cmb_dinamis('id_user_level', 'tbl_user_level', 'nama_level', 'id_user_level', $id_user_level,'DESC') ?></td>
                    </tr>
                    <tr>
                        <td width='200'>Status <?php echo form_error('is_aktif') ?></td>
                        <td><?php echo form_dropdown('is_aktif', array('y' => 'Active', 'n' => 'Non Active'), $is_aktif, array('class' => 'form-control')); ?></td>
                    </tr>
                    <tr>
                        <td width='200'>Profile Picture <?php echo form_error('images') ?></td>
                        <td> <input type="file" name="images"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="id_users" value="<?php echo $id_users; ?>" /> 
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('user') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Close</a>
                        </td>
                    </tr>
                </table>
            </form>        
        </div>
    </section>
</div>