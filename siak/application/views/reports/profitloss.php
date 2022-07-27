<?php
function account_st_short($account, $c = 0, $THIS, $dc_type)
{
  	$CI =& get_instance();

	$counter = $c;
	if ($account->id > 4)
	{
		if ($dc_type == 'D' && $account->cl_total_dc == 'C' && $CI->functionscore->calculate($account->cl_total, 0, '!=')) {
			echo '<tr class="tr-group dc-error">';
		} else if ($dc_type == 'C' && $account->cl_total_dc == 'D' && $CI->functionscore->calculate($account->cl_total, 0, '!=')) {
			echo '<tr class="tr-group dc-error">';
		} else if ($account->dr_total == 0 && $account->cr_total == 0) {
			echo '<tr id="result_tr" style="display:none">';
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
			} else if ($data['dr_total'] == 0 && $data['cr_total'] == 0){
				echo '<tr id="result_tr" style="display:none">';
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

$gross_total = 0;
$positive_gross_pl = 0;
$net_expense_total = 0;
$net_income_total = 0;
$positive_net_pl = 0;

?>

<script type="text/javascript">
$(document).ready(function() {

	$("#accordion").accordion({
		collapsible: true,
		<?php
			if ($options == false) {
				echo 'active: false';
			}
		?>
	});

	$('.show-tooltip').tooltip({trigger: 'manual'}).tooltip('show');

	//* Calculate date range in javascript */
	startDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_start) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));
	endDate = new Date(<?php echo strtotime($this->mAccountSettings->fy_end) * 1000.05; ?>  + (new Date().getTimezoneOffset() * 60 * 1000));


	$('#ProfitlossOpening').on('ifChanged', function(event) {
	    if (event.target.checked) {
			$('#ProfitlossStartdate').prop('disabled', true);
			$('#ProfitlossEnddate').prop('disabled', true);
		} else {
			$('#ProfitlossStartdate').prop('disabled', false);
			$('#ProfitlossEnddate').prop('disabled', false);
		}
	});

	// /* On selecting custom period show the start and end date form fields */
	// $('#ProfitlossOpening').change(function() {
	// 	if ($(this).prop('checked')) {
	// 		$('#ProfitlossStartdate').prop('disabled', true);
	// 		$('#ProfitlossEnddate').prop('disabled', true);
	// 	} else {
	// 		$('#ProfitlossStartdate').prop('disabled', false);
	// 		$('#ProfitlossEnddate').prop('disabled', false);
	// 	}
	// });
	// $('#ProfitlossOpening').trigger('change');
	
	// $('#reset').click(function() {
	//     location = location.href;
	// });

	/* Setup jQuery datepicker ui */
	$('#ProfitlossStartdate').datepicker({
		minDate: startDate,
		maxDate: endDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#ProfitlossEnddate").datepicker("option", "minDate", selectedDate);
			} else {
				$("#ProfitlossEnddate").datepicker("option", "minDate", startDate);
			}
		}
	});
	$('#ProfitlossEnddate').datepicker({
		minDate: startDate,
		maxDate: endDate,
		dateFormat: '<?php echo $this->mDateArray[1]; ?>',
		numberOfMonths: 1,
		onClose: function(selectedDate) {
			if (selectedDate) {
				$("#ProfitlossStartdate").datepicker("option", "maxDate", selectedDate);
			} else {
				$("#ProfitlossStartdate").datepicker("option", "maxDate", endDate);
			}
		}
	});
});

