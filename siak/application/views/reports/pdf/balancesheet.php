<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
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
		} else if ($account->cl_total ==0) {
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
			} else if ($data['cl_total'] == 0){
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
?>

	<?php
	/* Show difference in opening balance */
	if ($bsheet['is_opdiff']) {
		echo '<div><div role="alert" class="alert alert-danger">' .
			('There is a difference in opening balance of ') .
			$this->functionscore->toCurrency($bsheet['opdiff']['opdiff_balance_dc'], $bsheet['opdiff']['opdiff_balance']) .
			'</div></div>';
	}

	/* Show difference in liabilities and assets total */
	if ($this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '!=')) {
		$final_total_diff = $this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '-');
		echo '<div><div role="alert" class="alert alert-danger">' .
			('There is a difference in Total Liabilities and Total Assets of ') .
			$this->functionscore->toCurrency('X', $final_total_diff) .
			'</div></div>';
	}
	?>
<!-- Main content -->
<div id="section-to-print">
	<div class="subtitle text-center">
		<?php echo $subtitle ?>
	</div>
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
					echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="'.lang('balace_sheet_expecting_pos_dr').'">' . $this->functionscore->toCurrency('D', $bsheet['assets_total']) . '</td>';
					echo '</tr>';
				}
				?>
				<tr class="bold-text">
					<?php
					/* Net loss */
					if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
						echo '<td>&nbsp;</td>';
						echo '<td>&nbsp;</td>';
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
							echo '<td>&nbsp;</td>';
							echo '<td>&nbsp;</td>';
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
					echo '<td>' . ('Total') . '</td>';
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
						echo '<td class="text-right show-tooltip" data-toggle="tooltip" data-original-title="'.lang('balace_sheet_expecting_pos_cr').'">' . $this->functionscore->toCurrency('C', $bsheet['liabilities_total']) . '</td>';
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
							echo '<td>&nbsp;</td>';
							echo '<td>&nbsp;</td>';
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
							echo '<td>&nbsp;</td>';
							echo '<td>&nbsp;</td>';
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
