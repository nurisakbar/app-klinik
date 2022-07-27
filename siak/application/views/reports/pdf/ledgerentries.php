<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
<?php if ($showEntries) {  ?>
	<div class="subtitle text-center">
		<?php echo $subtitle; ?>
	</div>
	<!-- <div class="row" style="margin-bottom: 10px;">
		<div class="col-md-6">
			<table class="summary stripped table-condensed">
				<tr>
					<td class="td-fixwidth-summary"><?php echo lang('ledgers_views_edit_label_bank_cash_account'); ?></td>
					<td>

						<?php
							if ($ledger_data['type'] == 1) {
								echo lang('yes');
							} else {
								echo lang('no');
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="td-fixwidth-summary"><?php echo lang('ledger'); ?></td>
					<td><?php echo ($ledger_data['notes']); ?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-6">
			<table class="summary stripped table-condensed">
				<tr>
					<td class="td-fixwidth-summary"><?php echo $opening_title; ?></td>
					<td><?php echo $this->functionscore->toCurrency($op['dc'], $op['amount']); ?></td>
				</tr>
				<tr>
					<td class="td-fixwidth-summary"><?php echo $closing_title; ?></td>
					<td><?php echo $this->functionscore->toCurrency($cl['dc'], $cl['amount']); ?></td>
				</tr>
			</table>
		</div>
	</div> -->
	<table class="stripped">
		<thead>
			<tr>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('date'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('number'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('ledger'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('type'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('tag'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('dr_amount'); ?></small></th>
				<th style='text-align:center; vertical-align:middle'><small><?php echo lang('cr_amount'); ?></small></th>
			</tr>
		</thead>
		<?php
			/* Show the entries table */
			foreach ($entries as $entry) {
				$entryTypeName = $entry['entryTypeName'];
				echo '<tr>';
				echo '<td>' . $this->functionscore->dateFromSql($entry['date']) . '</td>';
				echo '<td>' . ($this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id'])) . '</td>';
				echo '<td>' . ($this->functionscore->entryLedgers($entry['id'])) . '</td>';
				echo '<td>' . ($entryTypeName) . '</td>';
				echo '<td>' . $this->functionscore->showTag($entry['tag_id'])  . '</td>';
		        echo '<td>' . $this->functionscore->toCurrency('', $entry['dr_total']) . '</td>';
			    echo '<td>' . $this->functionscore->toCurrency('', $entry['cr_total']) . '</td>';
				?>			
				<?php
				echo '</tr>';
			}
		?>
	</table>
<?php } ?>