<div class="content-wrapper">
    <section class="content">


       <div class="row">
             <div class="col-xs-12">
                <div class="box box-primary box-solid">

                    <div class="box-header">
                        <h3 class="box-title">REPORTS - DNA REPORT</h3>
                    </div>
                    <div class="box-body">
                        <!-- <button> </button> -->
                        <!-- <div class="col-md-12 col-xs-12"> -->
                            <a class="btn btn-success btn-sm" id="dna_sample_control" href="dna_sample_control/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Sample Control</a>
                            <a class="btn btn-success btn-sm" id="dna_extraction" href="dna_extraction/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Extraction</a>
                            <a class="btn btn-success btn-sm" id="dna_concentration" href="dna_concentration/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Concentration</a>
                            <a class="btn btn-success btn-sm" id="dna_aliquotting" href="dna_aliquotting/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Aliquotting</a>
                            <a class="btn btn-success btn-sm" id="dna_sample_analysis" href="dna_sample_analysis/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Sample Analysis</a>
                            <a class="btn btn-success btn-sm" id="dna_nanopore_analysis" href="dna_nanopore_analysis/excel"><i class="fa fa-file-excel-o"></i><br /> DNA Nanopore Analysis</a>
                        <!-- </div> -->


                    </div> <!-- </box-body2 > -->

                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="250">Select date range :</td>
                            </tr>
                            <tr>
                                <td>
                                <div class="box">
                                    <!-- <div class="collapse" id="collapse-frez">
                                        <div class="box box-solid"> -->
                                            <div class="box-body">
                                            <!-- <form name="form" action="" method="get"> -->
                                            <!-- <label for="date_rep" class="col-sm-2 control-label">Pilih tanggal : </label> -->
                                                <div class="col-sm-2">
                                                    <input type="date" id="date_rep1" name="date_rep1" placeholder="Date start" class="form-control input-sm">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="date" id="date_rep2" name="date_rep2" placeholder="Date end" class="form-control input-sm">
                                                </div>
                                                <!-- </form> -->
                                                <button id="refresh-rep" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i> Refresh</button>
                                            </div>
                                        <!-- </div>
                                    </div> -->
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
                                                <button class='btn btn-success btn-sm' id='export'> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export To Excel </button>
                                                <?php //echo anchor(site_url('REP_dna/index2'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
                                                <?php //echo anchor(site_url('REP_dna/excel/'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
                                                <?php //echo anchor(site_url('kelolamenu/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?>
                                            </div>

                                            <table id="myreptable" class="table display table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Barcode_sample</th>
                                                            <th>Barcode DNA</th>
                                                            <th>Date extraction</th>
                                                            <th>Cryobox</th>
                                                            <th>Barcode meta</th>
                                                            <th>Meta box</th>
                                                            <th>Comments</th>
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
            if (date1 == '') {
                date1 = '2018-01-01';    
            }
            if (date2 == '') {
                date2=formattedDate;
            }
            document.location.href="REP_dna/excel?date1="+date1+"&date2="+date2;
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
            ajax: {"url": "REP_dna/json?date1="+date1+"&date2="+date2, "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false,
                //     "className" : "text-center"
                // },
                {"data": "barcode_sample"},
                {"data": "barcode_dna"},
                {"data": "date_extraction"},
                {"data": "cryobox"},
                {"data": "barcode_metagenomics"},
                {"data": "meta_box"},
                {"data": "comments"},
            ],
            order: [[2, 'DESC']],
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