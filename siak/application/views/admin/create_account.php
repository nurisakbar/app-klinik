<section class="content">
  <div class="box">
    <div class="box-header">
    <h1><?php echo lang('create_account_heading');?></h1>
    <p><?php echo lang('create_account_subheading');?></p>
    </div>
    <div class="box-body">
	<?php echo form_open_multipart("admin/create_account");?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo lang('create_account_label');?></label>

                    <div class="input-group">
                        <?php echo form_input($label);?>

                        <div class="input-group-addon">
                            <i>
                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo lang('create_account_label_note');?>">
                                </div>
                            </i>
                        </div>
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->
                <p>
                    <label><?php echo lang('create_account_name');?></label>
                    <?php echo form_input($name);?>
                </p>
                <p>
                    <label><?php echo lang('create_account_address');?></label>
                    <?php echo form_input($address);?>
                </p>
            </div>
            <div class="col-md-4">
                <p>
                    <label><?php echo lang('create_account_email');?></label>
                    <?php echo form_input($email);?>
                </p>
                <div class="form-group">
                    <label><?php echo lang('create_account_decimal_places');?></label>

                    <div class="input-group">
                        <?php echo form_input($decimal_place);?>

                        <div class="input-group-addon">
                            <i>
                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo lang('create_account_decimal_places_note');?>">
                                </div>
                            </i>
                        </div>
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->
                <p>
                    <label><?php echo lang('create_account_currency_symbol');?></label>
                    <?php echo form_input($currency);?>
                </p>                
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <label><?php echo lang('create_account_financial_year_start');?></label>
                            <?php echo form_input($fiscal_start);?>
                        </p>
                        <div class="form-group">
                            <label><?php echo lang('create_account_currency_format');?></label>
                            <select class="form-control" name="currency_format" id="currency_format">
                                <option value="##,###.##"><?= lang('create_account_currency_format_option_1');?></option>
                                <option value="##,##.##"><?= lang('create_account_currency_format_option_2');?></option>
                                <option value="###,###.##"><?= lang('create_account_currency_format_option_3');?></option>
                            </select>
                        </div>
                        <!-- /.form group -->
                    </div>
                    <div class="col-md-6">
                        <p>
                            <label><?php echo lang('create_account_financial_year_end');?></label>
                            <?php echo form_input($fiscal_end);?>
                        </p>
                        <div class="form-group">
                            <label><?php echo lang('create_account_date_format');?></label>
                            <select class="form-control" name="date_format" id="date_format">
                                <option value="d-M-Y|dd-M-yy|dd-MMM-yyyy"><?= lang('date_format_option_1');?></option>
                                <option value="M-d-Y|M-dd-yy|MMM-dd-yyyy"><?= lang('date_format_option_2');?></option>
                                <option value="Y-M-d|yy-M-dd|yyyy-MMM-dd"><?= lang('date_format_option_3');?></option>
                            </select>
                        </div>
                        <!-- /.form group -->
                    </div>
                </div>
                <p>
                    <div style="margin-left: 20px;">
                        <label><?= lang('create_account_logo_upload_label'); ?></label>
                        <input type="file" name="companylogoUpload" id="companylogoUpload">
                    </div>  
                </p>
            </div>
        </div>
        <h2><?php echo lang('create_account_database_settings_heading');?></h2>
        <div class="row">
            <div class="col-md-4">
                <label><?php echo lang('create_account_database_type'); ?></label>
                <select name="db_type" class="form-control">
                    <option value="mysqli">MySQL</option>
                </select>
            </div>
            <div class="col-md-4">
                <label><?php echo lang('create_account_database_name');?></label>
                <?php echo form_input($db_name);?>
            </div>
            <!-- <div class="col-md-4">
                <label>Database schema</label>
                <?php //echo form_input($db_schema);?>
            </div> -->
            <div class="col-md-4">
                <label><?php echo lang('create_account_database_host');?></label>
                <?php echo form_input($db_host);?>
            </div>
            <div class="col-md-4">
                <label><?php echo lang('create_account_database_port');?></label>
            <?php echo form_input($db_port);?>
            </div>

            <div class="col-md-4">
                <label><?php echo lang('create_account_database_login');?></label>
                <?php echo form_input($db_username);?>
            </div>
            <div class="col-md-4">
                <label><?php echo lang('create_account_database_password');?></label>
                <?php echo form_input($db_password);?>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo lang('create_account_database_prefix');?></label>

                    <div class="input-group">
                        <?php echo form_input($db_prefix);?>
                        <div class="input-group-addon">
                            <i>
                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo lang('create_account_database_prefix_note');?>">
                                </div>
                            </i>
                        </div>
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->
            </div>
            <div class="col-md-4">
                <label><?php echo lang('create_account_use_persistent_connection');?></label>
                <div class="checkbox"><input type="checkbox" name="persistent"><?=lang('create_account_use_persistent_connection_label');?></div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right"><?=lang('submit');?></button>
        <a href="<?= base_url(); ?>admin/accounts/" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('create_account_cancel_button');?></a>
    </div>
    <?php echo form_close();?>
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {


        /* Setup jQuery datepicker ui */
        $('#fiscal_start').datepicker({
            dateFormat: $("#date_format").val().split('|')[1],  /* Read the Javascript date format value */
            numberOfMonths: 1,
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            },
            onClose: function(selectedDate) {
                $("#fiscal_end").datepicker("option", "minDate", selectedDate);
            }
        });
        $('#fiscal_end').datepicker({
            dateFormat: $("#date_format").val().split('|')[1],  /* Read the Javascript date format value */
            numberOfMonths: 1,
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            },
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