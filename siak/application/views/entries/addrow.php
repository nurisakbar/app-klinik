<?php
	// Generate a random id to use in below form array
	$i = time() + rand  (0, time()) + rand  (0, time()) + rand  (0, time());

	echo '<tr class="ajax-add">';

	if ($this->mSettings->drcr_toby == 'toby') {
		echo '<td>' . '<div class="form-group-entryitem required"><select id="Entryitem' . $i . 'Dc" class="dc-dropdown form-control" name="Entryitem[' . $i . '][dc]"><option selected="selected" value="D">'.lang('entries_views_addrow_label_dc_toby_D').'</option><option value="C">'.lang('entries_views_addrow_label_dc_toby_C').'</option></select></div>' . '</td>';
	} else {
		echo '<td>' . '<div class="form-group-entryitem required"><select id="Entryitem' . $i . 'Dc" class="dc-dropdown form-control" name="Entryitem[' . $i . '][dc]"><option selected="selected" value="D">'.lang('entries_views_addrow_label_dc_drcr_D').'</option><option value="C">'.lang('entries_views_addrow_label_dc_drcr_C').'</option></select></div>' . '</td>';
	}

	echo '<td>' . '<div class="form-group-entryitem required"><select id="Entryitem' . $i . 'LedgerId" class="ledger-dropdown form-control" name="Entryitem[' . $i . '][ledger_id]">';
	// foreach ($ledger_options as $row => $data) {
	// 	if ($row >= 0) {
	// 		echo '<option value="' . $row . '">' . $data . '</option>';
	// 	} else {
	// 		echo '<option value="' . $row . '" disabled="disabled">' . $data . '</option>';
	// 	}
	// }
	echo '</select></div>' . '</td>';

	echo '<td>' . '<div class="form-group-entryitem"><input type="text" id="Entryitem' . $i . 'DrAmount" class="dr-item form-control" name="Entryitem[' . $i . '][dr_amount]" disabled=""></div>' . '</td>';

	echo '<td>' . '<div class="form-group-entryitem"><input type="text" id="Entryitem' . $i . 'CrAmount" class="cr-item form-control" name="Entryitem[' . $i . '][cr_amount]" disabled=""></div>' . '</td>';
	$data = array(
		'type'  => "text",
		'name'  => 'Entryitem[' . $i . '][narration]',
		'class' => 'form-control',
		'id' => 'Entryitem' . $i . 'Narration'
	);
	echo "<td><div class='form-group-entryitem'>";
	echo form_input($data);
	echo "</div></td>";
	echo '<td class="ledger-balance"><div></div></td>';
	echo '<td>';
	echo '<span class="deleterow" escape="false"><i class="glyphicon glyphicon-trash"></i></span>';
	echo '</td>';
	echo '</tr>';
?>