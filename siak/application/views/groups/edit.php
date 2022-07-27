<script type="text/javascript">
$(document).ready(function() {
	/**
	 * On changing the parent group select box check whether the selected value
	 * should show the "Affects Gross Profit/Loss Calculations".
	 */
	$('#GroupParentId').change(function() {
		if ($(this).val() == '3' || $(this).val() == '4') {
			$('#AffectsGross').show();
		} else {
			$('#AffectsGross').hide();
		}
	});
	$('#GroupParentId').trigger('change');

	$("#GroupParentId").select2({width:'100%'});
});
</script>

<style type="text/css">
.select2-container--default .select2-results__option {
	font-weight: bold;
	color: #333;
}
</style>
<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- ./col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?= lang('groups_views_edit_title'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
				<div class="groups edit form">
				<?php
					echo form_open();	
					echo "<div class='row'>";
					echo "<div class='col-xs-5'>";
						echo '<div class="form-group">';
						echo form_label(lang('groups_views_edit_label_parent_group'), 'parent_id');
						echo form_dropdown('parent_id', $parents, set_value('parent_id', $group['parent_id']),array('class' => 'form-control', 'id'=>'GroupParentId'));
						echo "</div>";
					echo "</div>";
					echo "<div class='col-xs-2'>";
						echo '<div class="form-group">';
						echo form_label(lang('groups_views_edit_label_group_code'), 'code');
						echo form_input('code',set_value('code', $group['code']) ,array('class' => 'form-control'));
						echo "</div>";
					echo "</div>";
					echo "<div class='col-xs-5'>";
						echo '<div class="form-group">';
						echo form_label(lang('groups_views_edit_label_group_name'), 'name');
						echo form_input('name',set_value('name', $group['name']) ,array('class' => 'form-control'));
						echo "</div>";
					echo "</div>";
					echo "</div>";

						
					echo '<div class="form-group required" id="AffectsGross">';
					echo form_label(lang('groups_views_edit_label_affects'), 'affects_gross');
					$data = array(
					        'name'          => 'affects_gross',
					        'id'            => 'affects_gross',
					        'value'         => '1',
					        'checked'       => TRUE,
					        'style'         => 'margin:10px'
					);
					echo "<br>";
					echo form_radio($data).lang('groups_views_edit_label_gross_profit_loss');

					$data = array(
					        'name'          => 'affects_gross',
					        'id'            => 'affects_gross',
					        'value'         => '0',
					        'style'         => 'margin:10px'
					);
					echo "<br>";

					echo form_radio($data).lang('groups_views_edit_label_net_profit_loss');

					echo '<span class="help-block">' . (lang('groups_views_edit_note')) . '</span>';
					echo '</div>';

					
					echo '<div class="form-group">';
					echo form_submit('submit', lang('submit'), array('class' => 'btn btn-primary pull-right'));
					echo '<span class="link-pad"></span>';
					echo anchor('accounts/index', lang('cancel'), array('class' => 'btn btn-default pull-right', 'style' => "margin-right: 5px;"));
					echo '</div>';

					echo form_close();
					?>
					
				</div>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->