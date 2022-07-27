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

$gross_total = 0;
$positive_gross_pl = 0;
$net_expense_total = 0;
$net_income_total = 0;
$positive_net_pl = 0;

?>

<?php
	echo $subtitle;
	echo "\n";
	echo "\n";

	/* Gross Expense */
	echo '"' . lang('profit_loss_ge') . '",';
	echo '"' . lang('profit_loss_da') . '"';
	echo "\n";
	echo account_st_short($pandl['gross_expenses'], $c = -1, $this, 'D');
	echo "\n";

	/* Gross Expense Total */
	$gross_total = $pandl['gross_expense_total'];
	echo '"' . lang('profit_loss_tge') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $pandl['gross_expense_total']) . '"';
	echo "\n";

	/* Gross Profit C/D */
	if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
		echo '"' . lang('profit_loss_gp') . '",';
		echo '"' . $this->functionscore->toCurrency('', $pandl['gross_pl']) . '"';
		$gross_total = $this->functionscore->calculate($gross_total, $pandl['gross_pl'], '+');
		echo "\n";
	}

	echo '"' . lang('profit_loss_t') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $gross_total) . '"';
	echo "\n";
	echo "\n";

	/* Gross Incomes */
	echo '"' . lang('profit_loss_gi') . '",';
	echo '"' . lang('profit_loss_ca') . '"';
	echo "\n";
	echo account_st_short($pandl['gross_incomes'], $c = -1, $this, 'C');
	echo "\n";

	/* Gross Income Total */
	$gross_total = $pandl['gross_income_total'];
	echo '"' . lang('profit_loss_tgi') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $pandl['gross_income_total']) . '"';
	echo "\n";

	/* Gross Loss C/D */
	if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
		/* Do nothing */
	} else {
		echo '"' . lang('profit_loss_glcd') . '",';
		$positive_gross_pl = $this->functionscore->calculate($pandl['gross_pl'], 0, 'n');
		echo '"' . $this->functionscore->toCurrency('', $positive_gross_pl) . '"';
		$gross_total = $this->functionscore->calculate($gross_total, $positive_gross_pl, '+');
		echo "\n";
	}

	echo '"' . lang('profit_loss_t') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $gross_total) . '"';
	echo "\n";
	echo "\n";

	/* Net Expenses */
	echo '"' . lang('profit_loss_da') . '",';
	echo '"' . lang('profit_loss_ne'). '"';
	echo "\n";
	echo account_st_short($pandl['net_expenses'], $c = -1, $this, 'D');
	echo "\n";

	/* Net Expense Total */
	$net_expense_total = $pandl['net_expense_total'];
	echo '"' . lang('profit_loss_te') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $pandl['net_expense_total']) . '"';
	echo "\n";

	/* Gross Loss B/D */
	if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
		/* Do nothing */
	} else {
		echo '"' . lang('profit_loss_glbd') . '",';
		$positive_gross_pl = $this->functionscore->calculate($pandl['gross_pl'], 0, 'n');
		echo '"' . $this->functionscore->toCurrency('', $positive_gross_pl) . '"';
		$net_expense_total = $this->functionscore->calculate($net_expense_total, $positive_gross_pl, '+');
		echo "\n";
	}

	/* Net Profit */
	if ($this->functionscore->calculate($pandl['net_pl'], 0, '>=')) {
		echo '"' . lang('profit_loss_np') . '",';
		echo '"' . $this->functionscore->toCurrency('', $pandl['net_pl']) . '"';
		$net_expense_total = $this->functionscore->calculate($net_expense_total, $pandl['net_pl'], '+');
		echo "\n";
	}

	echo '"' . lang('profit_loss_t') . '",';
	echo '"' . $this->functionscore->toCurrency('D', $net_expense_total) . '"';
	echo "\n";
	echo "\n";

	/* Net Income */
	echo '"' . lang('profit_loss_ni') . '",';
	echo '"' . lang('profit_loss_ca') . '"';
	echo "\n";
	echo account_st_short($pandl['net_incomes'], $c = -1, $this, 'C');
	echo "\n";

	/* Net Income Total */
	$net_income_total = $pandl['net_income_total'];
	echo '"' . ('Total Incomes') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $pandl['net_income_total']) . '"';
	echo "\n";

	/* Gross Profit B/D */
	if ($this->functionscore->calculate($pandl['gross_pl'], 0, '>=')) {
		$net_income_total = $this->functionscore->calculate($net_income_total, $pandl['gross_pl'], '+');
		echo '"' . lang('profit_loss_gpbd') . '",';
		echo '"' .  $this->functionscore->toCurrency('', $pandl['gross_pl']) . '"';
		echo "\n";
	}

	/* Net Loss */
	if ($this->functionscore->calculate($pandl['net_pl'], 0, '>=')) {
		/* Do nothing */
	} else {
		echo '"' . lang('profit_loss_nl') . '",';
		$positive_net_pl = $this->functionscore->calculate($pandl['net_pl'], 0, 'n');
		echo '"' . $this->functionscore->toCurrency('', $positive_net_pl) . '"';
		$net_income_total = $this->functionscore->calculate($net_income_total, $positive_net_pl, '+');
		echo "\n";
	}

	echo '"' . lang('profit_loss_t') . '",';
	echo '"' . $this->functionscore->toCurrency('C', $net_income_total) . '"';
	echo "\n";
