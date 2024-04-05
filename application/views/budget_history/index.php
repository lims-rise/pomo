<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-black box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Budget History</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <table class="table table-bordered table-striped tbody" id="mytable" style="width:100%">
            <thead>
                <tr>
		    <th>Date request</th>
		    <th>PO number</th>
		    <th>Objectives</th>
		    <th>Title</th>
		    <th>Budget request</th>
		    <th>Expenses</th>
		    <th>Remaining</th>
		    <!-- <th>Comments</th> -->
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
            $('#budged_req').on('input', function() {
                formatNumber(this);
                });
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

        $("input").keypress(function(){
            $('.val1tip,.val2tip,.val3tip').tooltipster('hide');   
        });

        $("input").click(function(){
            setTimeout(function(){
                $('.val1tip,.val2tip,.val3tip').tooltipster('hide');   
            }, 3000);                            
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
            ajax: {"url": "Budget_history/json", "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false
                // },
                {"data": "date_req"},
                {"data": "po_number"},
                {"data": "objective"},
                {"data": "title"},
                {"data": "budged_req"},
                {"data": "tot_expenses"},
                {"data": "total_budget_rem"},
                // {"data": "comments"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
			columnDefs: [
				{
					targets: [4,5,6], // Index of the 'estimate_price' column
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

        $('#addtombol').click(function() {
            $('#mode').val('insert');
            $('#modal-title').html('<i class="fa fa-wpforms"></i> Budged Request | New<span id="my-another-cool-loader"></span>');
            $('#id_req').attr('readonly', false);
            $('#id_req').val('');
            // $("#date_req").datepicker("setDate",'now');
            $('#id_person').val('');
            $('#id_objective').val('');
            $('#title').val('');
            $('#budged_req').val('');
            $('#comments').val('');
            $('#compose-modal').modal('show');
        });

        $('#mytable').on('click', '.btn_edit', function(){
            let tr = $(this).parent().parent();
            let data = table.row(tr).data();
            console.log(data);
            // var data = this.parents('tr').data();
            $('#mode').val('edit');
            $('#modal-title').html('<i class="fa fa-pencil-square"></i> Budged Request | Update<span id="my-another-cool-loader"></span>');
            $('#id_req').attr('readonly', true);
            $('#id_req').val(data.id_req);
            $('#date_req').val(data.date_req);
            $('#id_person').val(data.id_person).trigger('change');
            $('#id_objective').val(data.id_objective).trigger('change');
            $('#title').val(data.title);
            $('#budged_req').val(data.budged_req);
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