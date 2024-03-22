<div class="content-wrapper">
    <section class="content">


       <div class="row">
             <div class="col-xs-12">
                <div class="box box-primary box-solid">

                    <div class="box-header">
                        <h3 class="box-title">REPORTS - Objective 2B REPORT</h3>
                    </div>
                    <div class="box-body">
                    <!-- <div class="box-body table-responsive">
                    <div class="col-md-6 col-xs-12"> -->
                        <a class="btn btn-success btn-sm" id="water" href="javascript:void(0);"><i class="fa fa-file-excel-o"></i><br /> Water Report</a>
                        <a class="btn btn-success btn-sm" id="bootsock" href="javascript:void(0);"><i class="fa fa-file-excel-o"></i><br /> Bootsock Report</a>
                        <a class="btn btn-success btn-sm" id="sediment" href="javascript:void(0);"><i class="fa fa-file-excel-o"></i><br /> Sediment Report</a>
                        <a class="btn btn-success btn-sm" id="feces" href="javascript:void(0);"><i class="fa fa-file-excel-o"></i><br /> Feces Report</a>
                    </div>

            <div class="box-body">
        <!-- <div class="col-md-8 col-xs-12"> -->
            <div class="collapse" id="collapse-water">
                <div class="box box-solid">
                    <div class="box-body">
                        <label for="date_conduct" class="col-sm-3 control-label">Date Activity : </label>
                        <div class="col-sm-3">
                            <input id="date_water1" type="date" name="date_water1" placeholder="Date Activity Start" class="form-control input-sm">
                        </div>
                        <div class="col-sm-3">
                            <input id="date_water2" type="date" name="date_water2" placeholder="Date Activity Finish" class="form-control input-sm">
                        </div>
                        <button id="refresh-water" class="btn btn-default btn-flat btn-sm"><i class="fa fa-refresh"></i> Refresh Water</button>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapse-bootsock">
                <div class="box box-solid">
                    <div class="box-body">
                        <label for="date_conduct" class="col-sm-3 control-label">Date Activity : </label>
                        <div class="col-sm-3">
                            <input id="date_bootsock1" type="date" name="date_bootsock1" placeholder="Date Activity Start" class="form-control input-sm">
                        </div>
                        <div class="col-sm-3">
                            <input id="date_bootsock2" type="date" name="date_bootsock2" placeholder="Date Activity Finish" class="form-control input-sm">
                        </div>
                        <button id="refresh-bootsock" class="btn btn-default btn-flat btn-sm"><i class="fa fa-refresh"></i> Refresh Bootsock</button>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapse-sediment">
                <div class="box box-solid">
                    <div class="box-body">
                        <label for="date_conduct" class="col-sm-3 control-label">Date Activity : </label>
                        <div class="col-sm-3">
                            <input id="date_sediment1" type="date" name="date_sediment1" placeholder="Date Activity Start" class="form-control input-sm">
                        </div>
                        <div class="col-sm-3">
                            <input id="date_sediment2" type="date" name="date_sediment2" placeholder="Date Activity Finish" class="form-control input-sm">
                        </div>
                        <button id="refresh-sediment" class="btn btn-default btn-flat btn-sm"><i class="fa fa-refresh"></i> Refresh Sediment</button>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapse-feces">
                <div class="box box-solid">
                    <div class="box-body">
                        <label for="date_conduct" class="col-sm-3 control-label">Date Activity : </label>
                        <div class="col-sm-3">
                            <input id="date_feces1" type="date" name="date_feces1" placeholder="Date Activity Start" class="form-control input-sm">
                        </div>
                        <div class="col-sm-3">
                            <input id="date_feces2" type="date" name="date_feces2" placeholder="Date Activity Finish" class="form-control input-sm">
                        </div>
                        <button id="refresh-feces" class="btn btn-default btn-flat btn-sm"><i class="fa fa-refresh"></i> Refresh Feces</button>
                    </div>
                </div>
            </div>
        </div>

        </div>
        
        <div class="row" >
            <div class="col-xs-12" id="print-area">
                <!-- <h4 class="text-center" id="report-title"> Ini report title</h4> -->
                <div class="box">
                <div class="box-header"></div>
                    <div class="box-body table-responsive">
                    <div style="padding-bottom: 10px;">
                        <button class='btn btn-success btn-sm' id='export'> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export To Excel </button>
                        <?php //echo anchor(site_url('REP_o2a/index2'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
                        <?php //echo anchor(site_url('REP_o2a/excel/'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
                        <?php //echo anchor(site_url('kelolamenu/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?>
                    </div>

                    <table id="myreptable" class="table display table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Barcode sample</th>
                                    <th>Date arrive</th>
                                    <th>Time arrive</th>
                                    <th>Sample type</th>
                                    <th>P&G control</th>
                                    <th>Barcode tinytag</th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-xs-12 table-responsive" id="print-area" style="min-height: 350px">
                            
            </div>                    
            </div> -->
            </div>
        </div>

    </section>

