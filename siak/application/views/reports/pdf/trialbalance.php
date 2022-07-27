<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
<?php
function print_account_chart($account, $c = 0, $THIS)
{
  	$CI =& get_instance();

	$counter = $c;

	/* Print groups */
	if ($account->id != 0) {
		if ($account->id <= 4) {
			echo '<tr class="tr-group tr-root-group">';
		} else {
			echo '<tr class="tr-group">';
		}
		echo '<td class="td-group">';
		echo print_space($counter);
		echo ($CI->functionscore->toCodeWithName($account->code, $account->name));
		echo '</td>';

		echo '<td>'.lang('accounts_index_td_label_group').'</td>';

		echo '<td>';
		echo $CI->functionscore->toCurrency($account->op_total_dc, $account->op_total);
		echo '</td>';

		echo '<td>' . $CI->functionscore->toCurrency('D', $account->dr_total) . '</td>';

		echo '<td>' . $CI->functionscore->toCurrency('C', $account->cr_total) . '</td>';

		if ($account->cl_total_dc == 'D') {
			echo '<td>' . $CI->functionscore->toCurrency('D', $account->cl_total) . '</td>';
		} else {
			echo '<td>' . $CI->functionscore->toCurrency('C', $account->cl_total) . '</td>';
		}

		echo '</tr>';
	}

	/* Print child ledgers */
	if (count($account->children_ledgers) > 0) {
		$counter++;
		foreach ($account->children_ledgers as $id => $data) {
			echo '<tr class="tr-ledger">';
			echo '<td class="td-ledger">';
			echo print_space($counter);
			echo anchor('reports/ledgerstatement/ledgerid/'.$data['id'], $CI->functionscore->toCodeWithName($data['code'], $data['name']));
			echo '</td>';
			echo '<td>'.lang('accounts_index_td_label_ledger').'</td>';

			echo '<td>';
			echo $CI->functionscore->toCurrency($data['op_total_dc'], $data['op_total']);
			echo '</td>';

			echo '<td>' . $CI->functionscore->toCurrency('D', $data['dr_total']) . '</td>';

			echo '<td>' . $CI->functionscore->toCurrency('C', $data['cr_total']) . '</td>';

			if ($data['cl_total_dc'] == 'D') {
				echo '<td>' . $CI->functionscore->toCurrency('D', $data['cl_total']) . '</td>';
			} else {
				echo '<td>' . $CI->functionscore->toCurrency('C', $data['cl_total']) . '</td>';
			}

			echo '</tr>';
		}
		$counter--;
	}

	/* Print child groups recursively */
	foreach ($account->children_groups as $id => $data) {
		$counter++;
		print_account_chart($data, $counter, $THIS);
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
<div class="subtitle text-center">
	<?php echo $subtitle; ?>
</div>
<?php
				echo '<table class="stripped">'; ?>
				<thead>
					<tr>
						<?php
							echo '<th><small>' . lang('accounts_index_account_name') . '</small></th>';
							echo '<th><small>' . lang('type') . '</small></th>';
							echo '<th><small>' . lang('accounts_index_op_balance') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . lang('trial_balance_total_debit') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . lang('trial_balance_total_credit') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
							echo '<th><small>' . lang('accounts_index_cl_balance') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
						?>
					</tr>
				</thead>
					<?php
	print_account_chart($accountlist, -1, $this);

	if ($this->functionscore->calculate($accountlist->dr_total, $accountlist->cr_total, '==')) {
		echo '<tr class="bold-text ok-text">';
	} else {
		echo '<tr class="bold-text error-text">';
	}
	echo '<td>' . lang('entries_views_add_items_td_total') . '</td>';
	echo '<td></td><td></td>';
	echo '<td>' . $this->functionscore->toCurrency('D', $accountlist->dr_total) . '</td>';
	echo '<td>' . $this->functionscore->toCurrency('C', $accountlist->cr_total) . '</td>';
	if ($this->functionscore->calculate($accountlist->dr_total, $accountlist->cr_total, '==')) {
		echo '<td><span class="glyphicon glyphicon-ok-sign"></span></td>';
	} else {
		echo '<td><span class="glyphicon glyphicon-remove-sign"></span></td>';
	}
	echo '<td></td>';
	echo '</tr>';

echo '</table>';
?>
