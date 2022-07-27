<script type="text/javascript">
$(document).ready(function() {
	/* Calculate date range in javascript */
	fromDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
	toDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));

	/* Setup jQuery datepicker ui */
	$('#SearchFromdate').datepicker({
		minDate: fromDate,
		maxDate: toDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#SearchTodate").datepicker("option", "minDate", selectedDate);
			} else {
				$("#SearchTodate").datepicker("option", "minDate", fromDate);
			}
		}
	});
	$('#SearchTodate').datepicker({
		minDate: fromDate,
		maxDate: toDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#SearchFromdate").datepicker("option", "maxDate", selectedDate);
			} else {
				$("#SearchFromdate").datepicker("option", "maxDate", toDate);
			}
		}
	});

	$('#search_submit').on('click', function(e) {
		e.preventDefault();
				
		if ($.fn.dataTable.isDataTable('.stripped')) {
		  	$('.stripped').DataTable().destroy();
		}

		/* Datatables */
	    var table = $('.stripped').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        'displayLength': site.msettings.row_count,
	        "order": [[0, "asc"]], //Initial no order.
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?= base_url('search/getSearchedEntries') ?>",
	            "type": "POST",
	            'data': {form_data: $('#search_form').serializeArray()}
	        },
	        //Set column definition initialisation properties.
	        // "columnDefs": [
	        // { 
	        //     "targets": [ 0 ], //first column / numbering column
	        //     "orderable": false, //set not orderable
	        // },
	        // ],
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
	        		data: 'Actions',
	        		"orderable": false
	        	},
	        ]
	    });
    });

    $('#SearchEntrynumberRestriction').on('change', function() {
            if (this.value == 4) {
                    $('.entrynumber-in-between').show();
            } else {
                    $('.entrynumber-in-between').hide();
            }
    });

    $('#SearchAmountRestriction').on('change', function() {
            if (this.value == 4) {
                    $('.amount-in-between').show();
            } else {
                    $('.amount-in-between').hide();
            }
    });

	/* On page load initiate all triggers */
    $('#SearchEntrynumberRestriction').trigger('change');
	$('#SearchAmountRestriction').trigger('change');

	$(".ledger-dropdown").select2({width:'100%'});
	$(".entrytype-dropdown").select2({width:'100%'});
	$(".tag-dropdown").select2({width:'100%'});
});
</script>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?= lang('search_views_title'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div>
				<div class="search form">
				<?php $attributes = array('id' => 'search_form'); echo form_open('', $attributes); ?>
				<div class="row">
					<div class="col-md-6">
						<fieldset>
							<legend><?= lang('search_views_legend_ledgers'); ?></legend>
							<div class="form-group">
								<select class="ledger-dropdown form-control" name="ledger_ids[]" multiple="multiple">
									<?php foreach ($ledger_options as $id => $ledger): ?>
										<option value="<?= $id; ?>" <?= ($id < 0) ? 'disabled' : "" ?>  <?php echo (isset($_POST['ledger_ids']) && in_array($id, $_POST['ledger_ids'])) ? 'selected' : ''; ?>><?= $ledger; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</fieldset>
					</div>
					<div class="col-md-6">
						<fieldset>
							<legend><?= lang('entrytypes') ?></legend>
							<div class="form-group">
								<select class="entrytype-dropdown form-control" name="entrytype_ids[]" multiple="multiple" >
									<?php foreach ($entrytype_options as $id => $et): ?>
										<option value="<?= $id; ?>" <?php echo (isset($_POST['entrytype_ids']) && in_array($id, $_POST['entrytype_ids'])) ? 'selected' : ''; ?>><?= $et; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</fieldset>
					</div>
				</div>

				<br>

				<fieldset>
					<legend><?= lang('search_views_legend_entry_number') ?></legend>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label><?= lang('search_views_label_condition') ?></label>
								<select class="form-control" id="SearchEntrynumberRestriction" name="entrynumber_restriction">
									<option value="1" <?= ($this->input->post('entrynumber_restriction') == 1) ? 'selected' : '' ?> ><?= lang('search_views_entry_number_equal') ?></option>
									<option value="2" <?= ($this->input->post('entrynumber_restriction') == 2) ? 'selected' : '' ?> ><?= lang('search_views_entry_number_less_equal') ?></option>
									<option value="3" <?= ($this->input->post('entrynumber_restriction') == 3) ? 'selected' : '' ?> ><?= lang('search_views_entry_number_greater_equal') ?></option>
									<option value="4" <?= ($this->input->post('entrynumber_restriction') == 4) ? 'selected' : '' ?> ><?= lang('search_views_entry_number_between') ?></option>
								</select>
							</div>
							<div class="col-md-4">
							<label><?= lang('search_views_label_from') ?></label>
								<input type="text" value="<?= set_value('entrynumber1'); ?>" class="form-control" name="entrynumber1">
							</div>
							<div class="col-md-4 entrynumber-in-between">
							<label><?= lang('search_views_label_to') ?></label>
								<input type="text" value="<?= set_value('entrynumber2'); ?>" class="form-control" name="entrynumber2">
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?= lang('search_views_legend_amount') ?></legend>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label><?= lang('search_views_label_dr_or_cr') ?></label>
								<select class="form-control" name="amount_dc">
									<option value="0" <?= ($this->input->post('amount_dc') == '0') ? 'selected' : '' ?>><?= lang('search_views_dr_or_cr_option_any') ?></option>
									<option value="D" <?= ($this->input->post('amount_dc') == "D") ? 'selected' : '' ?>><?= lang('search_views_dr_or_cr_option_dr') ?></option>
									<option value="C" <?= ($this->input->post('amount_dc') == "C") ? 'selected' : '' ?>><?= lang('search_views_dr_or_cr_option_cr') ?></option>
								</select>
							</div>
							<div class="col-md-3">
								<label><?= lang('search_views_label_condition') ?></label>
								<select class="form-control" id="SearchAmountRestriction" name="amount_restriction">
									<option value="1" <?= ($this->input->post('amount_restriction') == 1) ? 'selected' : '' ?> ><?= lang('search_views_condition_equal') ?></option>
									<option value="2" <?= ($this->input->post('amount_restriction') == 2) ? 'selected' : '' ?> ><?= lang('search_views_condition_less_equal') ?></option>
									<option value="3" <?= ($this->input->post('amount_restriction') == 3) ? 'selected' : '' ?> ><?= lang('search_views_condition_greater_equal') ?></option>
									<option value="4" <?= ($this->input->post('amount_restriction') == 4) ? 'selected' : '' ?> ><?= lang('search_views_condition_between') ?></option>
								</select>
							</div>
							<div class="col-md-3">
								<label><?= lang('search_views_label_amount') ?></label>
								<input type="text" class="form-control" value="<?= set_value('amount1'); ?>" name="amount1">
							</div>

							<div class="col-md-3 amount-in-between">
								<label><?= lang('search_views_label_amount_in_between') ?></label>
								<input type="text" class="form-control " value="<?= set_value('amount2'); ?>" name="amount2">
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?= lang('search_views_legend_date') ?></legend>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label><?= lang('search_views_label_from') ?></label>
								<input type="text" class="form-control" id="SearchFromdate" value="<?= set_value('fromdate'); ?>" name="fromdate">
							</div>

							<div class="col-md-4">
								<label><?= lang('search_views_label_to') ?></label>
								<input type="text" class="form-control" id="SearchTodate" value="<?= set_value('todate'); ?>" name="todate">
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?= lang('search_views_legend_tags') ?></legend>
					<div class="form-group">
						<select class="form-control tag-dropdown" name="tag_ids[]" multiple="multiple">
							<?php foreach ($tag_options as $id => $tag): ?>
								<option value="<?= $id; ?>" <?php echo (isset($_POST['tag_ids']) && in_array($id, $_POST['tag_ids'])) ? 'selected' : ''; ?>><?= $tag; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</fieldset>

				<fieldset>
					<legend><?= lang('search_views_legend_narration_contains') ?></legend>
					<div class="form-group">
						<textarea class="form-control" name="narration" rows="4"><?= set_value('narration'); ?></textarea>
					</div>
				</fieldset>

				<div class="form-group">
					<input type="submit" class="btn btn-primary" id="search_submit" value="<?= lang('search_views_search_btn') ?>">
				</div>
				<?= form_close(); ?>

<?php // if ($showEntries) { ?>
		<table class="stripped">
			<thead>
				<tr>
					<th><?= lang('search_views_th_date'); ?></th>
					<th><?= lang('search_views_th_number'); ?></th>
					<th><?= lang('search_views_th_ledger'); ?></th>
					<th><?= lang('search_views_th_type'); ?></th>
					<th><?= lang('search_views_th_tag'); ?></th>
					<th><?= lang('search_views_th_dr_amount'); ?> (<?= $this->mAccountSettings->currency_symbol; ?>) </th>
					<th><?= lang('search_views_th_cr_amount'); ?> (<?= $this->mAccountSettings->currency_symbol; ?>) </th>
					<th><?= lang('search_views_th_actions'); ?></th>
				</tr>
			</thead>
			
			<?php
			/* Show the entries table */
			// foreach ($entries as $entry) {
			// 	$et = $this->DB1->where('id', $entry['entrytype_id'])->get('entrytypes')->row_array();
			// 	$entryTypeName = $et['name'];
			// 	$entryTypeLabel = $et['label'];

			// 	echo '<tr>';
			// 	echo '<td>' . $this->functionscore->dateFromSql($entry['date']) . '</td>';
			// 	echo '<td>' . ($this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id'])) . '</td>';
			// 	echo '<td>' . ($this->functionscore->entryLedgers($entry['id'])) . '</td>';
			// 	echo '<td>' . ($entryTypeName) . '</td>';
			// 	echo '<td>' . $this->functionscore->showTag($entry['tag_id'])  . '</td>';

			// 	if ($entry['dc'] == 'D') {
			// 		echo '<td>' . $this->functionscore->toCurrency('D', $entry['amount']) . '</td>';
			// 		echo '<td>' . '</td>';
			// 	} else if ($entry['dc'] == 'C') {
			// 		echo '<td>' . '</td>';
			// 		echo '<td>' . $this->functionscore->toCurrency('C', $entry['amount']) . '</td>';
			// 	} else {
			// 		echo '<td>' . (lang('')) . '</td>';
			// 		echo '<td>' . (lang('')) . '</td>';
			// 	}

			// 	echo '<td>';
			?>
			 		<!-- <a href="<?= base_url();?>entries/view/<?= ($entryTypeLabel); ?>/<?= $entry['entry_id']; ?>" class="no-hover" escape="false"><i class="glyphicon glyphicon-log-in"></i> View</a>
					<span class="link-pad"></span>
					<a href="<?= base_url();?>entries/edit/<?= ($entryTypeLabel); ?>/<?= $entry['entry_id']; ?>" class="no-hover" escape="false"><i class="glyphicon glyphicon-edit"></i> Edit</a>
					<span class="link-pad"></span>
					<a href="<?= base_url();?>entries/delete/<?= ($entryTypeLabel); ?>/<?= $entry['entry_id']; ?>" class="no-hover" escape="false"><i class="glyphicon glyphicon-trash"></i> Delete</a> -->
			<?php
			// 	echo '</td>';
			// 	echo '</tr>';
			// } 

			?>
		</table>
	<?php // } ?>
	</div>
</section>