</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">

const currentDate = new Date();
// Get the year, month, and day components
const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based, so add 1 and pad with '0'
const day = String(currentDate.getDate()).padStart(2, '0');
// Create the formatted date string in "YYYY-MM-DD" format and store it in a variable
const formattedDate = `${year}-${month}-${day}`;


    $(document).ready(function() {

        $("#water").on('click', function() {
            // $("#print-area").html('');
            if ($("#collapse-bootsock").hasClass('in')) $("#collapse-bootsock").collapse('hide');
            if ($("#collapse-sediment").hasClass('in')) $("#collapse-sediment").collapse('hide');
            if ($("#collapse-feces").hasClass('in')) $("#collapse-feces").collapse('hide');
            $("#collapse-water").collapse('show');
        });
        $("#bootsock").on('click', function() {
            // $("#print-area").html('');
            if ($("#collapse-water").hasClass('in')) $("#collapse-water").collapse('hide');
            if ($("#collapse-sediment").hasClass('in')) $("#collapse-sediment").collapse('hide');
            if ($("#collapse-feces").hasClass('in')) $("#collapse-feces").collapse('hide');
            $("#collapse-bootsock").collapse('show');
        });
        $("#sediment").on('click', function() {
            // $("#print-area").html('');
            if ($("#collapse-water").hasClass('in')) $("#collapse-water").collapse('hide');
            if ($("#collapse-feces").hasClass('in')) $("#collapse-feces").collapse('hide');
            if ($("#collapse-bootsock").hasClass('in')) $("#collapse-bootsock").collapse('hide');
            $("#collapse-sediment").collapse('show');
        });
        $("#feces").on('click', function() {
            // $("#print-area").html('');
            if ($("#collapse-water").hasClass('in')) $("#collapse-water").collapse('hide');
            if ($("#collapse-bootsock").hasClass('in')) $("#collapse-bootsock").collapse('hide');
            if ($("#collapse-sediment").hasClass('in')) $("#collapse-sediment").collapse('hide');
            $("#collapse-feces").collapse('show');
        });

        /*
         $("#water").on('click', function() {
         if ($("#collapse-water").hasClass('in')) $("#collapse-water").collapse('hide');
         $("#print-area").addClass("divloader");
         $("#print-area").html('');
         });
         */

        $('#date_water1').on('change', function (){
            if ($('#date_water1').val() > $('#date_water2').val()) {
                $('#date_water2').val($('#date_water1').val());
            }
        });

        $('#date_water2').on('change', function (){
            if ($('#date_water2').val() < $('#date_water1').val()) {
                $('#date_water1').val($('#date_water2').val());
            }
        });

        $('#date_bootsock1').on('change', function (){
            if ($('#date_bootsock1').val() > $('#date_bootsock2').val()) {
                $('#date_bootsock2').val($('#date_bootsock1').val());
            }
        });

        $('#date_bootsock2').on('change', function (){
            if ($('#date_bootsock2').val() < $('#date_bootsock1').val()) {
                $('#date_bootsock1').val($('#date_bootsock2').val());
            }
        });

        $('#date_sediment1').on('change', function (){
            if ($('#date_sediment1').val() > $('#date_sediment2').val()) {
                $('#date_sediment2').val($('#date_sediment1').val());
            }
        });

        $('#date_sediment2').on('change', function (){
            if ($('#date_sediment2').val() < $('#date_sediment1').val()) {
                $('#date_sediment1').val($('#date_sediment2').val());
            }
        });

        $('#date_feces1').on('change', function (){
            if ($('#date_feces1').val() > $('#date_feces2').val()) {
                $('#date_feces2').val($('#date_feces1').val());
            }
        });

        $('#date_feces2').on('change', function (){
            if ($('#date_feces2').val() < $('#date_feces1').val()) {
                $('#date_feces1').val($('#date_feces2').val());
            }
        });

        $("#refresh-water").on('click', function() {
            $("#print-area").addClass("divloader");
            $("#print-area").html('');
            $.ajax({
                url: 'module/reports/data_o2b.php',
                data: { rep: 6, date1: $("#date_water1").val(), date2: $("#date_water2").val()},
                type: 'GET',
                success: function(data) {
                    // $("#print-area").html(data);
                    // $("#print-area").removeClass("divloader");
                }
            });
        });

        $("#refresh-bootsock").on('click', function() {
            $("#print-area").addClass("divloader");
            $("#print-area").html('');
            $.ajax({
                url: 'module/reports/data_o2b.php',
                data: { rep: 9, date1: $("#date_bootsock1").val(), date2: $("#date_bootsock2").val()},
                type: 'GET',
                success: function(data) {
                    $("#print-area").html(data);
                    $("#print-area").removeClass("divloader");
                }
            });
        });

        $("#refresh-sediment").on('click', function() {
            $("#print-area").addClass("divloader");
            $("#print-area").html('');
            $.ajax({
                url: 'module/reports/data_o2b.php',
                data: { rep: 7, date1: $("#date_sediment1").val(), date2: $("#date_sediment2").val()},
                type: 'GET',
                success: function(data) {
                    $("#print-area").html(data);
                    $("#print-area").removeClass("divloader");
                }
            });
        });

        $("#refresh-feces").on('click', function() {
            $("#print-area").addClass("divloader");
            $("#print-area").html('');
            $.ajax({
                url: 'module/reports/data_o2b.php',
                data: { rep: 8, date1: $("#date_feces1").val(), date2: $("#date_feces2").val()},
                type: 'GET',
                success: function(data) {
                    $("#print-area").html(data);
                    $("#print-area").removeClass("divloader");
                }
            });
        });

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

        $('#date_rep1').on('change', function (){
            if ($('#date_rep1').val() > $('#date_rep2').val()) {
                $('#date_rep2').val($('#date_rep1').val());
            }
        });

        $('#date_rep2').on('change', function (){
            if ($('#date_rep2').val() < $('#date_rep1').val()) {
                $('#date_rep1').val($('#date_rep2').val());
            }
        });

        $("#export").on('click', function() {
            var date1 = $('#date_rep1').val();
            var date2 = $('#date_rep2').val();
            if (date1 == '') {
                date1 = '2018-01-01';    
            }
            if (date2 == '') {
                date2=formattedDate;
            }
            document.location.href="REP_o2b/excel?date1="+date1+"&date2="+date2;
        });

    $('#refresh-rep ').click(function() {
        var date1 = $('#date_rep1').val();
        var date2 = $('#date_rep2').val();
        var t = $("#myreptable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            bDestroy: true,
            // paging: false,
            ordering: false,
            info: false,
            bFilter: false,
            ajax: {"url": "REP_o2b/json?date1="+date1+"&date2="+date2, "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false,
                //     "className" : "text-center"
                // },
                {"data": "id_receipt"},
                {"data": "date_receipt"},
                {"data": "delivered"},
                {"data": "received"},
                {"data": "sample_type"},
            ],
            order: [[0, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                // var index = page * length + (iDisplayIndex + 1);
                // $('td:eq(0)', row).html(index);
            }
        });
        // $('#compose-modal').modal('show');
    });


    });
</script>