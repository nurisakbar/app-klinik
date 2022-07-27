<script type="text/javascript">
	$(document).ready(function () {

		/* Datatables */
	    table = $('.stripped').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        'displayLength': site.msettings.row_count,
	        "order": [[0, "asc"]], //Initial no order.
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?= base_url('entries/getEntries') ?>",
	            "type": "POST"
	        },
	        "columns": [
	        	{
	        		data: 'date'
	        	},
		        {
		        	data: 'number'
		        },
		        {
		        	data: 'kode',
		        	"orderable": false
		        },
		        {
		        	data: 'id',
		        	"orderable": false
		        },
		        {
		        	data: 'entryTypeName'
		        },
		        {
		        	data: 'tag_id'
		        },
		        {
		        	data: 'dr_total'
		        },
	        	{
	        		data: 'cr_total'
	        	},
	        	{
	        		data: 'Actions',
	        		"orderable": false
	        	},
	        ]
	    });
    });
</script>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?= lang('entries_views_index_title'); ?></h3>
					<!-- Split button -->
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-plus-square"></i>
							<?= lang('entries_views_index_add_entry_btn'); ?>
						</button>
						<ul class="dropdown-menu">
							<?php foreach($this->DB1->get('entrytypes')->result_array() as $entrytype): ?>
							<li>
								<a href="<?= base_url(); ?>entries/add/<?=$entrytype['label']?>"><?= $entrytype['name']; ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>	
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="stripped ">
						<thead>
							<tr>
								<th><?= lang('entries_views_index_th_date'); ?></th>
								<th><?= lang('entries_views_index_th_number'); ?></th>
								<th><?= lang('entries_views_index_th_ref'); ?></th>
								<th><?= lang('entries_views_index_th_ledger'); ?></th>
								<th><?= lang('entries_views_index_th_type'); ?></th>
								<th><?= lang('entries_views_index_th_tag'); ?></th>
								<th><?= lang('entries_views_index_th_debit_amount'); ?></th>
								<th><?= lang('entries_views_index_th_credit_amount'); ?></th>
								<th><?= lang('entries_views_index_th_actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								// foreach ($entries as $entry) {
								// 	$this->DB1->where('id', $entry['entrytype_id']);
								// 	$q = $this->DB1->get('entrytypes')->row();
								// 	$entryTypeName = $q->name;
								// 	$entryTypeLabel = $q->label;
							?>
							<!-- <tr>
								<td><?=  $this->functionscore->dateFromSql($entry['date']) ?></td>
								<td><?= ($this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id'])) ?></td>
								<td><?= ($this->functionscore->entryLedgers($entry['id'])) ?></td>
								<td><?= ($entryTypeName) ?></td>
								<td><?= $this->functionscore->showTag($entry['tag_id']) ?></td>
								<td><?= $this->functionscore->toCurrency('D', $entry['dr_total']) ?></td>
								<td><?= $this->functionscore->toCurrency('C', $entry['cr_total']) ?></td>
								<td>
									<a href="<?= base_url();?>entries/view/<?= ($entryTypeLabel); ?>/<?= $entry['id']; ?>" style="padding-right: 5px;" title="<?= lang('entries_views_index_th_actions_view_btn'); ?>"><i class="glyphicon glyphicon-log-in"></i></a>
									<a href="<?= base_url();?>entries/edit/<?= ($entryTypeLabel); ?>/<?= $entry['id']; ?>" style="padding-right: 1px;" title="<?= lang('entries_views_index_th_actions_edit_btn'); ?>"><i class="glyphicon glyphicon-edit"></i></a>
									<a href="<?= base_url();?>entries/delete/<?= ($entryTypeLabel); ?>/<?= $entry['id']; ?>" title="<?= lang('entries_views_index_th_actions_delete_btn'); ?>"><i class="glyphicon glyphicon-trash"></i></a>
								</td>
							</tr> -->
							<?php // } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>