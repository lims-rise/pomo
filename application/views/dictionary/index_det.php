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

        <form id="formSample" method="post" class="form-horizontal">
                <div class="modal-body">
                <div class="form-group">
                    <label for="id_det" class="col-sm-4 control-label">Dictionary ID</label>
                    <div class="col-sm-8">
                        <input id="id_det" name="id_det" placeholder="ID" class="form-control input-sm" value=<?php echo $dictionary_id; ?> disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="detmodule" class="col-sm-4 control-label">Module</label>
                    <div class="col-sm-8">
                        <input id="detmodule" name="detmodule" placeholder="Module" class="form-control input-sm" value=<?php echo $module; ?> disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detheading" class="col-sm-4 control-label">SubHeadings</label>
                    <div class="col-sm-8">
                        <input id="detheading" name="detheading" placeholder="SubHeadings" class="form-control input-sm" value=<?php echo $subheadings; ?> disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="detvar_label" class="col-sm-4 control-label">Variable Label</label>
                    <div class="col-sm-8">
                        <input id="detvar_label" name="detvar_label" placeholder="Variable Label" class="form-control input-sm" value=<?php echo $var_label; ?> disabled>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="box">
                            <div class="box-header"></div>
                            <div class="box-body table-responsive">
                            <!-- <table class="table table-bordered table-striped tbody" id="mytable2x" style="width:100%"> -->
                                <table id="mytable2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Factor Value</th>
                                            <th>Factor Label</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Comments</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Value</td>
                                            <td>Label</td>
                                            <td>Date</td>
                                            <td>Date</td>
                                            <td>test test</td>
                                        </tr> -->
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>    

                </div>
                <div class="modal-footer clearfix">
                <!-- <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> OK</button> -->
                <button type="button" name="cancel" value="cancel" class="btn btn-warning" onclick="javascript:history.go(-1);"><i class="fa fa-times"></i> Close</button>
                </div>
                </form>

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
    <!-- <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header box"> -->
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                    <!-- <h4 class="modal-title" id="modal-title">Dictionary - Detail</h4>
                </div> -->

            <!-- </div>/.modal-content -->
        <!-- </div>/.modal-dialog -->
    <!-- </div>/.modal         -->

