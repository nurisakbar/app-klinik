<?php
function account_st_short($account, $c = 0, $THIS, $dc_type) {
  	$CI =& get_instance();
	$counter = $c;
	if ($account->id > 4)
	{
		if ($dc_type == 'D' && $account->cl_total_dc == 'C' && $CI->functionscore->calculate($account->cl_total, 0, '!=')) {
			echo '<tr class="tr-group dc-error">';
		} else if ($dc_type == 'C' && $account->cl_total_dc == 'D' && $CI->functionscore->calculate($account->cl_total, 0, '!=')) {
			echo '<tr class="tr-group dc-error">';
		} else {
			echo '<tr class="tr-group">';
		}

		echo '<td class="td-group">';
		echo print_space($counter);
		echo ($CI->functionscore->toCodeWithName($account->code, $account->name));
		echo '</td>';

		echo '<td class="text-right">';
		echo $CI->functionscore->toCurrency($account->cl_total_dc, $account->cl_total);
		echo print_space($counter);
		echo '</td>';

		echo '</tr>';
	}
	foreach ($account->children_groups as $id => $data)
	{
		$counter++;
		account_st_short($data, $counter, $THIS, $dc_type);
		$counter--;
	}
	if (count($account->children_ledgers) > 0)
	{
		$counter++;
		foreach ($account->children_ledgers as $id => $data)
		{
			if ($dc_type == 'D' && $data['cl_total_dc'] == 'C' && $CI->functionscore->calculate($data['cl_total'], 0, '!=')) {
				echo '<tr class="tr-ledger dc-error">';
			} else if ($dc_type == 'C' && $data['cl_total_dc'] == 'D' && $CI->functionscore->calculate($data['cl_total'], 0, '!=')) {
				echo '<tr class="tr-ledger dc-error">';
			} else {
				echo '<tr class="tr-ledger">';
			}

			echo '<td class="td-ledger">';
			echo print_space($counter);

			echo anchor('reports/ledgerstatement/ledgerid/'.$data['id'], $CI->functionscore->toCodeWithName($data['code'], $data['name']));
			echo '</td>';

			echo '<td class="text-right">';
			echo $CI->functionscore->toCurrency($data['cl_total_dc'], $data['cl_total']);
			echo print_space($counter);
			echo '</td>';

			echo '</tr>';
		}
	$counter--;
	}
}

function print_space($count)
{
	$html = '';
	for ($i = 1; $i <= $count; $i++) {
		$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	return $html;
}

?>

<script type="text/javascript">
	$(document).ready(function() {

		<?php if (isset($only_opening) && $only_opening == true) { ?>
			$("#BalancesheetOpening").iCheck('check').trigger('ifChanged');
			$('#BalancesheetStartdate').prop('disabled', true);
			$('#BalancesheetEnddate').prop('disabled', true);
		<?php } ?>

		$("#accordion").accordion({
			collapsible: true,
			<?php
				if ($options == false) {
					echo 'active: false';
				}
			?>
		});

		$('.show-tooltip').tooltip({trigger: 'manual'}).tooltip('show');

		/* Calculate date range in javascript */
		startDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
		endDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));

		$('#BalancesheetOpening').on('ifChanged', function(event) {
		    if (event.target.checked) {
				$('#BalancesheetStartdate').prop('disabled', true);
				$('#BalancesheetEnddate').prop('disabled', true);
			} else {
				$('#BalancesheetStartdate').prop('disabled', false);
				$('#BalancesheetEnddate').prop('disabled', false);
			}
		});

		// /* On selecting custom period show the start and end date form fields */
		// $('#BalancesheetOpening').change(function() {
		// 	if ($(this).prop('checked')) {
		// 		$('#BalancesheetStartdate').prop('disabled', true);
		// 		$('#BalancesheetEnddate').prop('disabled', true);
		// 	} else {
		// 		$('#BalancesheetStartdate').prop('disabled', false);
		// 		$('#BalancesheetEnddate').prop('disabled', false);
		// 	}
		// });
		// $('#BalancesheetOpening').trigger('change');

		// $('#reset').click(function() {
		//     location = location.href;
		// });
		
		/* Setup jQuery datepicker ui */
		$('#BalancesheetStartdate').datepicker({
			minDate: startDate,
			maxDate: endDate,
			dateFormat: '<?php echo $this->mDateArray[1]; ?>',
			numberOfMonths: 1,
			onClose: function(selectedDate) {
				if (selectedDate) {
					$("#BalancesheetEnddate").datepicker("option", "minDate", selectedDate);
				} else {
					$("#BalancesheetEnddate").datepicker("option", "minDate", startDate);
				}
			}
		});

		$('#BalancesheetEnddate').datepicker({
			minDate: startDate,
			maxDate: endDate,
			dateFormat: '<?php echo $this->mDateArray[1]; ?>',
			numberOfMonths: 1,
			onClose: function(selectedDate) {
				if (selectedDate) {
					$("#BalancesheetStartdate").datepicker("option", "maxDate", selectedDate);
				} else {
					$("#BalancesheetStartdate").datepicker("option", "maxDate", endDate);
				}
			}
		});
	});
