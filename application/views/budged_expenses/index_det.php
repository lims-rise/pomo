<div class="content-wrapper">
	<section class="content">
		<div class="box box-black box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Purchase Order | Budged Expenses Detail</h3>
			</div>
			<form role="form"  id="formKeg" method="post" class="form-horizontal">
				<div class="box-body">
					<input type="hidden" class="form-control " id="id_req" name="id_req" value="<?php echo $id_req ?>">
					<!-- <input id="id_req" name="id_req" type="hidden" class="form-control input-sm"> -->

					<div class="form-group">
						<label for="po_number2" class="col-sm-2 control-label">PO number</label>
						<div class="col-sm-4">
							<input class="form-control " id="po_number2" name="po_number2" value="<?php echo $po_number ?>"  disabled>
						</div>

						<label for="objective" class="col-sm-2 control-label">Objective</label>
						<div class="col-sm-4">
							<input class="form-control " id="objective" name="objective" value="<?php echo $objective ?>" disabled>
						</div>
					</div>

					<div class="form-group">
						<label for="budged_req" class="col-sm-2 control-label">Budged Request</label>
						<div class="col-sm-4">
							<input class="form-control " id="budged_req" name="budged_req" value="<?php echo $budged_req ?>"  disabled>
						</div>
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-4">
							<input class="form-control " id="title" name="title" value="<?php echo $title ?>"  disabled>
						</div>
					</div>

					<div class="form-group">
						<label for="budged_tot" class="col-sm-2 control-label">Total Budged Expenses</label>
						<div class="col-sm-4">
							<input class="form-control " id="budged_tot" name="budged_tot" value="<?php echo $budged_tot ?>" disabled>
						</div>

						<label for="budged_rem" class="col-sm-2 control-label">Budged Expenses Remaining</label>
						<div class="col-sm-4">
							<input class="form-control " id="budged_rem" name="budged_rem" value="<?php echo $budged_rem ?>" disabled>
						</div>
					</div>

				</div><!-- /.box-body -->
				</form>

				<div class="box-footer">

                <!-- <div class="row"> -->
                    <div class="col-xs-12"> 
                        <div class="box box-primary box-solid">
            
                            <div class="box-header">
                                <h3 class="box-title">Detail Expenses</h3>
                            </div>
							<div class="box-body pad table-responsive">
							<?php
								$lvl = $this->session->userdata('id_user_level');
								if ($lvl != 7){
									echo "<button class='btn btn-primary' id='addtombol_det'><i class='fa fa-wpforms' aria-hidden='true'></i> New Data</button>";
								}
							?>
							
							<!-- <button class='btn btn-warning' id='addtombol'><i class="fa fa-wpforms" aria-hidden="true"></i> New Data</button> -->
							<table id="example2" class="table display table-bordered table-striped" width="100%">
								<thead>
									<tr>
										<th>Date Expenses</th>
										<th>Items</th>
										<th>Qty</th>
										<th>Unit</th>
										<th>Price per-Unit</th>
										<th>Total Price</th>
										<th>Remarks</th>
										<th>Action</th>
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
							<!-- <button type="button" name="excel" id="excel" class="btn btn-success" onclick="location.href='<?php echo site_url('Budged_expenses/excel_print'); ?>';"><i class="fa fa-file-excel-o"></i> Excel</button>
							<button type="button" name="print" id="print" class="btn btn-primary" onclick="javascript:void(0);"><i class="fa fa-print"></i> Print</button> -->
							<button type="button" name="batal" value="batal" class="btn btn-warning" onclick="javascript:history.go(-1);"><i class="fa fa-times"></i> Close</button>
						</div>
					</div>

				</div> <!--footer-->

		</div>
	</section>
</div>


        <!-- MODAL FORM -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal-title-detail">Add Budged Items<span id="my-another-cool-loader"></span></h4>
                    </div>
                    <form id="formDetail" action=<?php echo site_url('Budged_expenses/savedetail') ?> method="post" class="form-horizontal">
                        <div class="modal-body">
						<div class="form-group">
                                <div class="col-sm-9">
                                    <input id="mode_det" name="mode_det" type="hidden" class="form-control input-sm">
                                    <!-- <input id="id_reqdet" name="id_reqdet" type="hidden" class="form-control input-sm"> -->
									<input id="id_exp" name="id_exp" type="hidden" class="form-control input-sm">
									<input type="hidden" class="form-control " id="id_req" name="id_req" value="<?php echo $id_req ?>">
									<input class="form-control" type="hidden" id="po_number" name="po_number" value="<?php echo $po_number ?>">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="id_reqdetail" class="col-sm-4 control-label">PO Number</label>
                                <div class="col-sm-8">
                                    <input id="id_reqdetail" name="id_reqdetail" type="text" class="form-control input-sm noEnterSubmit" placeholder="PO Number" required>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="items" class="col-sm-4 control-label">Date Expenses</label>
                                <div class="col-sm-8">
									<input class="form-control" type="date" id="date_expenses" name="date_expenses" value="<?php echo date("Y-m-d"); ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="items" class="col-sm-4 control-label">Item</label>
                                <div class="col-sm-8">
									<!-- <input class="form-control" type="hidden" id="po_number" name="po_number" value="<?php echo $po_number ?>"  disabled> -->
                                    <input id="items" name="items" type="text" placeholder="Item" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="qty" class="col-sm-4 control-label">Qty</label>
                                <div class="col-sm-8">
                                    <input id="qty" name="qty" type="number" placeholder="Qty" class="form-control">
                                </div>
                            </div>

							<div class="form-group">
								<label for="id_unit" class="col-sm-4 control-label">Unit</label>
								<div class="col-sm-8" >
								<select id='id_unit' name="id_unit" class="form-control">
									<option>-- Select unit --</option>
									<?php
									foreach($unit as $row){
										if ($id_unit == $row['id_unit']) {
											echo "<option value='".$row['id_unit']."' selected='selected'>".$row['unit']."</option>";
										}
										else {
											echo "<option value='".$row['id_unit']."'>".$row['unit']."</option>";
										}
									}
										?>
								</select>
								</div>
							</div>
														
							<div class="form-group">
								<label for="expenses" class="col-sm-4 control-label">Actual Price</label>
								<div class="col-sm-8">
									<input id="expenses" name="expenses" type="text" class="form-control" placeholder="Actual Price" required>
								</div>
							</div>							
							<div class="form-group">
                                <label for="remarks" class="col-sm-4 control-label">Remarks</label>
                                <div class="col-sm-8">
                                    <textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks"> </textarea>
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

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

