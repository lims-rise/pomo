<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-black box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Information - Dictionary</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <!-- <button class='btn btn-primary' id='addtombol'><i class="fa fa-wpforms" aria-hidden="true"></i> New Sample </button> -->
        <?php //echo anchor(site_url('tbl_delivery/new'), '<i class="fa fa-wpforms" aria-hidden="true"></i> New Delivery', 'class="btn btn-danger btn-sm"'); ?>
        <?php //echo anchor(site_url('tbl_delivery/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> New Sample', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('dictionary/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to CSV', 'class="btn btn-success"'); ?></div>
        <table class="table table-bordered table-striped tbody" id="mytable" style="width:100%">
            <thead>
                <tr>
                    <!-- <th width="30px">No</th> -->
                    <th>ID</th>
                    <th>Module</th>
                    <th>Subheadings</th>
                    <th>Column Name</th>
                    <th>Variable Label</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Detail</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        </div>
        </div>
        </div>
        </div>
    </section>

    <!-- DETAIL FORM -->
    <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="detail-title"></h4>
                    </div>
                    <form id="formDetail" method="post" class="form-horizontal">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="detmodule" class="col-sm-4 control-label">Module</label>
                                <div class="col-sm-8">
                                    <input id="detmodule" name="detmodule" placeholder="Module" class="form-control input-sm" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="detheading" class="col-sm-4 control-label">SubHeadings</label>
                                <div class="col-sm-8">
                                    <input id="detheading" name="detheading" placeholder="SubHeadings" class="form-control input-sm" required>
                                </div>
                            </div>

                            <div class="form-group">
                                  <label for="detvar_label" class="col-sm-4 control-label">Variable Label</label>
                                  <div class="col-sm-8">
                                    <input id="detvar_label" name="detvar_label" placeholder="Variable Label" class="form-control input-sm">
                                  </div>
                            </div>

                            <section class="content">
                                <div class="row">
                                    <div class="box">
                                        <div class="box-header"></div>
                                        <div class="box-body table-responsive">
                                            <table id="tbldetail" class="table display table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Factor Value</th>
                                                        <th>Factor Label</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>    

                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
    var tabledet
    $(document).ready(function() {
                
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



    //DETAIL
    // $('#mytable tbody').on('click', '.btn_edit_det', function() {
    //     let tr = $(this).parent().parent();
    //     let data = table.row(tr).data();
    //     console.log(data);
    //     // var data = table.row($(this).parents('tr')).data();
    //     $('#detail-title').html('<i class="fa fa-bars"></i> Dictionary Detail');
    //     // $('#detmodule').attr('readonly', true);
    //     // $('#detmodule').val(data[1]);
    //     // $('#detheading').attr('readonly', true);
    //     // $("#detheading").val(data[2]);
    //     // $('#detvar_label').attr('readonly', true);
    //     // $('#detvar_label').val(data[4]);
    //     $('#detail-modal').modal('show');
    // });


        table = $("#mytable").DataTable({
            oLanguage: {
                sProcessing: "loading..."
            },
            // select: true;
            processing: true,
            serverSide: true,
            ajax: {"url": "dictionary/json", "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false
                // },
                {"data": "id"},
                {"data": "module"},
                {"data": "subheadings"},
                {"data": "col_name"},
                {"data": "var_label"},
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "detail"},
                {"data": "comments"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[0, 'asc']],
            // order: [[0, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                // var index = page * length + (iDisplayIndex + 1);
                // $('td:eq(0)', row).html(index);
            }
        });

        tabledet = $("#tbldetail").DataTable({
            id=$('#id').val();
            oLanguage: {
                sProcessing: "loading..."
            },
            // select: true;
            processing: true,
            serverSide: true,
            ajax: {"url": "dictionary/jsondet", "type": "POST"},
            columns: [
                // {
                //     "data": "barcode_sample",
                //     "orderable": false
                // },
                {"data": "id"},
                {"data": "factor_value"},
                {"data": "factor_label"},
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "comments"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[0, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;

            }
        });

        $('#mytable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                table.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }

            var data = table.row($(this)).data();
            if (data) {
                tabledet.ajax.url('dictionary/jsondet?id=' + data.id).load();
            }
        });

    });
</script>