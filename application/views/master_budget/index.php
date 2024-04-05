<div class="content-wrapper">
    <section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-black box-solid">
                <div class="box-header">
                    <h3 class="box-title">REPORTS - Master Budget</h3>
                </div>
                <div class="box-body">
                    <a class="btn btn-success btn-sm" id="o2a_sample_reception" href="o2a_sample_reception/excel"><i class="fa fa-file-excel-o"></i><br /> Sample Reception</a>
                    <a class="btn btn-success btn-sm" id="o2a_sample_logging" href="o2a_sample_logging/excel"><i class="fa fa-file-excel-o"></i><br /> Sample Logging</a>
                    <a class="btn btn-success btn-sm" id="o2a_mosquito_identifications" href="o2a_mosquito_identifications/excel"><i class="fa fa-file-excel-o"></i><br /> Mosquito Identifications</a>
                </div> <!-- </box-body2 > -->

                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="250">Select filter of the reports :</td>
                        </tr>
                        <tr>
                            <td>
                            <div class="box">
                                <div class="box-body">
                                <!-- <div class="modal-body"> -->
                                <form id="formSample" class="form-horizontal">

                                <div class="form-group">
                                        <label for="date_req" class="col-sm-2 control-label">Date range</label>
                                        <div class="col-sm-2">
                                            <input id="date_rep1" name="date_rep1" type="text" class="form-control datepicker" placeholder="Date Start">
                                        </div>
                                        <div class="col-sm-2">
                                            <input id="date_rep2" name="date_rep2" type="text" class="form-control datepicker" placeholder="Date End">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btcleardate" class="btn btn-default btn-clear" onclick="">Clear</button>                                        
                                        </div>

                                        <!-- <label for="date_req" class="col-sm-3 control-label"></label> -->
                                    </div>
                                    <!-- <hr> -->
                                    <div class="form-group">
                                        <label for="id_objective" class="col-sm-2 control-label">Objectives</label>
                                        <div class="col-sm-4">
                                        <select id='id_objective' name="id_objective" class="form-control">
                                            <option value=''>-- All Objectives --</option>
                                            <?php
                                            foreach($objective as $row){
                                                if ($id_objective == $row['id_objective']) {
                                                    echo "<option value='".$row['id_objective']."' selected='selected'>".$row['objective']."</option>";
                                                }
                                                else {
                                                    echo "<option value='".$row['id_objective']."'>".$row['objective']."</option>";
                                                }
                                            }
                                                ?>
                                        </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btclearobj" class="btn btn-default btn-clear" onclick="">Clear</button>                                        
                                        </div>
                                        <!-- <label for="date_req" class="col-sm-4 control-label"></label> -->
                                    </div>
                                </form>
                                <!-- </div> -->
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <div class="clearfix">
                                <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button> -->
                                <button id="refresh-rep" class="btn btn-primary"><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header"></div>
                                        <div class="box-body table-responsive">
                                        <div style="padding-bottom: 10px;">
                                            <button class='btn btn-success' id='export'> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export To Excel </button>
                                            <?php //echo anchor(site_url('Master_budget/index2'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
                                            <?php //echo anchor(site_url('Master_budget/excel/'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
                                            <?php //echo anchor(site_url('kelolamenu/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?>
                                        </div>

                                        <table id="myreptable" class="table display table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date request</th>
                                                        <th>PO number</th>
                                                        <th>Objective</th>
                                                        <th>Title</th>
                                                        <th>Budget request</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col-xs-12 -->
                            </div><!-- /.row -->                                
                            </td>
                        </tr>
                    </table>
                <!-- </form> -->
                </div> <!-- </box-body1 > -->
            </div>
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
        $('.datepicker').datepicker({
                    autoclose: true,
                    dateFormat:'yy-mm-dd'
                })                



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

    // Clear date range fields
        document.getElementById('btcleardate').addEventListener('click', function() {
            document.getElementById('date_rep1').value = '';
            document.getElementById('date_rep2').value = '';
        });

        // Clear objectives field
        document.getElementById('btclearobj').addEventListener('click', function() {
            document.getElementById('id_objective').value = '';
        });
                
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

        $('#date_rep1').on('click', function (){
            if ($('#date_rep1').val() > $('#date_rep2').val()) {
                $('#date_rep2').val($('#date_rep1').val());
            }
        });

        $('#date_rep2').on('click', function (){
            if ($('#date_rep2').val() < $('#date_rep1').val()) {
                $('#date_rep1').val($('#date_rep2').val());
            }
        });

        $('#date_rep1').on('blur', function (){
            if ($('#date_rep1').val() > $('#date_rep2').val()) {
                $('#date_rep2').val($('#date_rep1').val());
            }
        });

        $('#date_rep2').on('blur', function (){
            if ($('#date_rep2').val() < $('#date_rep1').val()) {
                $('#date_rep1').val($('#date_rep2').val());
            }
        });

        $("#export").on('click', function() {
            var date1 = $('#date_rep1').val();
            var date2 = $('#date_rep2').val();
            var obj = $('#id_objective').val();
            if (date1 == '') {
                date1 = '2018-01-01';    
            }
            if (date2 == '') {
                date2=formattedDate;
            }
            document.location.href="Master_budget/excel?date1="+date1+"&date2="+date2+"&obj="+obj;
        });

    $('#refresh-rep ').click(function() {
        var date1 = $('#date_rep1').val();
        var date2 = $('#date_rep2').val();
        var obj = $('#id_objective').val();
        // if ($('#id_objective').val().length === 0) {
        //     var obj = "";
        // }
        // else {
        //     var obj = $('#id_objective').val();
        // }
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
            ajax: {"url": "Master_budget/json?date1="+date1+"&date2="+date2+"&obj="+obj, "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false,
                //     "className" : "text-center"
                // },
                {"data": "id_req"},
                {"data": "date_req"},
                {"data": "po_number"},
                {"data": "objective"},
                {"data": "title"},
                {"data": "budged_req"},
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