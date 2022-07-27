<script type="text/javascript">
$(document).ready(function() {
	<?php if ($showEntries)  {  ?>
		$('#showEntries').slideDown();
	<?php } else { ?>
		$('#showEntries').slideUp();
	<?php } ?>

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
					<div class="balancesheet form">
						<?php echo form_open(); ?>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?= lang('ledger_acc_name'); ?></label>
										<select class="form-control" id="ReportLedgerId" name="ledger_id">
											<?php foreach ($ledgers as $id => $ledger): ?>
												<option value="<?= $id; ?>" <?= ($id < 0) ? 'disabled' : "" ?> <?= (($this->input->post('ledger_id') == $id) or ($this->uri->segment(4) == $id)) ?'selected':''?>><?= $ledger; ?></option>
											<?php endforeach; ?>
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
										<label><?= lang('end_date') ;?></label>
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
								<?php
									if ($this->input->post('ledger_id')){
										$get = $this->input->post('ledger_id');

										if ($this->input->post('startdate')) {
											$get .= "?startdate=". $this->input->post('startdate');
										}

										if ($this->input->post('enddate')) {
											$get .= "&enddate=". $this->input->post('enddate');
										}
								?>
									<a href="<?=base_url();?>reports/ledgerstatement/false/<?= $get; ?>" type="button" name="submit" id="export_to_pdf" class="btn btn-info"><?=lang('export_to_pdf');?></a>
									<a href="<?=base_url();?>reports/export_ledgerstatement/xls/<?= $get; ?>" type="button" name="submit" id="export_to_xls" class="btn btn-primary"><?=lang('export_to_xls');?></a>
								<?php
									}
								?>
								<input type="reset" name="reset" class="btn btn-danger" value="<?= lang('clear'); ?>">
							</div>
						<?php form_close();  ?>
					</div>
					<div id="showEntries" style="display: none;">
						<div class="subtitle" id="subtitle">
							<?php echo $subtitle; ?>
						</div>
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-md-6">
								<table class="summary stripped table-condensed">
									<tr>
										<td class="td-fixwidth-summary"><?php echo lang('ledgers_views_add_label_bank_cash_account'); ?></td>
										<td id="ledger_type">
											<?php
											echo ($ledger_data['type'] == 1) ? 'Yes' : 'No';
											?>
										</td>
									</tr>
									<tr>
										<td class="td-fixwidth-summary"><?php echo lang('ledgers_views_add_label_notes'); ?></td>
										<td id="ledger_notes"><?php echo ($ledger_data['notes']); ?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-6">
								<table class="summary stripped table-condensed">
									<tr>
										<td class="td-fixwidth-summary" id="opening_title"><?php echo $opening_title; ?></td>
										<td id="opening_balance"><?php echo $this->functionscore->toCurrency($op['dc'], $op['amount']); ?></td>
									</tr>
									<tr>
										<td class="td-fixwidth-summary" id="closing_title"><?php echo $closing_title; ?></td>
										<td id="closing_balance"><?php echo $this->functionscore->toCurrency($cl['dc'], $cl['amount']); ?></td>
									</tr>
								</table>
							</div>
						</div>
  						<div class="table-responsive" id="entry_table"></div>
  						<div align="center" id="pagination_link"></div>
						<!-- <table class="stripped" id="ledgerstatement_table" style="width: 100%;">
							<thead>
								<tr>
									<th><?php echo lang('date'); ?></th>
									<th><?php echo lang('number'); ?></th>
									<th><?php echo lang('ledger'); ?></th>
									<th><?php echo lang('type'); ?></th>
									<th><?php echo lang('tag'); ?></th>
									<th><?php echo lang('dr_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
									<th><?php echo lang('cr_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
									<th><?php echo lang('balance'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
									<th><?php echo lang('actions'); ?></th>
								</tr>
							</thead>
							<?php
								/* Current opening balance */
								$entry_balance['amount'] = $current_op['amount'];
								$entry_balance['dc'] = $current_op['dc'];
								echo '<tr class="tr-highlight">';
								echo '<td colspan="7">';
								echo lang('curr_opening_balance');
								echo '</td>';
								echo '<td>' . $this->functionscore->toCurrency($op['dc'], $op['amount']) . '</td>';
								echo '<td></td>';
								echo '</tr>';
							?>
							<?php
								/* Show the entries table */
								foreach ($entries as $entry) {
									/* Calculate current entry balance */
									$entry_balance = $this->functionscore->calculate_withdc(
										$entry_balance['amount'], $entry_balance['dc'],
										$entry['amount'], $entry['dc']
									);

									$et = $this->DB1->where('id', $entry['entrytype_id'])->get('entrytypes')->row_array();
									$entryTypeName = $et['name'];
									$entryTypeLabel = $et['label'];

									/* Negative balance if its a cash or bank account and balance is Cr */
									if ($ledger_data['type'] == 1) {
										if ($entry_balance['dc'] == 'C' && $entry_balance['amount'] != '0.00') {
											echo '<tr class="error-text">';
										} else {
											echo '<tr>';
										}
									} else {
										echo '<tr>';
									}

									echo '<td>' . $this->functionscore->dateFromSql($entry['date']) . '</td>';
									echo '<td>' . ($this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id'])) . '</td>';
									echo '<td>' . ($this->functionscore->entryLedgers($entry['id'])) . '</td>';
									echo '<td>' . ($entryTypeName) . '</td>';
									echo '<td>' . $this->functionscore->showTag($entry['tag_id'])  . '</td>';

									if ($entry['dc'] == 'D') {
										echo '<td>' . $this->functionscore->toCurrency('D', $entry['amount']) . '</td>';
										echo '<td>-</td>';
									} else if ($entry['dc'] == 'C') {
										echo '<td>-</td>';
										echo '<td>' . $this->functionscore->toCurrency('C', $entry['amount']) . '</td>';
									} else {
										echo '<td>' . lang('error') . '</td><td>' . lang('error') . '</td>';
									}

									echo '<td>' . $this->functionscore->toCurrency($entry_balance['dc'], $entry_balance['amount']) . '</td>';

									echo '<td>';
								
								 	echo '<a href="'.base_url('entries/view/').($entryTypeLabel).'/'.$entry['id'].'" style="padding-right: 5px;" title="'.lang('view').'" data-toggle="tooltip"><i class="glyphicon glyphicon-log-in"></i></a>';

								 	echo '<a href="'.base_url('entries/edit/').($entryTypeLabel).'/'.$entry['id'].'" style="padding-right: 1px;" title="'.lang('edit').'" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i></a>';
								 	
								 	echo '<a href="'.base_url('entries/delete/').($entryTypeLabel).'/'.$entry['id'].'" title="'.lang('delete').'" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></a>';
									echo '</td>';
									echo '</tr>';
								}
							?>
							<?php
								/* Current closing balance */
								echo '<tr class="tr-highlight">';
								echo '<td colspan="7">';
								echo lang('curr_closing_balance');
								echo '</td>';
								echo '<td>' . $this->functionscore->toCurrency($cl['dc'], $cl['amount']) . '</td>';
								echo '<td></td>';
								echo '</tr>';
							?>
						</table> -->
						<div id="pagination"></div>
					</div>
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
		function load_country_data(page, op_balance = null) {
			$.ajax({
				url:"<?php echo base_url('reports/pagination/'); ?>"+page+"/"+op_balance,
				method:"POST",
				data: {
					ledger_id: $('#ReportLedgerId').val(),
					startdate: $('#ReportStartdate').val(),
					enddate: $('#ReportEnddate').val(),
				},
				dataType:"json",
				success:function(data) {
					$('#entry_table').html(data.entry_table.entry_table_html);
					$('#pagination_link').html(data.pagination_link);
				}
			});
		}

		$(document.body).on("change","#ReportLedgerId",function(){
			load_country_data(1);
		});

		load_country_data(1);

		$(document).on("click", ".pagination li a", function(event){
			event.preventDefault();
			var page = $(this).data("ci-pagination-page");
			var op_balance = $('#cl_td').data("op-balance");
			load_country_data(page, op_balance);
		});





		// var form_data = {
		// 	ledger_id: $('#ReportLedgerId').val(),
		// 	startdate: $('#ReportStartdate').val(),
		// 	enddate: $('#ReportEnddate').val(),
		// };

	  //   $('#pagination').pagination({
	  //   	dataSource: function(done) {
			//     $.ajax({
			//         type: 'POST',
			//         url: '<?= base_url("reports/ledgerstatement/ajax") ?>',
			//         data: {
			// 			ledger_id: form_data.ledger_id,
			// 			startdate: form_data.startdate,
			// 			enddate: form_data.enddate,
			// 		},
			//         dataType: 'json',
			//         success: function(response) {
			//         	var response_data = new Array(response);
			//             done(response_data);
			//         }
			//     })
			// },
	  //   	locator: 'items',
	  //   	totalNumber: 120,
	  //   	pageSize: 5,
	  //   	ajax: {
	  //   		beforeSend: function() {
	  //   			$('#data-container').html('Loading data from server ...');
	  //   		}
	  //   	},
	  //   	callback: function(response, pagination) {
	  //   		response = response[0];
	  //   		// console.log(response)

	  //   		if (response.id == 1) {
		 //    		var dataHtml = '';
		 //    		var items = response.data.items;

		 //    		/* Current opening balance */
	  //   			dataHtml += '<tr class="tr-highlight"><td colspan="7"><?= lang("curr_opening_balance") ?></td>';
	  //   			dataHtml += '<td colspan="2">' + response.opening_balance + '</td></tr>';

	  //   			/* Show the entries table */
		 //    		$.each(items, function (index, item) {
		 //    			/* Negative balance if its a cash or bank account and balance is Cr */
		 //    			if (response.ledger_data['type'] == 1) {
		 //    				if (response.entry_balance['dc'] == 'C' && response.entry_balance['amount'] != '0.00') {
		 //    					dataHtml += '<tr class="error-text">';
		 //    				} else {
		 //    					dataHtml += '<tr>';
		 //    				}
		 //    			} else {
		 //    				dataHtml += '<tr>';
		 //    			}

		 //    			dataHtml += '<td>' + item.date + '</td>';
		 //    			dataHtml += '<td>' + item.number + '</td>';
		 //    			dataHtml += '<td>' + item.entry_id + '</td>';
		 //    			dataHtml += '<td>' + item.entryTypeName + '</td>';
		 //    			dataHtml += '<td>' + item.tag_id + '</td>';
		 //    			dataHtml += '<td>' + item.dr_total + '</td>';
		 //    			dataHtml += '<td>' + item.cr_total + '</td>';
		 //    			dataHtml += '<td>' + item.balance + '</td>';
				
			// 		 	dataHtml += '<td><a href="<?= base_url("entries/view/"); ?>'+(item.entryTypeLabel)+'/'+item.id+'" style="padding-right: 5px;" title="<?= lang('view'); ?>" data-toggle="tooltip"><i class="glyphicon glyphicon-log-in"></i></a>';

			// 		 	dataHtml += '<a href="<?= base_url("entries/edit/"); ?>'+(item.entryTypeLabel)+'/'+item.id+'" style="padding-right: 1px;" title="<?= lang('edit'); ?>" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i></a>';

			// 		 	dataHtml += '<a href="<?= base_url("entries/delete/"); ?>'+(item.entryTypeLabel)+'/'+item.id+'" title="<?= lang('delete'); ?>" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></a></td>';

	  //   				dataHtml += '</tr>';
		 //    		});

		 //    		/* Current closing balance */
		 //    		dataHtml += '<tr class="tr-highlight"><td colspan="7"><?= lang("curr_closing_balance") ?></td>';
	  //   			dataHtml += '<td colspan="2">' + response.closing_balance + '</td></tr>';

		 //    		$('#data-container').html(dataHtml);
	  //   		}
	    		
	  //   		// if (response.id == 0) {
	  //   		// 	toastr[response.status](response.msg, "<?php // echo lang('toastr_error_heading'); ?>");
	  //   		// }

	  //   		// var dataHtml = '<tr>';

	  //   		// $.each(response, function (index, item) {
	  //   		// 	dataHtml += '<li>' + item.title + '</li>';
	  //   		// });

	  //   		// dataHtml += '</tr>';	
	  //   	}
	  //   });
	});
</script>