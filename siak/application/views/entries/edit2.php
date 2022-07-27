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

	$("#ledger-dropdown").focus(function () {    
	   $('.ledger-dropdown').select2('open');
	});

	/* Calculating Dr and Cr total */
	function dc_diff() {
		var drTotal = 0;
		$(".dr-item").each(function() {
			var curDr = $(this).prop('value');
			curDr = parseFloat(curDr);
			if (isNaN(curDr))
				curDr = 0;
			drTotal = jsFloatOps(drTotal, curDr, '+');
		});
		$("#dr-total").text(drTotal);
		var crTotal = 0;
		$(".cr-item").each(function() {
			var curCr = $(this).prop('value');
			curCr = parseFloat(curCr);
			if (isNaN(curCr))
				curCr = 0;
			crTotal = jsFloatOps(crTotal, curCr, '+');
		});
		$("#cr-total").text(crTotal);

		if (jsFloatOps(drTotal, crTotal, '==')) {
			$("#dr-total").css("background-color", "#FFFF99");
			$("#cr-total").css("background-color", "#FFFF99");
			$("#dr-diff").text("-");
			$("#cr-diff").text("");
		} else {
			$("#dr-total").css("background-color", "#FFE9E8");
			$("#cr-total").css("background-color", "#FFE9E8");
			if (jsFloatOps(drTotal, crTotal, '>')) {
				$("#dr-diff").text("");
				$("#cr-diff").text(jsFloatOps(drTotal, crTotal, '-'));
			} else {
				$("#dr-diff").text(jsFloatOps(crTotal, drTotal, '-'));
				$("#cr-diff").text("");
			}
		}

		if ($('#cr-diff').text()) {
			$(".dc-dropdown").val('C');
		}else{
			$(".dc-dropdown").val('D');
		}
	}

	$('.ledger-dropdown').on('select2:close', function (e) {
	    var selected = $('.ledger-dropdown').val();
	    if (selected == 0) {
	    	if ($('.amount').prop('disabled')) {
	    		setTimeout(function() {
					// $('.ledger-dropdown').select2('open');
					$('#ledger-dropdown').popover('show');
					$('.dc-dropdown').focus();
				}, 500);
	    	}
	    }
	});

	/* Ledger dropdown changed */
	$(document).on('change', '.ledger-dropdown', function(e) {
		if ($(this).val() == "0") {
			/* Reset and diable dr and cr amount */
			$('.amount').prop('value', "");
			$('.amount').prop('disabled', 'disabled');
		} else {
			/* Enable dr and cr amount and trigger Dr/Cr change */
			$('.amount').prop('disabled', '');
			setTimeout(function() {
				$(".amount").focus();
			}, 500);
		}
	});

	/* Recalculate Total */
	$(document).on('click', '.recalculate', function() {
		/* Recalculate Total */
		dc_diff();
	});

	/* Delete ledger row */
	$(document).on('click', '.deleterow', function() {
		$(this).parent().parent().remove();
		var tbody = $("#entryitems");
		if (tbody.children().length == 0) {
		    tbody.html("<tr class='empty'><td colspan='7' style='text-align:center'>No data available in table</td></tr>");
		}
		/* Recalculate Total */
		dc_diff();
	});

	/* Add ledger row */
	$(document).on('click', '#addentry', function() {
		// entryitem data object
		var entryitem_data = new Object();

		entryitem_data["dc_option_val"] 	= $('.dc-dropdown').val();
		entryitem_data["cur_ledger_id"] 	= $('.ledger-dropdown').val();
		entryitem_data["amount"] 			= $('.amount').val();
		entryitem_data["narration"] 		= $('.narration').val();
		entryitem_data["ledger_option"] 	= $.trim($('.ledger-dropdown').find(":selected").text());
		entryitem_data["dc_option"] 		= $('.dc-dropdown').find(":selected").text();

		$.ajax({
			url: '<?=base_url("ledgers/cl"); ?>',
			data: 'id=' + entryitem_data["cur_ledger_id"],
			dataType: 'json',
			success: function(data)
			{
				if (data) {
					var ledger_bal = parseFloat(data['cl']['amount']);
					var prefix = '';
					var suffix = '';
					if (data['cl']['status'] == 'neg') {
						prefix = '<span class="error-text">';
						suffix = '</span>';
					}
					if (data['cl']['dc'] == 'D') {
						entryitem_data["ledger_balance"] = prefix + "Dr " + ledger_bal + suffix;
					} else if (data['cl']['dc'] == 'C') {
						entryitem_data["ledger_balance"] = prefix + "Cr " + ledger_bal + suffix;
					} else {
						entryitem_data["ledger_balance"] = '-';
					}

				}else {
					entryitem_data["ledger_balance"] = '-';
				}
				
				$.ajax({
					type: "POST",
		    		data: entryitem_data,
					url: '<?=base_url("entries/addentry/"); ?>',
					success: function(data) {
						if (data) {
							var tbody = $("#entryitems");
							if (tbody.children().hasClass('empty')) {
							    tbody.empty();
							}
							if (tbody.children().hasClass('danger')) {
								if (tbody.children().length > 0) {
									$('.danger').remove();
								}else{
									tbody.empty();
								}
							}
							tbody.append(data)
							dc_diff();
							if (!tbody.children().hasClass('danger')) {
								if ($('#cr-diff').text()) {
									$(".dc-dropdown").val('C');
								}else{
									$(".dc-dropdown").val('D');
								}
								$('.ledger-dropdown').val(0).trigger('change.select2');
								$('.amount').prop('value', "");
								$('.amount').prop('disabled', 'disabled');
								$(".narration").val('');
							}
							$(".dc-dropdown").focus();
						}
					}
				});
			}
		});		
	});

	$('.narration').keypress(function (e) {
		var key = e.which;
		if(key == 13){
			$('#addentry').click();
			return false;  
		}
	});

	$('.amount').keypress(function (e) {
		var key = e.which;
		if(key == 13){
			$('.narration').focus();
			return false;  
		}
	});

	$('.dc-dropdown').keypress(function (e) {
		var key = e.which;
		if(key == 13){
			$('#ledger-dropdown').focus();
			return false;  
		}
	});

	/* On page load initiate all triggers */
	dc_diff();
	$("input:text:visible:first").focus();

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
			      	searchTerm: params.term
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
        
        <!-- /.col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="entry add form">
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
					
					echo '<div class="row">';
					echo '<div class="col-xs-4">';
					echo '<div class="form-group">';
					echo form_label(lang('number'), 'number');
					$data = array(
						'id' => "number",
						'type' => "text",
						'name' => "number",
						'beforeInput' =>  $prefixNumber,
						'afterInput' => $suffixNumber,
						'class' => "form-control",
						'value' => set_value('number', $entry['number']),
						'tabindex' => '1'
					);
					echo form_input($data);
					echo "</div>";
					echo "</div>";
					echo '<div class="col-xs-4">';
					echo '<div class="form-group">';
					echo form_label(lang('date'), 'date');
					$data = array(
						'id' => "EntryDate",
						'type' => "text",
						'name' => "date",
						'class' => "form-control",
						'value' => set_value('date', $entry['date']),
						'tabindex' => '2'
					);
					echo form_input($data);
					echo "</div>";
					echo "</div>";
					echo '<div class="col-xs-4">';
					echo '<div class="form-group">';
					echo form_label(lang('tag'), 'tag_id');
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
					echo "</br>";
					?>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?= lang('add_entries_below_label'); ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-1">
									<?php 
									if ($entrytype['restriction_bankcash'] == 3){
										$dc = 'C';
									}else /* else 1st item is Debit */
									{
										$dc = 'D';
									}
									$data = array(
										'class' => "dc-dropdown form-control",
										'tabindex' => '4'
									);
									echo '<div class="form-group-entryitem">' . form_dropdown('', $dc_options, $dc, $data) . '</div>';
									?>
								</div>
								<div class="col-xs-4">
									<div class="form-group-entryitem"  id="ledger-dropdown" tabindex="5" data-toggle="popover" data-trigger="focus" title="<?= lang('required'); ?>" data-content="<?= lang('please_select_ledger'); ?>" data-container="body">
										<select class="ledger-dropdown form-control" >
											<?php // foreach ($ledger_options as $id => $ledger): ?>
												<!-- <option value="<?= $id; ?>" <?= ($id < 0) ? 'disabled' : "" ?> ><?= $ledger; ?></option> -->
											<?php // endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-xs-2">
									<?php
									$data = array(
										'type' => "text",
										'class' =>  'amount form-control',
										'placeholder' => lang('entries_views_add_items_amount_placeholder').'('.$this->mAccountSettings->currency_symbol.')',
										'disabled' => 'disabled',
										'tabindex' => '6'
									);
									echo "<div class='form-group-entryitem'>";
									echo form_input($data);
									echo "</div>";
									?>
								</div>
								<div class="col-xs-5">
									<div class="input-group">
										<?php
										$data = array(
											'type'  => "text",
											'class' => 'narration form-control',
											'placeholder' => lang('entries_views_add_items_narration_placeholder'),
											'tabindex' => '7'
										);
										echo "<div class='form-group-entryitem'>";
										echo form_input($data);
										echo "</div>";
										?>
										<div class=input-group-btn>
											<button type='button' id="addentry" tabindex="8" class="btn btn-primary" data-toggle="tooltip" title="<?php echo lang('entries_views_add_items_addentry_btn_tooltip');?>">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
										</div>
								    </div>
								</div>
							</div>

							<?php
							echo "</br>";
							echo '<div class="table-responsive">';
							echo '<table class="table table-stripped table-hover table-bordered">';
							/* Header */
							echo "<thead>";
							echo '<tr>';
							if ($this->mSettings->drcr_toby == 'toby') {
								echo '<th><small>' . (lang('entries_views_add_items_th_toby')) . '</small></th>';
							} else {
								echo '<th><small>' . (lang('entries_views_add_items_th_drcr')) . '</small></th>';
							}
							echo '<th><small>' . (lang('ledger')) . '</small></th>';
							echo '<th><small>' . (lang('dr_amount')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . (lang('cr_amount')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . (lang('entries_views_add_items_th_narration')) . '</small></th>';
							echo '<th><small>' . (lang('entries_views_add_items_th_cur_balance')) . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . (lang('entries_views_add_items_th_actions')) . '</small></th>';
							echo '</tr>';
							echo "</thead>";
							echo '<tbody id="entryitems">';
							if (isset($curEntryitems) && !empty($curEntryitems) && sizeof($curEntryitems, 1) > 5 ) {
								foreach ($curEntryitems as $row => $entryitem) {
									echo '<tr class="'.$row.'">';
									echo '<td class="'.$entryitem['dc'].'">' . $dc_options[$entryitem['dc']] . '</td>';
									$data = array(
										'type' => 'hidden',
										'name' => 'Entryitem[' . $row . '][dc]',
										'value' => $entryitem['dc']
									);
									echo form_input($data);
									echo '<td class="'.$entryitem['ledger_id'].'" id="cur_ledger">' . $entryitem['ledgername'] . '</td>';
									$data = array(
										'type' => 'hidden',
										'name' => 'Entryitem[' . $row . '][ledger_id]',
										'value' => $entryitem['ledger_id']
									);
									echo form_input($data);

									if (empty($entryitem['cr_amount'])) {
										echo '<td>'. number_format($entryitem['dr_amount'],0,",",".").'</td>';
										$data = array(
											'type' => 'hidden',
											'name' => 'Entryitem[' . $row . '][dr_amount]',
											'value' => $entryitem['dr_amount'],
											'class' => 'dr-item'
										);
										echo form_input($data);
										echo '<td><strong>-</strong></td>';
									}else{
										echo '<td><strong>-</strong></td>';
										echo '<td>' . number_format($entryitem['cr_amount'],0,",",".") . '</td>';
										$data = array(
											'type' => 'hidden',
											'name' => 'Entryitem[' . $row . '][cr_amount]',
											'value' => $entryitem['cr_amount'],
											'class' => 'cr-item'
										);
										echo form_input($data);
									}
									echo '<td>' . $entryitem['narration'] . '</td>';
									$data = array(
										'type' => 'hidden',
										'name' => 'Entryitem[' . $row . '][narration]',
										'value' => $entryitem['narration']
									);

									echo form_input($data);
									echo '<td class="ledger-balance"><div>' . ((isset($prefix) && $entryitem['dc'] == 'C') ? $prefix : '') . $entryitem['ledger_balance'] . ((isset($suffix) && $entryitem['dc'] == 'C') ? $suffix : '') . '</div></td>';
									$data = array(
										'type' => 'hidden',
										'name' => 'Entryitem[' . $row . '][ledger_balance]',
										'value' => ((isset($prefix) && $entryitem['dc'] == 'C') ? $prefix : '') . $entryitem['ledger_balance'] . ((isset($suffix) && $entryitem['dc'] == 'C') ? $suffix : '')
									);
									echo form_input($data);
									echo '<td>';
									echo '<span class="deleterow" escape="false"><i class="glyphicon glyphicon-trash"></i></span>';
									echo '</td>';
									echo '</tr>';
								}
							}else{
								echo "<tr class='empty'>";
								echo "<td colspan='7' style='text-align:center'>No data available in table</td>";
								echo '</tr>';
							}
							echo '</tbody>';

							/* Total and difference */
							echo '<tr class="bold-text">' . '<td>' . lang('entries_views_add_items_td_total') . '</td>' . '<td>' . '</td>' . '<td id="dr-total">' . '</td>' . '<td id="cr-total">' . '</td>' . '<td>' . '' . '</td>' . '<td>' . '</td>' . '<td>' . '<span class="recalculate" escape="false"><i class="glyphicon glyphicon-refresh"></i></span>' . '</td>' . '</tr>';
							echo '<tr class="bold-text">' . '<td>' . lang('entries_views_add_items_td_diff') . '</td>' . '<td>' . '</td>' . '<td id="dr-diff">' . '</td>' . '<td id="cr-diff">' . '</td>' . '<td>' . '</td>' . '<td>' . '</td>' . '<td>' . '</td>' . '</tr>';

							echo '</table>';
							echo '</div>';
							?>
						</div>
					</div>
					<?php
					echo '<br />';
					echo '<div class="form-group">';
					echo form_label(lang('entries_views_add_label_note'), 'note');
					echo "<textarea name='notes' class='form-control' tabindex='9' rows='3'>$entry[notes]</textarea>";
					echo "</div>";
					echo '<div class="form-group">';
					echo form_submit('submit', lang('submit'), array('class'=>'btn btn-success pull-rignt'));
					echo '<span class="link-pad"></span>';
					echo anchor('entries/index', lang('entries_views_add_label_cancel_btn'), array('class' => 'btn btn-default'));
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