<script type="text/javascript">
	var table
	$(document).ready(function() {
		$('.noEnterSubmit').keypress(function (e) {
			if (e.which == 13) return false;
		});
						
        $('#compose-modal').on('shown.bs.modal', function () {
			$('#items').focus();
			// $.ajax({
			// 	type: "POST",
			// 	url: "<?php //echo site_url('Budged_expenses/getSumEstimatePrice/') ?>" + id_req,
			// 	success: function(data) {
			// 		var sumEstimatePrice = parseFloat(data);
			// 		var budgedReq = parseFloat($('#budged_req').val().replace(/,/g, ''));
			// 		var budgedRem = budgedReq - sumEstimatePrice;
			// 		$('#budged_rem').val(budgedRem.toLocaleString('en-US', { maximumFractionDigits: 2 }));
			// 		// $('#budged_rem').val(budgedRem);
			// 	}
			// });

			$('#expenses').on('input', function() {
                formatNumber(this);
                });

			// let table = $('#example2').DataTable(); 
			// let sumCount = table.rows().sum();
			// $('#budged_rem').val(sumCount);				
            });

        function formatNumber(input) {
            input.value = input.value.replace(/[^\d.]/g, '').replace(/\.(?=.*\.)/g, '');
            if (input.value !== '') {
                var numericValue = parseFloat(input.value.replace(/\./g, '').replace(',', '.'));
                input.value = numericValue.toLocaleString('en-US', { maximumFractionDigits: 2 });
                input.value = input.value.replace(/,/g, '.');
            }
        }

		
		var id = $('#po_number').val();
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
			ajax: {"url": "../../Budged_expenses/subjson?id="+id, "type": "POST"},
			columns: [
				{"data": "date_expenses"},
				{"data": "items"}, 
				{"data": "qty"},
				{"data": "unit"},
				{"data": "expenses"},
				{"data": "tot_expenses"},
				{"data": "remarks"},
				{
					"data" : "action",
					"orderable": false,
					"className" : "text-center"
				}
			],
			columnDefs: [
				{
					targets: [4, 5], // Index of the 'estimate_price' column
					className: 'text-right' // Apply right alignment to this column
				}
			],
			// columnDefs: [
			// 	{
			// 		targets: [0, 1, 2, 3, 6, 7], // Index of the 'estimate_price' column
			// 		className: 'text-center' // Apply right alignment to this column
			// 	}
			// ],
			order: [[0, 'asc']],
			rowCallback: function(row, data, iDisplayIndex) {
				var info = this.fnPagingInfo();
				var page = info.iPage;
				var length = info.iLength;
				// var index = page * length + (iDisplayIndex + 1);
				// $('td:eq(0)', row).html(index);
			}
		});

		// $('#compose-modal').on('shown.bs.modal', function () {
		// 	if ($('#mode_det').val() == 'insert') {
		// 		let table = $('#example2').DataTable(); 
		// 		let rowCount = table.rows().count();
		// 		$('#id_reqdetail').val(rowCount+1);
		// 	}
        //     $('#result').focus();
		// });        

		// $('#print').click(function() {
		// 	location.href = '../../Budged_expenses/budreq_print/'+id_req;
		// });


		$('#addtombol_det').click(function() {
			$('#mode_det').val('insert');
            $('#modal-title-detail').html('<i class="fa fa-wpforms"></i> New detail expenses<span id="my-another-cool-loader"></span>');
			$('#id_exp').attr('readonly', false);
		    $('#id_exp').val('');
		    $('#items').val('');
		    $('#qty').val('');
		    $('#id_unit').val('');
		    $('#expenses').val('');
		    $('#remarks').val('');
			$('#compose-modal').modal('show');
		});


		$('#example2').on('click', '.btn_edit_det', function(){
			let tr = $(this).parent().parent();
			let data = table.row(tr).data();
			console.log(data);
			$('#mode_det').val('edit');
			$('#modal-title-detail').html('<i class="fa fa-pencil-square"></i> Update detail expenses<span id="my-another-cool-loader"></span>');
			$('#id_exp').attr('readonly', true);
		    $('#id_exp').val(data.id_exp);
		    $('#po_number').val(data.po_number);
		    $('#date_expenses').val(data.date_expenses);
		    $('#items').val(data.items);
		    $('#qty').val(data.qty);
		    $('#id_unit').val(data.id_unit).trigger('change');
		    $('#expenses').val(data.expenses);
		    $('#remarks').val(data.remarks);
			$('#compose-modal').modal('show');
		});  

	});
</script>