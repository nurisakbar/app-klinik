<script type="text/javascript">
$(document).ready(function() {
	/* javascript floating point operations */
	var jsFloatOps = function(param1, param2, op) {
		<?php if ($this->mAccountSettings->decimal_places == 2) { ?>
			param1 = param1 * 100;
			param2 = param2 * 100;
		<?php } else if ($this->mAccountSettings->decimal_places == 3) { ?>
			param1 = param1 * 1000;
			param2 = param2 * 1000;
		<?php } ?>
		param1 = param1.toFixed(0);
		param2 = param2.toFixed(0);
		param1 = Math.floor(param1);
		param2 = Math.floor(param2);
		var result = 0;
		if (op == '+') {
			result = param1 + param2;
			<?php if ($this->mAccountSettings->decimal_places == 2) { ?>
				result = result/100;
			<?php } else if ($this->mAccountSettings->decimal_places == 3) { ?>
				result = result/1000;
			<?php } ?>
			return result;
		}
		if (op == '-') {
			result = param1 - param2;
			<?php if ($this->mAccountSettings->decimal_places == 2) { ?>
				result = result/100;
			<?php } else if ($this->mAccountSettings->decimal_places == 3) { ?>
				result = result/1000;
			<?php } ?>
			return result;
		}
		if (op == '!=') {
			if (param1 != param2)
				return true;
			else
				return false;
		}
		if (op == '==') {
			if (param1 == param2)
				return true;
			else
				return false;
		}
		if (op == '>') {
			if (param1 > param2)
				return true;
			else
				return false;
		}
		if (op == '<') {
			if (param1 < param2)
				return true;
			else
				return false;
		}
	}

	/* Calculating Dr and Cr total */
	$(document).on('change', '.dr-item', function() {
		var drTotal = 0;
		$("table tr .dr-item").each(function() {
			var curDr = $(this).prop('value');
			curDr = parseFloat(curDr);
			if (isNaN(curDr))
				curDr = 0;
			drTotal = jsFloatOps(drTotal, curDr, '+');
		});
		$("table tr #dr-total").text(drTotal);
		var crTotal = 0;
		$("table tr .cr-item").each(function() {
			var curCr = $(this).prop('value');
			curCr = parseFloat(curCr);
			if (isNaN(curCr))
				curCr = 0;
			crTotal = jsFloatOps(crTotal, curCr, '+');
		});
		$("table tr #cr-total").text(crTotal);

		if (jsFloatOps(drTotal, crTotal, '==')) {
			$("table tr #dr-total").css("background-color", "#FFFF99");
			$("table tr #cr-total").css("background-color", "#FFFF99");
			$("table tr #dr-diff").text("-");
			$("table tr #cr-diff").text("");
		} else {
			$("table tr #dr-total").css("background-color", "#FFE9E8");
			$("table tr #cr-total").css("background-color", "#FFE9E8");
			if (jsFloatOps(drTotal, crTotal, '>')) {
				$("table tr #dr-diff").text("");
				$("table tr #cr-diff").text(jsFloatOps(drTotal, crTotal, '-'));
			} else {
				$("table tr #dr-diff").text(jsFloatOps(crTotal, drTotal, '-'));
				$("table tr #cr-diff").text("");
			}
		}
	});

	$(document).on('change', '.cr-item', function() {
		var drTotal = 0;
		$("table tr .dr-item").each(function() {
			var curDr = $(this).prop('value')
			curDr = parseFloat(curDr);
			if (isNaN(curDr))
				curDr = 0;
			drTotal = jsFloatOps(drTotal, curDr, '+');
		});
		$("table tr #dr-total").text(drTotal);
		var crTotal = 0;
		$("table tr .cr-item").each(function() {
			var curCr = $(this).prop('value')
			curCr = parseFloat(curCr);
			if (isNaN(curCr))
				curCr = 0;
			crTotal = jsFloatOps(crTotal, curCr, '+');
		});
		$("table tr #cr-total").text(crTotal);

		if (jsFloatOps(drTotal, crTotal, '==')) {
			$("table tr #dr-total").css("background-color", "#FFFF99");
			$("table tr #cr-total").css("background-color", "#FFFF99");
			$("table tr #dr-diff").text("-");
			$("table tr #cr-diff").text("");
		} else {
			$("table tr #dr-total").css("background-color", "#FFE9E8");
			$("table tr #cr-total").css("background-color", "#FFE9E8");
			if (jsFloatOps(drTotal, crTotal, '>')) {
				$("table tr #dr-diff").text("");
				$("table tr #cr-diff").text(jsFloatOps(drTotal, crTotal, '-'));
			} else {
				$("table tr #dr-diff").text(jsFloatOps(crTotal, drTotal, '-'));
				$("table tr #cr-diff").text("");
			}
		}
	});

	/* Dr - Cr dropdown changed */
	$(document).on('change', '.dc-dropdown', function() {
		var drValue = $(this).parent().parent().next().next().children().children().prop('value');
		var crValue = $(this).parent().parent().next().next().next().children().children().prop('value');

		if ($(this).parent().parent().next().children().children().val() == "0") {
			return;
		}

		drValue = parseFloat(drValue);
		if (isNaN(drValue))
			drValue = 0;

		crValue = parseFloat(crValue);
		if (isNaN(crValue))
			crValue = 0;

		if ($(this).prop('value') == "D") {
			if (drValue == 0 && crValue != 0) {
				$(this).parent().parent().next().next().children().children().prop('value', crValue);
			}
			$(this).parent().parent().next().next().next().children().children().prop('value', "");
			$(this).parent().parent().next().next().next().children().children().prop('disabled', 'disabled');
			$(this).parent().parent().next().next().children().children().prop('disabled', '');
		} else {
			if (crValue == 0 && drValue != 0) {
				$(this).parent().parent().next().next().next().children().prop('value', drValue);
			}
			$(this).parent().parent().next().next().children().children().prop('value', "");
			$(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
			$(this).parent().parent().next().next().next().children().children().prop('disabled', '');
		}
		/* Recalculate Total */
		$('.dr-item:first').trigger('change');
		$('.cr-item:first').trigger('change');
	});

	/* Ledger dropdown changed */
	$(document).on('change', '.ledger-dropdown', function() {
		if ($(this).val() == "0") {
			/* Reset and diable dr and cr amount */
			$(this).parent().parent().next().children().children().prop('value', "");
			$(this).parent().parent().next().next().children().children().prop('value', "");
			$(this).parent().parent().next().children().children().prop('disabled', 'disabled');
			$(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
		} else {
			/* Enable dr and cr amount and trigger Dr/Cr change */
			$(this).parent().parent().next().children().children().prop('disabled', '');
			$(this).parent().parent().next().next().children().children().prop('disabled', '');
			$(this).parent().parent().prev().children().children().trigger('change');
		}
		/* Trigger dr and cr change */
		$(this).parent().parent().next().children().children().trigger('change');
		$(this).parent().parent().next().next().children().children().trigger('change');

		var ledgerid = $(this).val();
		var rowid = $(this);
		if (ledgerid > 0) {
			$.ajax({
				url: '<?=base_url("ledgers/cl"); ?>',
				data: 'id=' + ledgerid,
				dataType: 'json',
				success: function(data)
				{
					var ledger_bal = parseFloat(data['cl']['amount']);

					var prefix = '';
					var suffix = '';
					if (data['cl']['status'] == 'neg') {
						prefix = '<span class="error-text">';
						suffix = '</span>';
					}

					if (data['cl']['dc'] == 'D') {
						rowid.parent().parent().next().next().next().next().children().html(prefix + "Dr " + ledger_bal + suffix);
					} else if (data['cl']['dc'] == 'C') {
						rowid.parent().parent().next().next().next().next().children().html(prefix + "Cr " + ledger_bal + suffix);
					} else {
						rowid.parent().parent().next().next().next().next().children().html("");
					}
				}
			});
		} else {
			rowid.parent().parent().next().next().next().next().children().text("");
		}
	});

	/* Recalculate Total */
	$(document).on('click', 'table td .recalculate', function() {
		/* Recalculate Total */
		$('.dr-item:first').trigger('change');
		$('.cr-item:first').trigger('change');
	});

	/* Delete ledger row */
	$(document).on('click', '.deleterow', function() {
		$(this).parent().parent().remove();
		/* Recalculate Total */
		$('.dr-item:first').trigger('change');
		$('.cr-item:first').trigger('change');
	});

	/* Add ledger row */
	$(document).on('click', '.addrow', function() {
		var cur_obj = this;
		$.ajax({
			url: '<?=base_url("entries/addrow/").$entrytype["restriction_bankcash"]; ?>',
			success: function(data) {
				$(cur_obj).parent().parent().before(data);
				/* Trigger ledger item change */
					$(cur_obj).parent().parent().next().children().first().next().children().children().children().trigger('change');
				$("tr.ajax-add .ledger-dropdown").select2({
					width:'100%',
					ajax: { 
					   	url: "<?= base_url("entries/ledgerList/"); ?><?=$entrytypeLabel?>",
					   	dataType: 'json',
					   	type: "post",
					   	delay: 250,
					   	data: function (params) {
						    return {
						      	searchTerm: params.term,
						      	selectedLedgers: <?= json_encode($selectedLedgers); ?>
					    	};
					   	},
					   	processResults: function (response) {
					   		console.log(response);
					     	return {
					        	results: response
					     	};
					   	},
					   	cache: true
					},
					placeholder: '<?= lang('please_select_ledger'); ?>'
				});
			}
		});
	});

	/* On page load initiate all triggers */
	$('.dc-dropdown').trigger('change');
	$('.ledger-dropdown').trigger('change');
	$('.dr-item:first').trigger('change');
	$('.cr-item:first').trigger('change');

	/* Calculate date range in javascript */
	startDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
	endDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));

	/* Setup jQuery datepicker ui */
	$('#EntryDate').datepicker({
		minDate: startDate,
		maxDate: endDate,
		dateFormat: '<?= $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
	});

	$(".ledger-dropdown").select2({
		width:'100%',
		ajax: { 
		   	url: "<?= base_url("entries/ledgerList/"); ?><?=$entrytypeLabel?>",
		   	dataType: 'json',
		   	type: "post",
		   	delay: 250,
		   	data: function (params) {
			    return {
			      	searchTerm: params.term,
					selectedLedgers: <?= json_encode($selectedLedgers); ?>
		    	};
		   	},
		   	processResults: function (response) {
		   		console.log(response);
		     	return {
		        	results: response
		     	};
		   	},
		   	cache: true
		},
		placeholder: '<?= lang('please_select_ledger'); ?>'
	});
});