</script>

	<?php
	/* Show difference in opening balance */
	if ($bsheet['is_opdiff']) {
		echo '<div><div role="alert" class="alert alert-danger">' .
			sprintf(lang('accounts_index_label_difference_bw_balance'), $this->functionscore->toCurrency($bsheet['opdiff']['opdiff_balance_dc'], $bsheet['opdiff']['opdiff_balance'])) . '</div></div>';
	}

	/* Show difference in liabilities and assets total */
	if ($this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '!=')) {
		$final_total_diff = $this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '-');
		echo '<div><div role="alert" class="alert alert-danger">' .
			sprintf(lang('balance_sheet_tla_diff'), $this->functionscore->toCurrency('X', $final_total_diff))
			.
			'</div></div>';
	}
	?>
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
				<div id="accordion">
					<h3>Options</h3>

					<div class="balancesheet form">
					<?php echo form_open(); ?>
						<div class="row">
							<div class="col-md-4">
								<div style="margin-top: 30px;">
									<input type="checkbox" id="BalancesheetOpening" name="opening" class="checkbox">
									<label for="BalancesheetOpening"><?= lang('show_op_bs_title'); ?></label>
		                        </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label><?= lang('start_date'); ?></label>

				                    <div class="input-group">

										<input id="BalancesheetStartdate" type="text" name="startdate" class="form-control" value="<?=(isset($startdate) ? $startdate : '');?>">

										<!-- <input id="BalancesheetStartdate" type="text" name="startdate" class="form-control"> -->

				                        <div class="input-group-addon">
				                            <i>
				                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('start_date_span');?>">
				                                </div>
				                            </i>
				                        </div>
				                    </div>
				                    <!-- /.input group -->
				                </div>
				                <!-- /.form group -->
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label><?= lang('end_date'); ?></label>

				                    <div class="input-group">

										<input id="BalancesheetEnddate" type="text" name="enddate" class="form-control" value="<?=(isset($enddate) ? $enddate : '');?>">
										
										<!-- <input id="BalancesheetEnddate" type="text" name="enddate" class="form-control"> -->

				                        <div class="input-group-addon">
				                            <i>
				                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('end_date_span');?>">
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
							<input type="submit" name="submit" class="btn btn-success" value="<?= lang('submit'); ?>">
							<input type="reset" name="reset" id="reset" class="btn btn-danger" value="<?= lang('clear'); ?>">
						</div>
						<?php form_close();  ?>
					</div>
				</div>
				<br />

				<div class="btn-group pull-right" role="group">
					<a href="<?= base_url('reports/balancesheet/download/pdf/'.$startdate.'/'.$enddate);?>" class="btn btn-info"><?= lang('export_to_pdf'); ?></a>
					<a href="<?= base_url('reports/balancesheet/download/csv/'.$startdate.'/'.$enddate);?>" class="btn btn-primary"><?= lang('export_to_csv'); ?></a>
					<!-- <a href="<?= base_url('reports/balancesheet/download/xls');?>" class="btn btn-default btn-sm"><?= lang('export_to_xls'); ?></a> -->
					<a class="btn btn-default" onclick="window.print()"><?= lang('print'); ?></a>
				</div>
				<br />
				<br />
				<div id="section-to-print">
					<p class="subtitle text-center">
						<?php echo $subtitle ?>
					</p>

					<table>
					<!-- Liabilities and Assets -->
					<tr>
						<!-- Assets -->
						<td class="table-top width-50">
							<table class="stripped">
								<tr>
									<th><?php echo lang('balance_sheet_assets'); ?></th>
									<th class="text-right"><?php echo lang('search_views_legend_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($bsheet['assets'], $c = -1, $this, 'D'); ?>
							</table>
						</td>

						<!-- Liabilities -->
						<td class="table-top width-50">
							<table class="stripped">
								<tr>
									<th><?php echo lang('balance_sheet_loe'); ?></th>
									<th class="text-right"><?php echo lang('search_views_legend_amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($bsheet['liabilities'], $c = -1, $this, 'C'); ?>
							</table>
						</td>
					</tr>

					<tr>
						<!-- Assets Calculations -->
						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<?php
								/* Assets Total */
								if ($this->functionscore->calculate($bsheet['assets_total'], 0, '>=')) {
									echo '<tr class="bold-text">';
									echo '<td>' . lang('balance_sheet_total_assets') . '</td>';
									echo '<td class="text-right">' . $this->functionscore->toCurrency('D', $bsheet['assets_total']) . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="dc-error bold-text">';
									echo '<td>' . lang('balance_sheet_total_assets') . '</td>';
									echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting positive Dr Balance">' . $this->functionscore->toCurrency('D', $bsheet['assets_total']) . '</td>';
									echo '</tr>';
								}
								?>
								<tr class="bold-text">
									<?php
									/* Net loss */
									if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
										} else {
											echo '<td>' . lang('balance_sheet_net_loss') . '</td>';
											$positive_pandl = $this->functionscore->calculate($bsheet['pandl'], 0, 'n');
											echo '<td class="text-right">' . $this->functionscore->toCurrency('D', $positive_pandl) . '</td>';
										}
										?>
									</tr>
									<?php
									/* Difference in opening balance */
									if ($bsheet['is_opdiff']) {
										echo '<tr class="bold-text error-text">';
										/* If diff in opening balance is Dr */
										if ($bsheet['opdiff']['opdiff_balance_dc'] == 'D') {
											echo '<td>' . lang('balance_sheet_diff_opp') . '</td>';
											echo '<td class="text-right">' . $this->functionscore->toCurrency('D', $bsheet['opdiff']['opdiff_balance']) . '</td>';
										} else {
											echo '<td>&nbsp</td>';
											echo '<td>&nbsp</td>';
										}
										echo '</tr>';
									}
									?>

									<?php
									/* Total */
									if ($this->functionscore->calculate($bsheet['final_liabilities_total'],
										$bsheet['final_assets_total'], '==')) {
										echo '<tr class="bold-text bg-filled">';
									} else {
										echo '<tr class="bold-text error-text bg-filled">';
									}
									echo '<td>' . lang('balance_sheet_total') . '</td>';
									echo '<td class="text-right">' .
										$this->functionscore->toCurrency('D', $bsheet['final_assets_total']) .
										'</td>';
									echo '</tr>';
									?>
								</table>
							</td>

							<!-- Liabilities Calculations -->
							<td class="table-top width-50">
								<div class="report-tb-pad"></div>
								<table class="stripped">
									<?php
									/* Liabilities Total */
									if ($this->functionscore->calculate($bsheet['liabilities_total'], 0, '>=')) {
										echo '<tr class="bold-text">';
										echo '<td>' . lang('balance_sheet_tloe') . '</td>';
										echo '<td class="text-right">' . $this->functionscore->toCurrency('C', $bsheet['liabilities_total']) . '</td>';
										echo '</tr>';
									} else {
										echo '<tr class="dc-error bold-text">';
										echo '<td>' . lang('balance_sheet_tloe') . '</td>';
										echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting positive Cr balance">' . $this->functionscore->toCurrency('C', $bsheet['liabilities_total']) . '</td>';
										echo '</tr>';
									}
									?>
									<tr class="bold-text">
										<?php
										/* Net profit */
										if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
											echo '<td>' . lang('balance_sheet_net_profit') . '</td>';
											echo '<td class="text-right">' . $this->functionscore->toCurrency('C', $bsheet['pandl']) . '</td>';
										} else {
											echo '<td>&nbsp</td>';
											echo '<td>&nbsp</td>';
										}
										?>
									</tr>
									<?php
									/* Difference in opening balance */
									if ($bsheet['is_opdiff']) {
										echo '<tr class="bold-text error-text">';
										/* If diff in opening balance is Cr */
										if ($bsheet['opdiff']['opdiff_balance_dc'] == 'C') {
											echo '<td>' . lang('balance_sheet_diff_opp') . '</td>';
											echo '<td class="text-right">' . $this->functionscore->toCurrency('C', $bsheet['opdiff']['opdiff_balance']) . '</td>';
										} else {
											echo '<td>&nbsp</td>';
											echo '<td>&nbsp</td>';
										}
										echo '</tr>';
									}
									?>

									<?php
									/* Total */
									if ($this->functionscore->calculate($bsheet['final_liabilities_total'],
										$bsheet['final_assets_total'], '==')) {
										echo '<tr class="bold-text bg-filled">';
									} else {
										echo '<tr class="bold-text error-text bg-filled">';
									}
									echo '<td>' . lang('balance_sheet_total') . '</td>';
									echo '<td class="text-right">' .
										$this->functionscore->toCurrency('C', $bsheet['final_liabilities_total']) .
										'</td>';
									echo '</tr>';
									?>
								</table>
							</td>
						</tr>
					</table>
				</div>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->