</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">

    // var table
    var tabledet
    // var id_dic=$('#id').val();
    $(document).ready(function() {
        
        // $('.clockpicker').clockpicker({
        // placement: 'bottom', // clock popover placement
        // align: 'left',       // popover arrow align
        // donetext: 'Done',     // done button text
        // autoclose: true,    // auto close when minute is selected
        // vibrate: true        // vibrate the device when dragging clock hand
        // });                

        // $('.val1tip').tooltipster({
        //     animation: 'swing',
        //     delay: 1,
        //     theme: 'tooltipster-default',
        //     // touchDevices: false,
        //     // trigger: 'hover',
        //     autoClose: true,
        //     position: 'bottom',
        //     // content: $('<span><i class="fa fa-exclamation-triangle"></i> <strong> This text is in bold case !</strong></span>')
        //     // content: $('<span><img src="../assets/img/ttd.jpg" /> <strong>This text is in bold case !</strong></span>')
        //     // content: 'Test tip'
        // });


        // function checkBarcode() { col-sm-8
        // $('.modal-body').click(function() {
        // $('#barcode_sample').click(function() {
        //     $('.val1tip').tooltipster('hide');   
        // // $('#barcode_sample').val('');     
        // });

        // $('.col-sm-8').click(function() {

            // $('.val1tip').tooltipster('hide');   
            // $('#barcode_sample').val('');     
        // });

        // $("#compose-modal").on('hide.bs.modal', function(){
        //     $('.val1tip').tooltipster('hide');   
        //     // $('#barcode_sample').val('');     
        // });


        // $("input").keypress(function(){
        //     // $('#barcode_sample').val('');     
        //     $('.val1tip').tooltipster('hide');   
        // });

        // $('#compose-modal').on('shown.bs.modal', function () {
        //     // $('#barcode_sample').val('');     
        //     $('#sample').focus();
        // });        

        var id_det = $('#id_det').val();                
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

        // table = $("#mytable").DataTable({
        //     oLanguage: {
        //         sProcessing: "loading..."
        //     },
        //     // select: true;
        //     processing: true,
        //     serverSide: true,
        //     ajax: {"url": "Dictionary/json", "type": "POST"},
        //     columns: [
        //         // {
        //         //     "data": "barcode_sample",
        //         //     "orderable": false
        //         // },
        //         {"data": "id"},
        //         {"data": "module"},
        //         {"data": "subheadings"},
        //         {"data": "col_name"},
        //         {"data": "var_label"},
        //         {"data": "start_date"},
        //         {"data": "end_date"},
        //         {"data": "detail"},
        //         {"data": "comments"},
        //         {
        //             "data" : "action",
        //             "orderable": false,
        //             "className" : "text-center"
        //         }
        //     ],
        //     order: [[0, 'asc']],
        //     // order: [[0, 'desc']],
        //     rowCallback: function(row, data, iDisplayIndex) {
        //         var info = this.fnPagingInfo();
        //         var page = info.iPage;
        //         var length = info.iLength;
        //         // var index = page * length + (iDisplayIndex + 1);
        //         // $('td:eq(0)', row).html(index);
        //     }
        // });


        table2 = $("#mytable2").DataTable({
            oLanguage: {
                sProcessing: "Loading sub dictionary..."
            },
            processing: true,
            serverSide: true,
            paging: false,
            ordering: false,
            info: false,
            bFilter: false,

            // select: true;
            // processing: true,
            // serverSide: true,
            //     table2.ajax.url('dictionary/jsondet?id=' + data.id).load();
            // ajax: {"url": "../../dictionary/jsondet", "type": "POST"},
            ajax: {"url": "../../dictionary/jsondet?id1=" + id_det, "type": "POST"},

            // ajax: {
            //     "url": "../dictionary/jsondet",
            //     "type": "POST",
            //     "data": function(d) {
            //         d.id = $('#id_det').val()
            //     }
            // },
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
                // {
                //     "data" : "action",
                //     "orderable": false,
                //     "className" : "text-center"
                // }
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


        // tabledet = $("#tbldetail").DataTable({
        //     oLanguage: {
        //         sProcessing: "loading..."
        //     },
        //     // select: true;
        //     processing: true,
        //     serverSide: true,
        //     ajax: {"url": "Dictionary/jsondet", "type": "POST"},
        //     // ajax: {"url": "Dictionary/jsondet?id1=" + data.id, "type": "POST"},
        //     columns: [
        //         {"data": "id"},
        //         {"data": "factor_value"},
        //         {"data": "factor_label"},
        //         {"data": "start_date"},
        //         {"data": "end_date"},
        //         {"data": "comments"},
        //         {
        //             "data" : "action",
        //             "orderable": false,
        //             "className" : "text-center"
        //         }
        //     ],
        //     order: [[0, 'asc']],
        //     // order: [[0, 'desc']],
        //     rowCallback: function(row, data, iDisplayIndex) {
        //         var info = this.fnPagingInfo();
        //         var page = info.iPage;
        //         var length = info.iLength;
        //         // var index = page * length + (iDisplayIndex + 1);
        //         // $('td:eq(0)', row).html(index);
        //     }
        // });         

        // $('#mytable').on('click', '.btn_edit', function(){
        //     // $('.val1tip').tooltipster('hide');   
        //     let tr = $(this).parent().parent();
        //     let data = table.row(tr).data();
        //     console.log(data);
        //     // var data = this.parents('tr').data();
        //     // $('#mode').val('edit');
        //     $('#modal-title').html('<i class="fa fa-pencil-square"></i> Dictionary - Detail<span id="my-another-cool-loader"></span>');
        //     $('#id').val(data.id);
        //     $('#detmodule').val(data.module);
        //     $('#detheading').val(data.subheadings);
        //     $('#detvar_label').val(data.var_label);
        //     // tabledet.ajax.url('dictionary/jsondet?id=' + data.id).load();
        //     $('#compose-modal').modal('show');
        // });  

        // #tblEmployee tbody tr.even:hover {
        //     background-color: cadetblue;
        //     cursor: pointer;
        // }
        // $('#myTable').DataTable( {
        //     select: true
        // } );

        $('#mytable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                table.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }

            // var data = table.row($(this)).data();
            // if (data) {
            //     table2.ajax.url('dictionary/jsondet?id=' + data.id).load();
            // }
        })   

        // $('[data-dismiss=modal]').on('click', function(e) {
        //     var $t = $(this),
        //         target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        //     $(target)
        //         .find("input,textarea,select")
        //         .val('')
        //         .end()
        //         .find("input[type=checkbox], input[type=radio]")
        //         .prop("checked", "")
        //         .end();
        // });
        // $('.modal').on('hidden.bs.modal', function() {
        //     $(this).find('form')[0].reset();
        // });
        // $('.modal').on('shown.bs.modal', function() {
        //     lastfocus = $(this);
        //     $('input:enabled:visible:not([readonly="readonly"])', this).get(0).select();
        // });                                
    });
</script>