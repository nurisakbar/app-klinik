<script type="text/javascript">
    $(document).ready(function() {
        /* Setup jQuery datepicker ui */
        $('#fiscal_start').datepicker({
            dateFormat: $("#date_format").val().split('|')[1],  /* Read the Javascript date format value */
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                $("#fiscal_end").datepicker("option", "minDate", selectedDate);
            }
        });
        $('#fiscal_end').datepicker({
            dateFormat: $("#date_format").val().split('|')[1],  /* Read the Javascript date format value */
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                $("#fiscal_start").datepicker("option", "maxDate", selectedDate);
            }
        });

        $("#date_format").change(function() {
            /* Read the Javascript date format value */
            dateFormat = $(this).val().split('|')[1];
            $("#fiscal_start").datepicker("option", "dateFormat", dateFormat);
            $("#fiscal_end").datepicker("option", "dateFormat", dateFormat);
        });
    });
</script>
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- ./col -->
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('settings_views_cf_title'); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        	<h4><?= lang('settings_views_cf_subtitle'); ?></h4>
			<table>
				<tr>
					<td width="150px"><?php echo (lang('settings_views_cf_label_name')); ?></td>
					<td><?php echo ($this->mAccountSettings->name); ?></td>
				</tr>
				<tr>
					<td><?php echo (lang('settings_views_cf_label_email')); ?></td>
					<td><?php echo ($this->mAccountSettings->email); ?></td>
				</tr>
				<tr>
					<td><?php echo (lang('settings_views_cf_label_currency')); ?></td>
					<td><?php echo ($this->mAccountSettings->currency_symbol); ?></td>
				</tr>
				<tr>
					<td><?php echo (lang('settings_views_cf_label_fiscal_year')); ?></td>
					<td><?php echo $this->functionscore->dateFromSql($this->mAccountSettings->fy_start) . ' to ' . $this->functionscore->dateFromSql($this->mAccountSettings->fy_end); ?></td>
				</tr>
				<tr>
					<td><?php echo (lang('settings_views_cf_label_status')); ?></td>
					<?php
						if ($this->mAccountSettings->account_locked == 0) {
							echo '<td>' . (lang('settings_views_cf_label_unlocked')) . '</td>';
						} else {
							echo '<td>' . (lang('settings_views_cf_label_locked')) . '</td>';
						}
					?>
				</tr>
			</table>

			<br />
          <?= form_open(); ?>

          <div class="row">
        		<div class="col-md-4">
        			<div class="form-group">
						<label><?= lang('settings_views_cf_label_label'); ?></label>
	                    <div class="input-group">
	            			<?php echo form_input($label);?>

	                        <div class="input-group-addon">
	                            <i>
	                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('settings_views_cf_label_tooltip'); ?>">
	                                </div>
	                            </i>
	                        </div>
	                    </div>
	                    <!-- /.input group -->
	                </div>
	                <!-- /.form group -->
	                <p>
			            <label><?= lang('settings_views_cf_label_company_name'); ?></label>
			            <?php echo form_input($name);?>
			     	</p>
			     	
        		</div>
        		<div class="col-md-4">
        			<p>
			            <label><?= lang('settings_views_cf_label_fy_start'); ?></label>
			            <?php echo form_input($fiscal_start);?>
			     	</p>
			     	<p>
			            <label><?= lang('settings_views_cf_label_fy_end'); ?></label>
			            <?php echo form_input($fiscal_end);?>
			     	</p>
        		</div>
        		<div class="col-md-4">
        			<p>
			            <label><?= lang('settings_views_cf_label_date_format'); ?></label>
			            <select class="form-control" name="date_format" id="date_format">
			            	<option value="d-M-Y|dd-M-yy|dd-MMM-yyyy"><?= lang('date_format_option_1'); ?></option>
			            	<option value="M-d-Y|M-dd-yy|MMM-dd-yyyy"><?= lang('date_format_option_2'); ?></option>
			            	<option value="Y-M-d|yy-M-dd|yyyy-MMM-dd"><?= lang('date_format_option_3'); ?></option>
			            </select>
			     	</p>
        		</div>
        	</div>
	     	
	     	
	     	
	     	
	     	<h2><?= lang('settings_views_cf_label_db_settings'); ?></h2>
	        <div class="row">
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_type'); ?></label>
	                <select name="db_type" class="form-control">
	                    <option value="mysqli"><?=lang('settings_views_cf_db_type_option_mysql'); ?></option>
	                </select>
	            </div>
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_name'); ?></label>
	                <?php echo form_input($db_name);?>
	            </div>
	            <!-- <div class="col-md-4">
	                <label><?php // echo lang('settings_views_cf_label_db_schema'); ?></label>
	                <?php // echo form_input($db_schema);?>
	                <small>Note : Database schema is required for Postgres database connection. Leave it blank for MySQL connections.</small>
	            </div> -->
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_host'); ?></label>
	                <?php echo form_input($db_host);?>
	            </div>
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_port'); ?></label>
	            <?php echo form_input($db_port);?>
	            </div>

	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_username'); ?></label>
	                <?php echo form_input($db_username);?>
	            </div>
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_db_password'); ?></label>
	                <?php echo form_input($db_password);?>
	            </div>
	            <div class="col-md-4">
	            	<div class="form-group">
	                	<label><?= lang('settings_views_cf_label_db_prefix'); ?></label>
	                    <div class="input-group">
	                		<?php echo form_input($db_prefix);?>

	                        <div class="input-group-addon">
	                            <i>
	                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('settings_views_cf_prefix_tooltip');?>">
	                                </div>
	                            </i>
	                        </div>
	                    </div>
	                    <!-- /.input group -->
	                </div>
	                <!-- /.form group -->
	            </div>
	            <div class="col-md-4">
	                <label><?= lang('settings_views_cf_label_use_persistent_conn'); ?></label>
	                <div class="checkbox"><input type="checkbox" name="persistent"><?= lang('settings_views_cf_use_persistent_conn_yes'); ?></div>
	            </div>

	        </div>
        </div>
        <div class="box-footer">
        	<div class="form-group">
	            <?= form_submit('submit', lang('submit'), array('class'=> 'btn btn-success pull-right')); ?>
            </div>
          <?= form_close(); ?>
        </div>
      </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->