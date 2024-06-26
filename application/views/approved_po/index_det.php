<div class="content-wrapper">
	<section class="content">
		<div class="box box-black box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Purchase Order | Budget Detail</h3>
			</div>
			<form role="form"  id="formKeg" method="post" class="form-horizontal">
				<div class="box-body">
					<input type="hidden" class="form-control " id="id_req" name="id_req" value="<?php echo $id_req ?>">
					<!-- <input id="id_req" name="id_req" type="hidden" class="form-control input-sm"> -->

					<div class="form-group">
						<label for="date_req" class="col-sm-2 control-label">Date request</label>
						<div class="col-sm-4">
							<input class="form-control " id="date_req" name="date_req" value="<?php echo $date_req ?>"  disabled>
						</div>

						<label for="realname" class="col-sm-2 control-label">Requested by</label>
						<div class="col-sm-4">
							<input class="form-control " id="realname" name="realname" value="<?php echo $realname ?>"  disabled>
						</div>
					</div>

					<div class="form-group">
						<label for="objective" class="col-sm-2 control-label">Objective</label>
						<div class="col-sm-4">
							<input class="form-control " id="objective" name="objective" value="<?php echo $objective ?>" disabled>
						</div>

						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-4">
							<input class="form-control " id="title" name="title" value="<?php echo $title ?>"  disabled>
						</div>
					</div>

					<div class="form-group">
						<label for="budget_req" class="col-sm-2 control-label">Budget Request</label>
						<div class="col-sm-4">
							<input class="form-control " id="budget_req" name="budget_req" value="<?php echo $budget_req ?>"  disabled>
						</div>

						<label for="comments" class="col-sm-2 control-label">Comments</label>
						<div class="col-sm-4">
							<input class="form-control " id="comments" name="comments" value="<?php echo $comments ?>"  disabled>
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="budget_rem" class="col-sm-2 control-label">budget Remaining</label>
						<div class="col-sm-4">
							<input class="form-control " id="budget_rem" name="budget_rem" value="<?php// echo $budget_rem ?>" disabled>
						</div>
					</div> -->


				</div><!-- /.box-body -->
				</form>

				<div class="box-footer">

                <!-- <div class="row"> -->
                    <div class="col-xs-12"> 
                        <div class="box box-primary box-solid">
            
                            <div class="box-header">
                                <h3 class="box-title">Detail Items</h3>
                            </div>
							<div class="box-body pad table-responsive">
							
							<!-- <button class='btn btn-warning' id='addtombol'><i class="fa fa-wpforms" aria-hidden="true"></i> New Data</button> -->
							<table id="example2" class="table display table-bordered table-striped" width="100%">
								<thead>
									<tr>
										<!-- <th>PO Number</th> -->
										<th>Items</th>
										<th>Qty</th>
										<th>Unit</th>
										<th>Estimate Price</th>
										<th>Total Estimate</th>
										<th>Remarks</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
							</table>
							</div> <!--/.box-body  -->

                        </div><!-- box box-warning -->
                    </div>  <!--col-xs-12 -->
                <!--</div> row -->    
					<div class="form-group">
						<div class="modal-footer clearfix">
	<!--                                            <button type="submit" name="Save" value="simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button> -->
							<!-- <button type="button" name="excel" id="excel" class="btn btn-success" onclick="location.href='<?php echo site_url('budget_request/excel_print'); ?>';"><i class="fa fa-file-excel-o"></i> Excel</button>
							<button type="button" name="print" id="print" class="btn btn-primary" onclick="javascript:void(0);"><i class="fa fa-print"></i> Print</button> -->
							<button type="button" name="batal" value="batal" class="btn btn-warning" onclick="javascript:history.go(-1);"><i class="fa fa-times"></i> Close</button>
						</div>
					</div>

				</div> <!-- footer-->

		</div>
	</section>
</div>


<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

<script type="text/javascript">
	var table
	$(document).ready(function() {
		$('.noEnterSubmit').keypress(function (e) {
			if (e.which == 13) return false;
		});
		
		var id_req = $('#id_req').val();
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

		table = $("#example2").DataTable({
			oLanguage: {
				sProcessing: "Loading data, please wait..."
			},
			processing: true,
			serverSide: true,
			paging: false,
			// ordering: false,
			info: false,
			bFilter: false,
			ajax: {"url": "../../budget_request/subjson?id="+id_req, "type": "POST"},
			columns: [
				// {"data": "id_reqdetail"},
				{"data": "items"}, 
				{"data": "qty"},
				{"data": "unit"},
				{"data": "estimate_price"},
				{"data": "tot_estimate"},
				{"data": "remarks"},
				// {
				// 	"data" : "action",
				// 	"orderable": false,
				// 	"className" : "text-center"
				// }
			],
			columnDefs: [
				{
					targets: [3, 4], // Index of the 'estimate_price' column
					className: 'text-right' // Apply right alignment to this column
				}
			],
			order: [[0, 'asc']],
			rowCallback: function(row, data, iDisplayIndex) {
				var info = this.fnPagingInfo();
				var page = info.iPage;
				var length = info.iLength;
				// var index = page * length + (iDisplayIndex + 1);
				// $('td:eq(0)', row).html(index);
			}
		});

        $('#example2 tbody').on('click', 'tr', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                table.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
        })   				
	});
</script>