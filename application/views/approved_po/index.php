<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-black box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Purchase Order | Budget Approved</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
		<?php echo anchor(site_url('Approved_po/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to CSV', 'class="btn btn-success"'); ?></div>
        <table class="table table-bordered table-striped tbody" id="mytable" style="width:100%">
            <thead>
                <tr>
		    <th>Date request</th>
		    <th>Objectives</th>
		    <th>Title</th>
		    <th>Budget request</th>
		    <th>PO number</th>
		    <th>Date PO</th>
		    <th>Comments</th>
		    <th width="120px">Action</th>
                </tr>
            </thead>
	    
        </table>
        </div>
                    </div>
            </div>
            </div>
    </section>
<style>

.table tbody tr.selected {
    color: white !important;
    background-color: #9CDCFE !important;
}

</style>

    <!-- MODAL FORM -->
    <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header box">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Budget Request | New</h4>
                </div>
                <form id="formSample"  action= <?php echo site_url('Approved_po/save') ?> method="post" class="form-horizontal" enctype="multipart/form-data">>
                    <div class="modal-body">
                        <input id="mode" name="mode" type="hidden" class="form-control input-sm">
                        <input id="id_req" name="id_req" type="hidden" class="form-control input-sm">

                        <div class="form-group">
                            <label for="objective" class="col-sm-4 control-label">Objective</label>
                            <div class="col-sm-8">
                                <input id="objective" name="objective" type="text" class="form-control" placeholder="Objective" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-4 control-label">Title</label>
                            <div class="col-sm-8">
                                <input id="title" name="title" type="text" class="form-control" placeholder="Title" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="budged_req" class="col-sm-4 control-label">Budget Request</label>
                            <div class="col-sm-8">
                                <input id="Budget_req" name="Budget_req" type="text" class="form-control" placeholder="Budget Request">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="po_number" class="col-sm-4 control-label">PO Number</label>
                            <div class="col-sm-8">
                                <input id="po_number" name="po_number" type="text" class="form-control" placeholder="PO Number" required>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_po" class="col-sm-4 control-label">Date PO</label>
                            <div class="col-sm-8">
                                <input id="date_po" name="date_po" type="date" class="form-control" placeholder="Date PO" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">Comments</label>
                            <div class="col-sm-8">
                                <textarea id="comments" name="comments" class="form-control" placeholder="Comments"> </textarea>
                            </div>
                        </div>

                        <div class='form-group'>
						<label for='image' class='col-sm-4 control-label'>Approval email (SS)</label>
                            <div class='col-sm-8' style="margin-bottom:10px;">
                                <input id="iima" name="iima" type="text" class="form-control">
                                <input type="file" name="images" class="images" id="filex" accept="image/*">
                                        <div class="input-group my-3"> 
                                        <!-- <input type="hidden" class="form-control" disabled placeholder="Upload File" id="receipt"> -->
                                        </div>
                                        <!-- <img src="../img/white.jpg" id="preview" class="img-thumbnail"> -->
                                        <?php
                                            if (empty($images)) {
                                                $photo = base_url("assets/receipt/no_image.jpg");
                                            }
                                            else {
                                                $photo = base_url("assets/receipt/". $images);
                                            }
                                            echo "<img id='preview' src='$photo' class='img-thumbnail' alt='Image Receipt'>";
                                        ?>
                                    <p class="help-block">*File types allowed only JPG | PNG | GIF files <?php //echo $images ?></p>
                            </div>
					    </div>

                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->        

</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">

    var table
    $(document).ready(function() {

        // $('.clockpicker').clockpicker({
        // placement: 'bottom', // clock popover placement
        // align: 'left',       // popover arrow align
        // donetext: 'Done',     // done button text
        // autoclose: true,    // auto close when minute is selected
        // vibrate: true        // vibrate the device when dragging clock hand
        // });                

        $('.val1tip').tooltipster({
            animation: 'swing',
            delay: 1,
            theme: 'tooltipster-default',
            autoClose: true,
            position: 'bottom',
        });


        $("#compose-modal").on('hide.bs.modal', function(){
            $('.val1tip').tooltipster('hide');   
        });        

        $('#compose-modal').on('shown.bs.modal', function () {
            $('#po_number').focus();
            });

        $("input").keypress(function(){
            $('.val1tip').tooltipster('hide');   
        });

        $("input").click(function(){
            setTimeout(function(){
                $('.val1tip').tooltipster('hide');   
            }, 3000);                            
        });

        $('#po_number').on("change", function() {
            data1 = $('#po_number').val();
            $.ajax({
                type: "GET",
                url: "Approved_po/valid_bs?id1="+data1,
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        tip = $('<span><i class="fa fa-exclamation-triangle"></i> PO Number : <strong> ' + data1 +'</strong> is already in the system !</span>');
                        $('.val1tip').tooltipster('content', tip);
                        $('.val1tip').tooltipster('show');
                        $('#po_number').focus();
                        $('#po_number').val('');     
                        $('#po_number').css({'background-color' : '#FFE6E7'});
                        setTimeout(function(){
                            $('#po_number').css({'background-color' : '#FFFFFF'});
                            setTimeout(function(){
                                $('#po_number').css({'background-color' : '#FFE6E7'});
                                setTimeout(function(){
                                    $('#po_number').css({'background-color' : '#FFFFFF'});
                                }, 300);                            
                            }, 300);
                        }, 300);
                    }
                }
            });
        });

        var base_url = location.hostname;
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        table = $("#mytable").DataTable({
            oLanguage: {
                sProcessing: "loading..."
            },
            // select: true;
            processing: true,
            serverSide: true,
            ajax: {"url": "Approved_po/json", "type": "POST"},
            columns: [
                {"data": "date_req"},
                {"data": "objective"},
                {"data": "title"},
                {"data": "budged_req"},
                {"data": "po_number"},
                {"data": "date_po"},
                {"data": "comments"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
			columnDefs: [
				{
					targets: [3], // Index of the 'estimate_price' column
					className: 'text-right' // Apply right alignment to this column
				}
			],
            order: [[1, 'desc']],
            order: [[0, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                // var index = page * length + (iDisplayIndex + 1);
                // $('td:eq(0)', row).html(index);
            }
        });

        // $base = base_url("assets/receipt/");

        $('#mytable').on('click', '.btn_edit', function(){
            let tr = $(this).parent().parent();
            let data = table.row(tr).data();
            // let base = "assets/receipt/";
            console.log(data);
            // var data = this.parents('tr').data();
            if (data.po_number !== undefined && data.po_number !== null) {
                $('#mode').val('edit');
                $('#date_po').val(data.date_po);
                $('#modal-title').html('<i class="fa fa-pencil-square"></i> Budget Approved | Update<span id="my-another-cool-loader"></span>');
            }
            else {            
                $('#modal-title').html('<i class="fa fa-pencil-square"></i> Budget Approved | New<span id="my-another-cool-loader"></span>');
                $('#mode').val('insert');
            }
            $('#objective').attr('readonly', true);
            $('#title').attr('readonly', true);
            $('#budged_req').attr('readonly', true);
            $('#id_req').val(data.id_req);
            $('#objective').val(data.objective);
            $('#title').val(data.title);
            $('#budged_req').val(data.budged_req);
            $('#po_number').val(data.po_number);
            $('#comments').val(data.comments);
            $images = data.photo;
            $('#compose-modal').modal('show');
        });  

        $('#mytable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                table.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
        })   

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
    });
</script>