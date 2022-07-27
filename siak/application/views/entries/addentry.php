<?php
	$i = time() + rand  (0, time()) + rand  (0, time()) + rand  (0, time());

	if ($entryitem['cur_ledger_id'] == 0) {
		echo '<tr class="danger">';
		echo "<td colspan='7' style='text-align:center'>Please Select a Ledger.</td>";
		echo '</tr>';
		die();
	}

	if (empty($entryitem['amount'])) {
		echo '<tr class="danger">';
		echo "<td colspan='7' style='text-align:center'>Amount is required.</td>";
		echo '</tr>';
		die();
	}

	if (!is_numeric($entryitem['amount'])) {
		echo '<tr class="danger">';
		echo "<td colspan='7' style='text-align:center'>Invalid Amount.</td>";
		echo '</tr>';
		die();
	}

	if (empty($entryitem['narration'])) {
		echo '<tr class="danger">';
		echo "<td colspan='7' style='text-align:center'>Narration is required.</td>";
		echo '</tr>';
		die();
	}

	echo '<tr class="'.$i.'">';
	echo '<td class="'.$entryitem['dc_option_val'].'">' . $entryitem['dc_option'];
	$data = array(
		'type' => 'hidden',
		'name' => 'Entryitem[' . $i . '][dc]',
		'value' => $entryitem['dc_option_val']
	);
	echo form_input($data);
	echo "</td>";

	echo '<td class="'.$entryitem['cur_ledger_id'].'" id="cur_ledger">' . $entryitem['ledger_option'];
	$data = array(
		'type' => 'hidden',
		'name' => 'Entryitem[' . $i . '][ledger_id]',
		'value' => $entryitem['cur_ledger_id']
	);
	echo form_input($data);
	echo "</td>";

	if ($entryitem['dc_option_val'] === 'D') {
		echo '<td>' . $entryitem['amount'];
		$data = array(
			'type' => 'hidden',
			'name' => 'Entryitem[' . $i . '][dr_amount]',
			'class' => 'dr-item',
			'value' => $entryitem['amount']
		);
		echo form_input($data);
		echo "</td>";

		echo '<td><strong>-</strong></td>';
	}else{
		echo '<td><strong>-</strong></td>';
		echo '<td>' . $entryitem['amount'];
		$data = array(
			'type' => 'hidden',
			'name' => 'Entryitem[' . $i . '][cr_amount]',
			'class' => 'cr-item',
			'value' => $entryitem['amount']
		);
		echo form_input($data);
		echo "</td>";
	}

	echo '<td>' . $entryitem['narration'];
	$data = array(
		'type' => 'hidden',
		'name' => 'Entryitem[' . $i . '][narration]',
		'value' => $entryitem['narration']
	);
	echo form_input($data);
	echo "</td>";

	echo '<td class="ledger-balance"><div>'.$entryitem['ledger_balance'].'</div>';
	$data = array(
		'type' => 'hidden',
		'name' => 'Entryitem[' . $i . '][ledger_balance]',
		'value' => $entryitem['ledger_balance']
	);
	echo form_input($data);
	echo "</td>";

	echo '<td>';
	echo '<span class="deleterow" escape="false"><i class="glyphicon glyphicon-trash"></i></span>';
	echo '</td>';
	echo '</tr>';
?>