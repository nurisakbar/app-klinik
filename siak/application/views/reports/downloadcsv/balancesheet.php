<?php
function account_st_short($account, $c = 0, $THIS, $dc_type)
{
  	$CI =& get_instance();

	$counter = $c;
	if ($account->id > 4)
	{
		echo '"';
		echo print_space($counter);
		echo ($CI->functionscore->toCodeWithName($account->code, $account->name));
		echo '",';

		echo '"' . $CI->functionscore->toCurrency($account->cl_total_dc, $account->cl_total) . '"';
		echo "\n";
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
			echo '"';
			echo print_space($counter);
			echo ($CI->functionscore->toCodeWithName($data['code'], $data['name']));
			echo '",';

			echo '"' . $CI->functionscore->toCurrency($data['cl_total_dc'], $data['cl_total']) . '"';
			echo "\n";
		}
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

?>

<?php
	/* Show difference in opening balance */
	if ($bsheet['is_opdiff']) {
		echo '"' . sprintf(lang('balance_sheet_diff_opp_of'), $this->functionscore->toCurrency($bsheet['opdiff']['opdiff_balance_dc'], $bsheet['opdiff']['opdiff_balance'])) .
			'"' .
			"\n";
			"\n";
	}

	/* Show difference in liabilities and assets total */
	if ($this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '!=')) {
		$final_total_diff = $this->functionscore->calculate($bsheet['final_liabilities_total'], $bsheet['final_assets_total'], '-');
		echo '"' .
			sprintf(lang('balance_sheet_tla_diff'), $this->functionscore->toCurrency('X', $final_total_diff) ) .
			'"' .
			"\n";
			"\n";
	}

	echo $subtitle;
	echo "\n";
	echo "\n";

	/**************** Assets ****************/
	echo '"' . lang('balance_sheet_assets') . '",';
	echo '"' . lang('amount') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '"';
	echo "\n";
	echo account_st_short($bsheet['assets'], $c = -1, $this, 'D');
	echo "\n";

	/* Assets Total */
	echo '"' . lang('balance_sheet_total_assets') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $bsheet['assets_total']) . '"';
	echo "\n";

	/* Net loss */
	if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
		/* Do nothing */
	} else {
		echo '"' . lang('balance_sheet_net_loss') . '",';
		$positive_pandl = $this->functionscore->calculate($bsheet['pandl'], 0, 'n');
		echo '"' . $this->functionscore->toCurrency('D', $positive_pandl) . '"';
		echo "\n";
	}

	if ($bsheet['is_opdiff']) {
		/* If diff in opening balance is Dr */
		if ($bsheet['opdiff']['opdiff_balance_dc'] == 'D') {
			echo '"' . lang('balance_sheet_diff_opp') . '",';
			echo '"' . $this->functionscore->toCurrency('D', $bsheet['opdiff']['opdiff_balance']) . '"';
			echo "\n";
		}
	}

	/* Total */
	echo '"' . lang('balance_sheet_total') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $bsheet['final_assets_total']) . '"';
	echo "\n";
	echo "\n";

	/**************** Liabilities ****************/
	echo '"' . lang('balance_sheet_loe') . '",';
	echo '"' . lang('amount') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '"';
	echo "\n";
	echo account_st_short($bsheet['liabilities'], $c = -1, $this, 'C');
	echo "\n";

	/* Liabilities Total */
	echo '"' . lang('balance_sheet_tloe') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $bsheet['liabilities_total']) . '"';
	echo "\n";

	/* Net profit */
	if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
		echo '"' . lang('balance_sheet_net_profit') . '",';
		echo '"' . $this->functionscore->toCurrency('C', $bsheet['pandl']) . '"';
		echo "\n";
	}

	if ($bsheet['is_opdiff']) {
		/* If diff in opening balance is Cr */
		if ($bsheet['opdiff']['opdiff_balance_dc'] == 'C') {
			echo '"' . lang('balance_sheet_diff_opp') . '",';
			echo '"' . $this->functionscore->toCurrency('C', $bsheet['opdiff']['opdiff_balance']) . '"';
			echo "\n";
		}
	}

	/* Total */
	echo '"' . lang('balance_sheet_total') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $bsheet['final_liabilities_total']) .	'"';
	echo "\n";
	echo "\n";
