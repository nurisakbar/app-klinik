<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">

<div>
  	<h3 class="subtitle text-center"><?= ucfirst($entrytypeLabel) . ' ' . lang('entry_title') . "  #" . $entry['number'] ?></h3>
	<?php
		echo (lang('entries_views_views_label_number')) . ' : ' . ($this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id']));
		echo '<br /><br />';
		echo (lang('entries_views_views_label_date')) . ' : ' . ($this->functionscore->dateFromSql($entry['date']));
		echo '<br /><br />';

		echo '<table class="stripped">';

		/* Header */
		echo '<tr>';
		if ($this->mSettings->drcr_toby == 'toby') {
			echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_to_by') . '</small></th>';
		} else {
			echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_dr_cr') . '</small></th>';
		}
		echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_ledger') . '</small></th>';
		echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_dr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
		echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_cr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')' . '</small></th>';
		echo '<th style="text-align: center; vertical-align: middle;"><small>' . lang('entries_views_views_th_narration') . '</small></th>';
		echo '</tr>';

		/* Intial rows */
		foreach ($curEntryitems as $row => $entryitem) {
			echo '<tr>';

			echo '<td>';
			if ($this->mSettings->drcr_toby == 'toby') {
				if ($entryitem['dc'] == 'D') {
					echo lang('entries_views_views_toby_D');
				} else {
					echo lang('entries_views_views_toby_C');
				}
			} else {
				if ($entryitem['dc'] == 'D') {
					echo lang('entries_views_views_drcr_D');
				} else {
					echo lang('entries_views_views_drcr_C');
				}
			}
			echo '</td>';

			echo '<td>';
			echo ($entryitem['ledger_name']);
			echo '</td>';

			echo '<td>';
			if ($entryitem['dc'] == 'D') {
				echo $entryitem['dr_amount'];
			} else {
				echo '';
			}
			echo '</td>';

			echo '<td>';
			if ($entryitem['dc'] == 'C') {
				echo $entryitem['cr_amount'];
			} else {
				echo '';
			}
			echo '</td>';
			echo '<td>';
			echo $entryitem['narration'];
			echo '</td>';
			echo '</tr>';
		}

		/* Total */
		echo '<tr class="bold-text">' . '<td></td>' . '<td>' . lang('entries_views_views_td_total') . '</td>' . '<td id="dr-total">' . $this->functionscore->toCurrency('D', $entry['dr_total']) . '</td>' . '<td id="cr-total">' . $this->functionscore->toCurrency('C', $entry['cr_total']) . '</td>' . '<td></td>' . '</tr>';

		/* Difference */
		if ($this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '==')) {
			/* Do nothing */
		} else {
			if ($this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '>')) {
				echo '<tr class="error-text">' . '<td></td>' . '<td>' . lang('entries_views_views_td_diff') . '</td>' . '<td id="dr-diff">' . $this->functionscore->toCurrency('D', $this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '-')) . '</td>' . '<td></td>' . '</tr>';
			} else {
				echo '<tr class="error-text">' . '<td></td>' . '<td>' . lang('entries_views_views_td_diff') . '</td>' . '<td></td>' . '<td id="cr-diff">' . $this->functionscore->toCurrency('C', $this->functionscore->calculate($entry['cr_total'], $entry['dr_total'], '-')) . '</td>' . '</tr>';

			}
		}
		echo '</table>';
		if (!empty($entry['tag_id'])) {
			echo '<br />';
			echo lang('entries_views_views_td_tag') . ' : ' . $this->functionscore->showTag($entry['tag_id']);

			echo '<br /><br />';
		}
		if (!empty($entry['notes'])) {
			echo lang('entries_views_add_label_note') .':';
			echo "<textarea name='notes' class='form-control' tabindex='9' rows='3' disabled>$entry[notes]</textarea>";
			echo '<br /><br />';
		}
		?>
		<table border="1" cellpadding="0" cellpadding="0">
			<tr>
				<td style="text-align: center;">Dibuat oleh,</td>
				<td style="text-align: center;">Diperiksa oleh,</td>
				<td style="text-align: center;">Disetujui oleh,</td>
				<td style="text-align: center;">Diterima oleh,</td>
			</tr>
			<tr>
				<td height="80px"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
</div>