<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- ./col -->
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('settings_views_printer_title'); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?= form_open(); ?>
            <div class="row">
            	<div class="col-md-6">
            		<fieldset>
		        		<legend><?= lang('settings_views_printer_legend_paper_size'); ?></legend>
		        		<div class="form-group">
				          <label for="height"><?= lang('settings_views_printer_label_height'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="height" name="height" value="<?= $account_settings->print_paper_height ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="width"><?= lang('settings_views_printer_label_width'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="width" name="width" value="<?= $account_settings->print_paper_width ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>
		        	</fieldset>
		        	<fieldset>
			      		<legend><?= lang('settings_views_printer_legend_output'); ?></legend>
			      		  <div class="form-group">
					          <label for="orientation"><?= lang('settings_views_printer_label_orientation'); ?></label>
					          <select class="form-control" name="orientation">
					          	<option value="P" <?= ($account_settings->print_orientation == 'P') ? 'selected' : ''; ?>><?= lang('settings_views_printer_option_portrait'); ?></option>
					          	<option value="L" <?= ($account_settings->print_orientation == 'L') ? 'selected' : ''; ?>><?= lang('settings_views_printer_option_landscape'); ?></option>
					          </select>
					        </div>

					        <div class="form-group">
					          <label for="output"><?= lang('settings_views_printer_legend_output_format'); ?></label>
					          <select class="form-control" name="output">
					          	<option value="H" <?= ($account_settings->print_page_format == 'H') ? 'selected' : ''; ?>><?= lang('settings_views_printer_option_html'); ?></option>
					          	<option value="T" <?= ($account_settings->print_page_format == 'T') ? 'selected' : ''; ?>><?= lang('settings_views_printer_option_text'); ?></option>
					          </select>
					        </div>
			      	</fieldset>
            	</div>
            	<div class="col-md-6">
            		<fieldset>
			       		<legend><?= lang('settings_views_printer_legend_paper_margin'); ?></legend>
			       		<div class="form-group">
			          	<label for="top"><?= lang('settings_views_printer_label_top'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="top" name="top" value="<?= $account_settings->print_margin_top ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="bottom"><?= lang('settings_views_printer_label_bottom'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="bottom" name="bottom" value="<?= $account_settings->print_margin_bottom ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="left"><?= lang('settings_views_printer_label_left'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="left" name="left" value="<?= $account_settings->print_margin_left ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="right"><?= lang('settings_views_printer_label_right'); ?></label>
				          <div class="input-group">
				         	<input type="text" class="form-control" id="right" name="right" value="<?= $account_settings->print_margin_right ?>">
				          	<span class="input-group-addon"><?= lang('settings_views_printer_label_inches'); ?></span>
				          </div>
				        </div>
			       	</fieldset>
            	</div>
            </div>
        </div>
        <div class="box-footer">
        	<div class="form-group">
	            <?php
	            echo form_submit('submit', lang('submit'), array('class'=> 'btn btn-success pull-right'));
	            ?>
            </div>
            <?= form_close(); ?>
        </div>
      </div>
  	</div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

