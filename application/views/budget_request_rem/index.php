<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-black box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Purchase Order | Budget Remaining Request</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px">
        <?php echo anchor(site_url('budget_request_rem/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to XLS', 'class="btn btn-success"'); ?></div>
        <table class="table table-bordered table-striped tbody" id="mytable" style="width:100%">
            <thead>
                <tr>
            <th>PO number</th>
		    <th>Objectives</th>
		    <th>Title</th>
		    <th>Budget remaining</th>
		    <th>Date request</th>
		    <th>New title</th>
		    <th>Budget request</th>
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
                <form id="formSample"  action= <?php echo site_url('budget_request_rem/save') ?> method="post" class="form-horizontal">
                    <div class="modal-body">
                        <input id="mode" name="mode" type="hidden" class="form-control input-sm">
                        <input id="id_reqrem" name="id_reqrem" type="hidden" class="form-control input-sm">

                        <div class="form-group">
                            <label for="po_number" class="col-sm-4 control-label">PO Number</label>
                            <div class="col-sm-8">
                                <input id="po_number" name="po_number" type="text" class="form-control" placeholder="PO Number">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="budget_rem" class="col-sm-4 control-label">Budget Remaining</label>
                            <div class="col-sm-8">
                                <input id="budget_rem" name="budget_rem" type="text" class="form-control" placeholder="Budget Remaining">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="date_req" class="col-sm-4 control-label">Date request</label>
                            <div class="col-sm-8">
                                <input id="date_req" name="date_req" type="date" class="form-control" placeholder="Date Request" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_person" class="col-sm-4 control-label">Requested by</label>
                            <div class="col-sm-8" >
                            <select id='id_person' name="id_person" class="form-control">
                                <option>-- Select staff --</option>
                                <?php
                                foreach($person as $row){
									if ($id_person == $row['id_person']) {
										echo "<option value='".$row['id_person']."' selected='selected'>".$row['realname']."</option>";
									}
									else {
                                        echo "<option value='".$row['id_person']."'>".$row['realname']."</option>";
                                    }
                                }
                                    ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_title" class="col-sm-4 control-label">New Title</label>
                            <div class="col-sm-8">
                                <input id="new_title" name="new_title" type="text" class="form-control" placeholder="New Title">
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="comments" class="col-sm-4 control-label">Comments</label>
                                <div class="col-sm-8">
                                    <textarea id="comments" name="comments" class="form-control" placeholder="Comments"> </textarea>
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

        $('.clockpicker').clockpicker({
        placement: 'bottom', // clock popover placement
        align: 'left',       // popover arrow align
        donetext: 'Done',     // done button text
        autoclose: true,    // auto close when minute is selected
        vibrate: true        // vibrate the device when dragging clock hand
        });                

        $('.val1tip, .val2tip, .val3tip').tooltipster({
            animation: 'swing',
            delay: 1,
            theme: 'tooltipster-default',
            autoClose: true,
            position: 'bottom',
        });

        $("#compose-modal").on('hide.bs.modal', function(){
            $('.val1tip,.val2tip,.val3tip').tooltipster('hide');   
        });        

        $('#compose-modal').on('shown.bs.modal', function () {
            $('#date_req').focus();
            });

        function formatNumber(input) {
            input.value = input.value.replace(/[^\d.]/g, '').replace(/\.(?=.*\.)/g, '');
            if (input.value !== '') {
                var numericValue = parseFloat(input.value.replace(/\./g, '').replace(',', '.'));
                input.value = numericValue.toLocaleString('en-US', { maximumFractionDigits: 2 });
                // Replace commas with dots for the display
                input.value = input.value.replace(/,/g, '.');
            }
        }

        // $("input").keypress(function(){
        //     $('.val1tip,.val2tip,.val3tip').tooltipster('hide');   
        // });

        // $("input").click(function(){
        //     setTimeout(function(){
        //         $('.val1tip,.val2tip,.val3tip').tooltipster('hide');   
        //     }, 3000);                            
        // });

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
            // initComplete: function() {
            //     var api = this.api();
            //     $('#mytable_filter input')
            //             .off('.DT')
            //             .on('keyup.DT', function(e) {
            //                 if (e.keyCode == 13) {
            //                     api.search(this.value).draw();
            //                 }
            //     });
            // },
            oLanguage: {
                sProcessing: "loading..."
            },
            // select: true;
            processing: true,
            serverSide: true,
            ajax: {"url": "budget_request_rem/json", "type": "POST"},
            columns: [
                {"data": "po_number"},
                {"data": "objective"},
                {"data": "title"},
                {"data": "budget_rem"},
                {"data": "date_req"},
                {"data": "new_title"},
                {"data": "budget_rem_req"},
                {"data": "comments"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
			columnDefs: [
				{
					targets: [3,6], // Index of the 'estimate_price' column
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

        // $('#addtombol').click(function() {
        //     $('#mode').val('insert');
        //     $('#modal-title').html('<i class="fa fa-wpforms"></i> budget Request | New<span id="my-another-cool-loader"></span>');
        //     $('#id_req').attr('readonly', false);
        //     $('#id_req').val('');
        //     // $("#date_req").datepicker("setDate",'now');
        //     $('#id_person').val('');
        //     $('#id_objective').val('');
        //     $('#title').val('');
        //     $('#budget_req').val('');
        //     $('#comments').val('');
        //     $('#compose-modal').modal('show');
        // });

        $('#mytable').on('click', '.btn_edit', function(){
            let tr = $(this).parent().parent();
            let data = table.row(tr).data();
            console.log(data);
            // var data = this.parents('tr').data();
            if (data.new_title !== undefined && data.new_title !== null) {
                $('#mode').val('edit');
                titl = 'Update';
            }
            else {
                $('#mode').val('insert');
                titl = 'New';
            }
            $('#modal-title').html('<i class="fa fa-pencil-square"></i> Budget Remaining Request | '+titl+' <span id="my-another-cool-loader"></span>');
            $('#id_reqrem').attr('readonly', true);
            $('#id_reqrem').val(data.id_reqrem);
            $('#po_number').attr('readonly', true);
            $('#po_number').val(data.po_number);
            $('#budget_rem').attr('readonly', true);
            $('#budget_rem').val(data.budget_rem);
            if (data.date_req) {            
                $('#date_req').val(data.date_req);
            }
            $('#id_person').val(data.id_person).trigger('change');
            $('#new_title').val(data.new_title);
            $('#comments').val(data.comments);
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
                            
    });
</script>