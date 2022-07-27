<script type="text/javascript">
$(document).ready(function() {
	/* Calculate date range in javascript */
	startDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
	endDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));

	$(document.body).on("change","#ReportLedgerId",function(){
		if(this.value == 0){
			$('#ReportStartdate').prop('disabled', true);
			$('#ReportEnddate').prop('disabled', true);
		} else {
			$('#ReportStartdate').prop('disabled', false);
			$('#ReportEnddate').prop('disabled', false);
		}
	});
	$('#ReportLedgerId').trigger('change');

	/* Setup jQuery datepicker ui */
	$('#ReportStartdate').datepicker({
		minDate: startDate,
		maxDate: endDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#ReportEnddate").datepicker("option", "minDate", selectedDate);
			} else {
				$("#ReportEnddate").datepicker("option", "minDate", startDate);
			}
		}
	});
	$('#ReportEnddate').datepicker({
		minDate: startDate,
		maxDate: endDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#ReportStartdate").datepicker("option", "maxDate", selectedDate);
			} else {
				$("#ReportStartdate").datepicker("option", "maxDate", endDate);
			}
		}
	});

	$("#ReportLedgerId").select2({width:'100%'});
});
</script>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?= $title; ?></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="balancesheet form">
						<?php echo form_open(); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?= lang('ledger_acc_name'); ?></label>
									<select class="form-control" id="ReportLedgerId" name="ledger_id">
										<option value="2">Semua</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?= lang('start_date'); ?></label>

									<div class="input-group">
										<input id="ReportStartdate" type="text" name="startdate" class="form-control" value="<?=(isset($startdate) ? $startdate : '');?>">
										<div class="input-group-addon">
											<i>
												<div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('start_date_span') ;?>">
												</div>
											</i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?= lang('end_date'); ?></label>

									<div class="input-group">
										<input id="ReportEnddate" type="text" name="enddate" class="form-control" value="<?=(isset($enddate) ? $enddate : '');?>">
										<div class="input-group-addon">
											<i>
												<div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('end_date_span') ;?>">
												</div>
											</i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
						</div>
						<div class="btn-group pull-right">
							<input type="submit" name="submit" id="search_submit" class="btn btn-success" value="<?=lang('submit');?>">
							<a href="" type="button" name="submit" style="display: none;" id="export_to_pdf" class="btn btn-info"><?=lang('export_to_pdf');?></a>
							<a href="" type="button" name="submit" style="display: none;" id="export_to_xls" class="btn btn-primary"><?=lang('export_to_xls');?></a>
							<input type="reset" name="clear" onClick="clearLocalStorage(); return false;" class="btn btn-danger" value="<?= lang('clear'); ?>">
						</div>
						<?php form_close();  ?>
					</div>
					<!-- /.balancesheet /.form -->
					<div id="section-to-print">
						<div id="showEntries" style="display: none;">
							<div class="subtitle" id="subtitle"></div>
							<!-- <div class="row" style="margin-bottom: 10px;">
								<div class="col-md-6">
									<table class="summary stripped table-condensed">
										<tr>
											<td class="td-fixwidth-summary">
												<?php echo lang('ledgers_views_add_label_bank_cash_account'); ?>
											</td>
											<td id="ledger_type"></td>
										</tr>
										<tr>
											<td class="td-fixwidth-summary">
												<?php echo ('Notes'); ?>
											</td>
											<td id="ledger_notes"></td>
										</tr>
									</table>
								</div>
								<div class="col-md-6">
									<table class="summary stripped table-condensed">
										<tr>
											<td class="td-fixwidth-summary" id="opening_title"></td>
											<td id="opening_balance"></td>
										</tr>
										<tr>
											<td class="td-fixwidth-summary" id="closing_title"></td>
											<td id="closing_balance"></td>
										</tr>
									</table>
								</div>
							</div> -->
							<table class="stripped" id="ledgerentries_table" style="width: 100%;">
								<thead>
									<tr>
										<th><?php echo lang('date'); ?></th>
										<th><?php echo lang('number'); ?></th>
										<th><?php echo lang('ledger'); ?></th>
										<th><?php echo lang('entries_views_index_th_type'); ?></th>
										<th><?php echo lang('entries_views_index_th_tag'); ?></th>
										<th><?php echo lang('entries_views_index_th_debit_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
										<th><?php echo lang('entries_views_index_th_credit_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
										<th><?php echo lang('entries_views_index_th_actions'); ?></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- /#section-to-print -->
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>
<!-- /.content -->

<script type="text/javascript">
	$(document).ready(function() {
		
			if ($(this).val() == 0) {
				$('#showEntries').slideUp();

				$('#export_to_pdf').hide();
				$('#export_to_pdf').attr('href', '#');

				$('#export_to_xls').hide();
				$('#export_to_xls').attr('href', '#');

				$('#ReportStartdate').val('');
				$('#ReportEnddate').val('');
				localStorage.clear();
			}
			localStorage.setItem('ledger_id_entries', 2);
        

		$('#ReportStartdate').change(function (e) {
            localStorage.setItem('startdate_entries', $(this).val());
        });

        $('#ReportEnddate').change(function (e) {
            localStorage.setItem('enddate_entries', $(this).val());
        });

		if (startdate = localStorage.getItem('startdate_entries')) {
			$('#ReportStartdate').val(startdate);
		}

		if (enddate = localStorage.getItem('enddate_entries')) {
			$('#ReportEnddate').val(enddate);
		}

		if (ledger_id = localStorage.getItem('ledger_id_entries')) {
			$('#ReportLedgerId').val(ledger_id).trigger('change');
			search_submit();
		}
	});

	$('#search_submit').on('click', function(e) {
		e.preventDefault();
		search_submit();
    });

	function search_submit() {
		var form_data = {
			id: localStorage.getItem('ledger_id_entries'),
			startDate: localStorage.getItem('startdate_entries'),
			endDate: localStorage.getItem('enddate_entries')
		};

		jQuery.ajax({  
			url:"<?= base_url(); ?>reports/ledgerentries/ajax",  
			data: {
				ledger_id: form_data.id,
				startdate: form_data.startDate,
				enddate: form_data.endDate
			},
			dataType: "json",
			type: 'POST',
			success:function(data) {
				console.log(data.id);
				if (data.id == 1) {
					$('#showEntries').slideDown();

					$('#subtitle').text(data.subtitle);
					if (data.ledger_data.type == 1) {
						$('#ledger_type').text('Yes');
					} else {
						$('#ledger_type').text('No');
					}
					$('#ledger_notes').text(data.ledger_data.notes);
					$('#opening_title').text(data.opening_title);
					$('#opening_balance').text(data.opening_balance);
					$('#closing_title').text(data.closing_title);
					$('#closing_balance').text(data.closing_balance);

					var id = data.ledger_data.id;
					var startdate = data.startDate;
					var enddate = data.endDate;

					if (id) {
						var get = id;

						$('#export_to_pdf').show();
						$('#export_to_xls').show();

						if (startdate) {
							get += "?startdate="+startdate;
						}

						if (enddate) {
							get += "&enddate="+enddate;
						}

						$('#export_to_pdf').attr('href', '<?=base_url("reports/ledgerentries/false/");?>'+get);
						$('#export_to_xls').attr('href', '<?=base_url("reports/export_ledgerentries/xls/");?>'+get);
					}
							
					if ($.fn.DataTable.isDataTable('#ledgerentries_table')) {
					  	$('#ledgerentries_table').DataTable().destroy();
					}

					/* Datatables */
				    $('#ledgerentries_table').DataTable({ 
				        "processing": true, //Feature control the processing indicator.
				        "serverSide": true, //Feature control DataTables' server-side processing mode.
				        'displayLength': site.msettings.row_count,
				        "order": [[0, "asc"]], //Initial no order.
				        // Load data for the table's content from an Ajax source
				        "ajax": {
				            "url": "<?= base_url('reports/getSearchedEntries/ledgerentries') ?>",
				            "type": "POST",
				            'data': {form_data: form_data}
				        },
				        "columns": [
				        	{
				        		data: 'date'
				        	},
					        {
					        	data: 'number'
					    	},
					        {
					        	data: 'id',
					        	"orderable": false
					        },
					        {
					        	data: 'entryTypeName'
					    	},
					        {
					        	data: 'tag_id'
					    	},
					        {
					        	data: 'dr_total',
					        	
					        },
				        	{
				        		data: 'cr_total',
				        		
				        	},
				        	{
				        		data: 'Actions',
				        		"orderable": false
				        	},
				        ]
				    });
				} else if (data.status == 'error') {
					toastr[data.status](data.msg, "<?php echo lang('toastr_error_heading'); ?>");
				}
			}
	    });
	}
</script>