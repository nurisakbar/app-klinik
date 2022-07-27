<?php
/**
 * Display chart of accounts
 *
 * @account AccountList group account
 * @c int counter for number of level deep the account is
 * @THIS this $this CakePHP object passed inside function
 */
function print_account_chart($account, $c = 0, $THIS)
{
  	$CI =& get_instance();

	$counter = $c;

	/* Print groups */
	if ($account->id != 0) {
		echo '"';
		echo print_space($counter);
		echo ($CI->functionscore->toCodeWithName($account->code, $account->name));
		echo '",';

		echo '"' . lang('accounts_index_td_label_group') . '",';

		echo '"' . $CI->functionscore->toCurrency($account->op_total_dc, $account->op_total) . '",';

		echo '"' . $CI->functionscore->toCurrency('D', $account->dr_total) . '",';

		echo '"' . $CI->functionscore->toCurrency('C', $account->cr_total) . '",';

		if ($account->cl_total_dc == 'D') {
			echo '"' . $CI->functionscore->toCurrency('D', $account->cl_total) . '"';
		} else {
			echo '"' . $CI->functionscore->toCurrency('C', $account->cl_total) . '"';
		}
		echo "\n";
	}

	/* Print child ledgers */
	if (count($account->children_ledgers) > 0) {
		$counter++;
		foreach ($account->children_ledgers as $id => $data) {
			echo '"';
			echo print_space($counter);
			echo ($CI->functionscore->toCodeWithName($data['code'], $data['name']));
			echo '",';

			echo '"' . lang('accounts_index_td_label_ledger') . '",';

			echo '"' . $CI->functionscore->toCurrency($data['op_total_dc'], $data['op_total']) . '",';

			echo '"' . $CI->functionscore->toCurrency('D', $data['dr_total']) . '",';

			echo '"' . $CI->functionscore->toCurrency('C', $data['cr_total']) . '",';

			if ($data['cl_total_dc'] == 'D') {
				echo '"' . $CI->functionscore->toCurrency('D', $data['cl_total']) . '"';
			} else {
				echo '"' . $CI->functionscore->toCurrency('C', $data['cl_total']) . '"';
			}
			echo "\n";

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
		$html .= '      ';
	}
	return $html;
}

echo $subtitle;
echo "\n";
echo "\n";

echo '"' . lang('accounts_index_account_name') . '",';
echo '"' . lang('type') . '",';
echo '"' . lang('accounts_index_op_balance') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '",';
echo '"' . lang('trial_balance_total_debit') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '",';
echo '"' . lang('trial_balance_total_credit') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '",';
echo '"' . lang('accounts_index_cl_balance') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '"';
echo "\n";

print_account_chart($accountlist, -1, $this);

echo '"' . lang('entries_views_add_items_td_total') . '",';
echo '"","",';
echo '"' . $this->functionscore->toCurrency('D', $accountlist->dr_total) . '",';
echo '"' . $this->functionscore->toCurrency('C', $accountlist->cr_total) . '",';
echo '""';
echo "\n";