</script>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        <!-- ./col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="entry edit form">
				<?php
					if ($this->mSettings->drcr_toby == 'toby') {
						$dc_options = array(
							'D' => lang('entries_views_addrow_label_dc_toby_D'),
							'C' => lang('entries_views_addrow_label_dc_toby_C'),
						);
					} else {
						$dc_options = array(
							'D' => lang('entries_views_addrow_label_dc_drcr_D'),
							'C' => lang('entries_views_addrow_label_dc_drcr_C'),
						);
					}

					echo form_open();

					$prefixNumber = '';
					$suffixNumber = '';

					if ( ($entrytype['prefix'] != '') && ($entrytype['suffix'] != '')) {
						$prefixNumber = "<div class='input-group'><span class='input-group-addon'>" . $entrytype['prefix'] . '</span>';
						$suffixNumber = "<span class='input-group-addon'>" . $entrytype['suffix'] . '</span></div>';
					} else if ($entrytype['prefix'] != '') {
						$prefixNumber = "<div class='input-group'><span class='input-group-addon'>" . $entrytype['prefix'] . '</span>';
						$suffixNumber = '</div>';
					} else if ($entrytype['suffix'] != '') {
						$prefixNumber = "<div class='input-group'>";
						$suffixNumber = "<span class='input-group-addon'>" . $entrytype['suffix'] . '</span></div>';
					}
					
					echo "<div class='row'>";
						echo "<div class='col-md-4'>";
							echo '<div class="form-group">';
							echo form_label(lang('entries_views_edit_label_number'), 'number');
							$data = array(
								'id' => "number",
								'type' => "text",
								'name' => "number",
								'beforeInput' =>  $prefixNumber,
								'afterInput' => $suffixNumber,
								'class' => "form-control",
								'value' => set_value('number', $entry['number']),
							);
							echo form_input($data);
							echo "</div>";
						echo "</div>";
						echo "<div class='col-md-4'>";
							echo '<div class="form-group">';
							echo form_label(lang('entries_views_edit_label_date'), 'date');
							$data = array(
								'id' => "EntryDate",
								'type' => "text",
								'name' => "date",
								'class' => "form-control",
								'value' => set_value('date', $entry['date']),
							);
							echo form_input($data);
							echo "</div>";
						echo "</div>";
						echo "<div class='col-md-4'>";
							echo '<div class="form-group">';
							echo form_label(lang('entries_views_edit_label_tag'), 'tag_id');
							?>
								<select name="tag_id" class="form-control">
									<option value="0"><?= lang('entries_views_edit_tag_first_option'); ?></option>
									<?php foreach ($tag_options as $tag): ?>
										<option value="<?= $tag['id']; ?>" <?= (($tag['id'] == $entry['tag_id']) or set_value('tag_id')) ? 'selected' : ''?>><?= $tag['title']; ?></option>
									<?php endforeach; ?>
								</select>
							<?php
							echo "</div>";
						echo "</div>";
					echo "</div>";
					
					
					echo '<table class="stripped extra">';

					/* Header */
					echo '<tr>';
					if ($this->mSettings->drcr_toby == 'toby') {
						echo '<th>' . (lang('entries_views_edit_items_th_toby')) . '</th>';
					} else {
						echo '<th>' . (lang('entries_views_edit_items_th_drcr')) . '</th>';
					}
					echo '<th>' . (lang('entries_views_edit_items_th_ledger')) . '</th>';
					echo '<th>' . (lang('entries_views_edit_items_th_dr_amount')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</th>';
					echo '<th>' . (lang('entries_views_edit_items_th_cr_amount')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</th>';
					echo '<th>' . (lang('entries_views_edit_items_th_narration')) . '</th>';
					echo '<th>' . (lang('entries_views_edit_items_th_cur_balance')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</th>';
					echo '<th>' . (lang('entries_views_edit_items_th_actions')) . '</th>';
					echo '</tr>';

					/* Intial rows */
					foreach ($curEntryitems as $row => $entryitem) {
						echo '<tr>';

						if (empty($entryitem['dc'])) {
							echo '<td><div class="form-group-entryitem">' . form_dropdown('Entryitem[' . $row . '][dc]', $dc_options, "", array('class' => 'dc-dropdown form-control')) . '</div></td>';
						} else {
							$options = array('D' => lang('entries_views_addrow_label_dc_drcr_D'), 'C' => lang('entries_views_addrow_label_dc_drcr_C'));
							echo '<td><div class="form-group-entryitem">' . form_dropdown('Entryitem[' . $row . '][dc]', $dc_options, $entryitem['dc'], array('class' => 'dc-dropdown form-control')) . '</div></td>';
						}

						if (empty($entryitem['ledger_id'])) {
							?>
							<td>
								<div class="form-group-entryitem">
									<select class="ledger-dropdown form-control" name="<?= 'Entryitem[' . $row . '][ledger_id]'; ?>">
										<?php foreach ($ledger_options as $id => $ledger): ?>
											<option value="<?= $id; ?>" <?= ($id < 0) ? 'disabled' : "" ?> ><?= $ledger; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
							<?php
						} else {
							?>
							<td>
								<div class="form-group-entryitem">
									<select class="ledger-dropdown form-control" name="<?= 'Entryitem[' . $row . '][ledger_id]'; ?>">
										<?php foreach ($ledger_options as $id => $ledger): ?>
											<option value="<?= $id; ?>" <?= ($entryitem['ledger_id'] == $id) ? 'selected' : "" ?> <?= ($id < 0) ? 'disabled' : "" ?> ><?= $ledger; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
							<?php
						}

						if (empty($entryitem['dr_amount'])) {
							$data = array(
								'type' 	=> "text",
								'name' 	=> 'Entryitem[' . $row . '][dr_amount]',
								'class' =>  'dr-item form-control',
							);
							echo "<td><div class='form-group-entryitem'>";
							echo form_input($data);
							echo "</div></td>";
						} else {
							$data = array(
								'value' => $entryitem['dr_amount'],
								'type' 	=> "text",
								'name' 	=> 'Entryitem[' . $row . '][dr_amount]',
								'class' => 'dr-item form-control',
							);
							echo "<td><div class='form-group-entryitem'>";
							echo form_input($data);
							echo "</div></td>";
						}

						if (empty($entryitem['cr_amount'])) {
							$data = array(
								'type'	=> "text",
								'name' 	=> 'Entryitem[' . $row . '][cr_amount]',
								'class' => 'cr-item form-control',
							);
							echo "<td><div class='form-group-entryitem'>";
							echo form_input($data);
							echo "</div></td>";

						} else {
							$data = array(
								'value' => $entryitem['cr_amount'],
								'type' => "text",
								'name' => 'Entryitem[' . $row . '][cr_amount]',
								'class' =>  'cr-item form-control',
							);
							echo "<td><div class='form-group-entryitem'>";
							echo form_input($data);
							echo "</div></td>";
						}

						$data = array(
							'type'  => "text",
							'value' => $entryitem['narration'],
							'name'  => 'Entryitem[' . $row . '][narration]',
							'class' => 'form-control',
						);
						echo "<td><div class='form-group-entryitem'>";
						echo form_input($data);
						echo "</div></td>";						
						echo '<td class="ledger-balance"><div></div></td>';
						echo '<td>';
						echo '<span class="deleterow glyphicon glyphicon-trash" escape="false"></span>';
						echo '</td>';
						echo '</tr>';
					}

					/* Total and difference */
					echo '<tr class="bold-text">' . '<td>' . (lang('entries_views_edit_items_td_total')) . '</td>' . '<td>' . '</td>' . '<td id="dr-total">' . '</td>' . '<td id="cr-total">' . '</td>' . '<td >' . '<span class="recalculate" escape="false"><i class="glyphicon glyphicon-refresh"></i></span>' . '</td>' . '<td>' . '</td>' . '<td>' . '<span class="addrow" escape="false" style="padding-left: 5px;"><i class="glyphicon glyphicon-plus"></i></span>' . '</td>' . '</tr>';
					echo '<tr class="bold-text">' . '<td>' . (lang('entries_views_edit_items_td_diff')) . '</td>' . '<td>' . '</td>' . '<td id="dr-diff">' . '</td>' . '<td id="cr-diff">' . '</td>' . '<td>' . '</td>' . '<td>' . '</td>' . '<td>' . '</td>' . '</tr>';

					echo '</table>';

					echo '<br />';
					echo '<div class="form-group">';
					echo form_label(lang('entries_views_edit_label_note'), 'notes');
					echo form_textarea('notes', set_value('notes', $entry['notes']), array("rows"=>3, "class"=>"form-control"));
					echo "</div>";
					
					echo '<div class="form-group">';
					echo form_submit('submit', lang('submit'), array('class'=>'btn btn-success'));
					echo '<span class="link-pad"></span>';
					echo anchor('entries/index', lang('cancel'), array('class' => 'btn btn-default'));
					echo '<a></span>';
					echo '</div>';
					echo form_close();
				?>
				</div>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->