</script>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$title;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div id="accordion">
					<h3>Options</h3>
					<div class="profitandloss form">
						<?php echo form_open(); ?>
							<div class="row">
								<div class="col-md-4">
									<div style="margin-top: 30px;">
										<label><input type="checkbox" id="ProfitlossOpening" name="opening" class="checkbox skip"> <?= lang('show_op_bs_title'); ?></label>
			                        </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label><?= lang('start_date'); ?></label>

					                    <div class="input-group">
					                    	<input id="ProfitlossStartdate" type="text" name="startdate" class="form-control" value="<?=(isset($startdate) ? $startdate : '');?>">

											<!-- <input id="ProfitlossStartdate" type="text" name="startdate" class="form-control"> -->
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
					                    	<input id="ProfitlossEnddate" type="text" name="enddate" class="form-control" value="<?=(isset($enddate) ? $enddate : '');?>">

											<!-- <input id="ProfitlossEnddate" type="text" name="enddate" class="form-control"> -->
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
								<input type="reset" name="reset" id="reset" class="btn btn-danger  pull-right" value="<?= lang('clear'); ?>">
							</div>
						<?php form_close();  ?>
					</div>
				</div>
				<br />
				<div class="btn-group pull-right" role="group">
					<a href="<?= base_url('reports/profitloss/download/pdf/'.$startdate.'/'.$enddate);?>" class="btn btn-info"><?= lang('export_to_pdf'); ?></a>
					<a href="<?= base_url('reports/profitloss/download/csv/'.$startdate.'/'.$enddate);?>" class="btn btn-primary"><?= lang('export_to_csv'); ?></a>
					<a class="btn btn-default" onclick="window.print()"><?= lang('print'); ?></a>
				</div>
				<br />
				<br />
				<div id="section-to-print">
					<div class="subtitle text-center">
					<?php echo $subtitle ?>
				</div>

				<table>

					<tr>
						<!-- Gross Expenses -->
						<td class="table-top width-50">
							<table class="stripped">
								<tr>
									<th><?php echo lang('profit_loss_ge'); ?></th>
									<th class="text-right"><?php echo lang('amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($pandl['gross_expenses'], $c = -1, $this, 'D'); ?>
							</table>
						</td>

						<!-- Gross Incomes -->
						<td class="table-top width-50">
							<table class="stripped">
								<tr>
									<th><?php echo lang('profit_loss_gi'); ?></th>
									<th class="text-right"><?php echo lang('amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($pandl['gross_incomes'], $c = -1, $this, 'C'); ?>
							</table>
						</td>
					</tr>

					<tr>
						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<?php
								/* Gross Expense Total */
								$gross_total = $pandl['gross_expense_total'];
								if ($this->functionscore->calculate($pandl['gross_expense_total'], 0, '>=')) {
									echo '<tr class="bold-text">';
									echo '<td>' . lang('profit_loss_tge') . '</td>';
									echo '<td class="text-right">' . $this->functionscore->toCurrency('D', $pandl['gross_expense_total']) . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="dc-error bold-text">';
									echo '<td>' . lang('profit_loss_tge') . '</td>';
									echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting Dr Balance">' . $this->functionscore->toCurrency('D', $pandl['gross_expense_total']) . '</td>';
									echo '</tr>';
								}
								?>
								<tr class="bold-text">
									<?php
									/* Gross Profit C/D */
									if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
										echo '<td>' . lang('profit_loss_gp') . '</td>';
										echo '<td class="text-right">' . $this->functionscore->toCurrency('', $pandl['gross_pl']) . '</td>';
										$gross_total = $this->functionscore->calculate($gross_total, $pandl['gross_pl'], '+');
									} else {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									}
									?>
								</tr>
								<tr class="bold-text bg-filled">
									<td><?php echo lang('profit_loss_t'); ?></td>
									<td class="text-right"><?php echo $this->functionscore->toCurrency('D', $gross_total); ?></td>
								</tr>
							</table>
						</td>

						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<?php
								/* Gross Income Total */
								$gross_total = $pandl['gross_income_total'];
								if ($this->functionscore->calculate($pandl['gross_income_total'], 0, '>=')) {
									echo '<tr class="bold-text">';
									echo '<td>' . lang('profit_loss_tgi') . '</td>';
									echo '<td class="text-right">' . $this->functionscore->toCurrency('C', $pandl['gross_income_total']) . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="dc-error bold-text">';
									echo '<td>' . lang('profit_loss_tgi') . '</td>';
									echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting Cr Balance">' . $this->functionscore->toCurrency('C', $pandl['gross_income_total']) . '</td>';
									echo '</tr>';
								}
								?>
								<tr class="bold-text">
									<?php
									/* Gross Loss C/D */
									if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									} else {
										echo '<td>' . lang('profit_loss_glcd') . '</td>';
										$positive_gross_pl = $this->functionscore->calculate($pandl['gross_pl'], 0, 'n');
										echo '<td class="text-right">' . $this->functionscore->toCurrency('', $positive_gross_pl) . '</td>';
										$gross_total = $this->functionscore->calculate($gross_total, $positive_gross_pl, '+');
									}
									?>
								</tr>
								<tr class="bold-text bg-filled">
									<td><?php echo lang('profit_loss_t'); ?></td>
									<td class="text-right"><?php echo $this->functionscore->toCurrency('C', $gross_total); ?></td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- Net Profit and Loss -->
					<tr>
						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<tr>
									<th><?php echo lang('profit_loss_ne'); ?></th>
									<th class="text-right"><?php echo lang('amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($pandl['net_expenses'], $c = -1, $this, 'D'); ?>
							</table>
						</td>

						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<tr>
									<th><?php echo lang('profit_loss_ni'); ?></th>
									<th class="text-right"><?php echo lang('amount'); ?><?php echo ' (' . $this->mAccountSettings->currency_symbol . ')'; ?></th>
								</tr>
								<?php echo account_st_short($pandl['net_incomes'], $c = -1, $this, 'C'); ?>
							</table>
						</td>
					</tr>

					<tr>
						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<?php
								/* Net Expense Total */
								$net_expense_total = $pandl['net_expense_total'];
								if ($this->functionscore->calculate($pandl['net_expense_total'], 0, '>=')) {
									echo '<tr class="bold-text">';
									echo '<td>' . lang('profit_loss_te') . '</td>';
									echo '<td class="text-right">' . $this->functionscore->toCurrency('D', $pandl['net_expense_total']) . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="dc-error bold-text">';
									echo '<td>' . lang('profit_loss_te') . '</td>';
									echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting Dr Balance">' . $this->functionscore->toCurrency('D', $pandl['net_expense_total']) . '</td>';
									echo '</tr>';
								}
								?>
								<tr class="bold-text">
									<?php
									/* Gross Loss B/D */
									if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									} else {
										echo '<td>' . lang('profit_loss_glbd') . '</td>';
										$positive_gross_pl = $this->functionscore->calculate($pandl['gross_pl'], 0, 'n');
										echo '<td class="text-right">' . $this->functionscore->toCurrency('', $positive_gross_pl) . '</td>';
										$net_expense_total = $this->functionscore->calculate($net_expense_total, $positive_gross_pl, '+');
									}
									?>
								</tr>
								<tr class="bold-text ok-text">
									<?php
									/* Net Profit */
									if ($this->functionscore->calculate($pandl['net_pl'], 0, '>=')) {
										echo '<td>' . lang('profit_loss_np') . '</td>';
										echo '<td class="text-right">' . $this->functionscore->toCurrency('', $pandl['net_pl']) . '</td>';
										$net_expense_total = $this->functionscore->calculate($net_expense_total, $pandl['net_pl'], '+');
									} else {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									}
									?>
								</tr>
								<tr class="bold-text bg-filled">
									<td><?php echo lang('profit_loss_t'); ?></td>
									<td class="text-right"><?php echo $this->functionscore->toCurrency('D', $net_expense_total); ?></td>
								</tr>
							</table>
						</td>

						<td class="table-top width-50">
							<div class="report-tb-pad"></div>
							<table class="stripped">
								<?php
								/* Net Income Total */
								$net_income_total = $pandl['net_income_total'];
								if ($this->functionscore->calculate($pandl['net_income_total'], 0, '>=')) {
									echo '<tr class="bold-text">';
									echo '<td>' . lang('profit_loss_ti') . '</td>';
									echo '<td class="text-right">' . $this->functionscore->toCurrency('C', $pandl['net_income_total']) . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="dc-error bold-text">';
									echo '<td>' . lang('profit_loss_ti') . '</td>';
									echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="Expecting Cr Balance">' . $this->functionscore->toCurrency('C', $pandl['net_income_total']) . '</td>';
									echo '</tr>';
								}
								?>
								<tr class="bold-text">
									<?php
									/* Gross Profit B/D */
									if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
										$net_income_total = $this->functionscore->calculate($net_income_total, $pandl['gross_pl'], '+');
										echo '<td>' . lang('profit_loss_gpbd') . '</td>';
										echo '<td class="text-right">' .  $this->functionscore->toCurrency('', $pandl['gross_pl']) . '</td>';
									} else {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									}
									?>
								</tr>
								<tr class="bold-text ok-text">
									<?php
									/* Net Loss */
									if ($this->functionscore->calculate($pandl['net_pl'], 0, '>=')) {
										echo '<td>&nbsp</td>';
										echo '<td>&nbsp</td>';
									} else {
										echo '<td>' . lang('profit_loss_nl') . '</td>';
										$positive_net_pl = $this->functionscore->calculate($pandl['net_pl'], 0, 'n');
										echo '<td class="text-right">' . $this->functionscore->toCurrency('', $positive_net_pl) . '</td>';
										$net_income_total = $this->functionscore->calculate($net_income_total, $positive_net_pl, '+');
									}
									?>
								</tr>
								<tr class="bold-text bg-filled">
									<td><?php echo lang('profit_loss_t'); ?></td>
									<td class="text-right"><?php echo $this->functionscore->toCurrency('C', $net_income_total); ?></td>
								</tr>
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
