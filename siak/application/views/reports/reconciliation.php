<script type="text/javascript">
$(document).ready(function() {
	/* Calculate date range in javascript */
	startDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
	endDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));

	$("#ReportLedgerId").select2({width:'100%'});
	
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
		dateFormat: site.date_format[1],
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
		dateFormat: site.date_format[1],
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#ReportStartdate").datepicker("option", "maxDate", selectedDate);
			} else {
				$("#ReportStartdate").datepicker("option", "maxDate", endDate);
			}
		}
	});
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
					<?php $attributes = array('accept-charset' => 'utf-8', 'method' => 'post'); echo form_open(base_url('reports/reconciliation'), $attributes); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?= lang('ledger_acc_name'); ?></label>
									<select class="form-control" id="ReportLedgerId" name="ledger_id">
										<?php foreach ($ledgers as $id => $ledger): ?>
											<option value="<?= $id; ?>" <?= ($id < 0) ? 'disabled' : "" ?> <?= ($this->input->post('ledger_id') == $id) ?'selected':''?>><?= $ledger; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-3">
								<div class="form-group">
									<label><?= lang('start_date'); ?></label>
									<div class="input-group">
										<input id="ReportStartdate" type="text" name="startdate" class="form-control">
										<div class="input-group-addon">
											<i>
												<div class="fa fa-info-circle" data-toggle="tooltip" title="<?=lang('start_date_span');?>">
												</div>
											</i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
							<!-- /.col -->
							<div class="col-md-3">
								<div class="form-group">
									<label><?= lang('end_date') ;?></label>
									<div class="input-group">
										<input id="ReportEnddate" type="text" name="enddate" class="form-control">
										<div class="input-group-addon">
											<i>
												<div class="fa fa-info-circle" data-toggle="tooltip" title="<?=lang('end_date_span');?>">
												</div>
											</i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
						<div class="form-group">
							<label>
								<input type="checkbox" id="showall" name="showall" class="form-control"> <?= lang('show_all_entries');?>
							</label>
							<div class="btn-group pull-right">
								<input type="submit" name="submit_ledger" id="search_submit" class="btn btn-success" value="<?=lang('submit');?>">
								<input name="clear" onClick="clearLocalStorage(); return false;" type="reset" class="btn btn-danger" value="<?=lang('clear');?>">
							</div>
						</div>
						<!-- /.form-group -->
						<div id="showEntries" style="display: none;">
							<div id="subtitle" class="subtitle text-center"></div>
							<!-- /.subtitle -->
							<table class="summary stripped table table-condensed">
								<tr>
									<td class="td-fixwidth-summary-info">
										<?php echo lang('ledgers_views_add_label_bank_cash_account'); ?>
									</td>
									<td id="ledger_type">
									</td>
								</tr>
								<tr>
									<td class="td-fixwidth-summary-info">
										<?php echo lang('ledger'); ?>
									</td>
									<td id="ledger_notes">
									</td>
								</tr>
							</table>
							<!-- /.summary -->
							<div class="row" style="margin-bottom: 10px; margin-top: 10px;">
								<!-- <div class="col-md-3"></div> -->
								<!-- /.col -->
								<div class="col-md-6">	
									<table class="summary stripped table table-condensed">
										<tr>
											<td class="td-fixwidth-summary" id="opening_title">
											</td>
											<td id="opening_balance">
											</td>
										</tr>
										<tr>
											<td class="td-fixwidth-summary" id="closing_title">
											</td>
											<td id="closing_balance">
											</td>
										</tr>
									</table>
									<!-- /.summary -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<table class="summary stripped table table-condensed">
										<tr>
											<td class="td-fixwidth-summary" id="recpending_title_d">
											</td>
											<td id="recpending_balance_d">
											</td>
										</tr>
										<tr>
											<td class="td-fixwidth-summary" id="recpending_title_c">
											</td>
											<td id="recpending_balance_c">
											</td>
										</tr>
									</table>
									<!-- /.summary -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							<table id="reconciliation_table" class="stripped">
								<thead>
									<tr>
										<th><?php echo lang('date'); ?></th>
										<th><?php echo lang('number'); ?></th>
										<th><?php echo lang('ledger'); ?></th>
										<th><?php echo lang('entries_views_index_th_type'); ?></th>
										<th><?php echo lang('entries_views_index_th_tag'); ?></th>
										<th><?php echo lang('entries_views_index_th_debit_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
										<th><?php echo lang('entries_views_index_th_credit_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
										<th><?php echo lang('reconciliation_data');?></th>
									</tr>
								</thead>
							</table>
							<!-- /.stripped -->
							<br />
							<?php echo form_hidden('submitrec', 1); ?>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-primary" value="<?=lang('Reconcile');?>">
							</div>
						</div>
					<?= form_close(); ?>
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
		$('#ReportLedgerId').change(function (e) {
			if ($(this).val() == 0) {
				$('#showEntries').slideUp();

				$('#ReportStartdate').val('');
				$('#ReportEnddate').val('');
				$('#showall').iCheck('uncheck');
				localStorage.clear();
			}
			localStorage.setItem('ledger_id_reconcile', $(this).val());
        });

		$('#ReportStartdate').change(function (e) {
            localStorage.setItem('startdate_reconcile', $(this).val());
        });

        $('#ReportEnddate').change(function (e) {
            localStorage.setItem('enddate_reconcile', $(this).val());
        });

        $('#showall').on('ifChanged', function(event){
          	if (event.target.checked){
            	localStorage.setItem('showall_reconcile', 1);
          	} else {
            	localStorage.setItem('showall_reconcile', 0);
          	}
        });

		if (startdate = localStorage.getItem('startdate_reconcile')) {
			$('#ReportStartdate').val(startdate);
		}

		if (enddate = localStorage.getItem('enddate_reconcile')) {
			$('#ReportEnddate').val(enddate);
		}

		if (showall = localStorage.getItem('showall_reconcile')) {
			if (showall == 0) {
				$('#showall').iCheck('uncheck');
			} else {
				$('#showall').iCheck('check');
			}
		}

		if (ledger_id = localStorage.getItem('ledger_id_reconcile')) {
			$('#ReportLedgerId').val(ledger_id).trigger('change');
			search_submit();
		}
	});

	$('#search_submit').on('click', function(e) {
		e.preventDefault();
		search_submit();
    });

    function reconcileDate(x) {
    	var v = x.split('__');
    	var formated_date = "";
    	if (v[2]) {
    		formated_date = $.format.date(new Date(v[2]), site.date_format[2]);
    	}
    	return '<input type="hidden" name="ReportRec['+v[0]+'][id]" value="'+v[1]+'"><input type="text" name="ReportRec['+v[0]+'][recdate]" value="'+formated_date+'" class="recdate">';
    }

	function search_submit() {
		var form_data = {
			id: localStorage.getItem('ledger_id_reconcile'),
			startDate: localStorage.getItem('startdate_reconcile'),
			endDate: localStorage.getItem('enddate_reconcile'),
			showall: localStorage.getItem('showall_reconcile'),
		};

		jQuery.ajax({  
			url:"<?= base_url(); ?>reports/reconciliation/ajax",  
			data: {
				ledger_id: form_data.id,
				startdate: form_data.startDate,
				enddate: form_data.endDate,
				showall: form_data.showall
			},
			dataType: "json",
			type: 'POST',
			success:function(data) {
				if (data.id == 1) {
					$('#showEntries').slideDown();

					$('#subtitle').text(data.subtitle);
					if (data.ledger_data.type == 1) {
						$('#ledger_type').text('Ya');
					} else {
						$('#ledger_type').text('Tidak');
					}
					$('#ledger_notes').text(data.ledger_data.notes);
					$('#opening_title').text(data.opening_title);
					$('#opening_balance').text(data.opening_balance);
					$('#closing_title').text(data.closing_title);
					$('#closing_balance').text(data.closing_balance);

					$('#recpending_title_d').text('<?= lang('debit'); ?> ' + data.recpending_title);
					$('#recpending_balance_d').text(data.recpending_balance_d);
					$('#recpending_title_c').text('<?= lang('credit'); ?> ' + data.recpending_title);
					$('#recpending_balance_c').text(data.recpending_balance_c);

					var id = data.ledger_data.id;
					var startdate = data.startDate;
					var enddate = data.endDate;
							
					if ($.fn.DataTable.isDataTable('#reconciliation_table')) {
					  	$('#reconciliation_table').DataTable().destroy();
					}

					/* Datatables */
				    $('#reconciliation_table').DataTable({ 
				        "processing": true, //Feature control the processing indicator.
				        "serverSide": true, //Feature control DataTables' server-side processing mode.
				        'displayLength': site.msettings.row_count,
				        "order": [[0, "asc"]], //Initial no order.
				        // Load data for the table's content from an Ajax source
				        "ajax": {
				            "url": "<?= base_url('reports/getSearchedEntries/reconciliation') ?>",
				            "type": "POST",
				            'data': {form_data: form_data}
				        },
				        "fnDrawCallback":function(){
				        	$('.recdate').datepicker({
								minDate: startDate,
								maxDate: endDate,
								dateFormat: site.date_format[1],
								numberOfMonths: 1,
					        })
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
					        	"render": price_input_D
					        },
				        	{
				        		data: 'cr_total',
				        		"render": price_input_C
				        	},
				        	{
				        		data: 'RecDate',
				        		"orderable": false,
				        		"render": reconcileDate
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

<style type="text/css">
	.summary {
	    background-color: #FFFFCC;
	    border: 1px solid #BBBBBB;
	    border-collapse: collapse;
	    text-align: left;
	    width: 100%;
	}

	.summary td {
	    border: 1px solid #BBBBBB;
	}

	.td-fixwidth-summary {
	    width: 80%;
	    vertical-align: text-top;
	}

	.td-fixwidth-summary-info {
	    width: 200px;
	    vertical-align: text-top;
	}
</style>