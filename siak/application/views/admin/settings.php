<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?= $page_title; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open('admin/settings'); ?>
              <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sitename"><?= lang('admin_settings_sitename_label'); ?></label>
                    <input type="text" class="form-control" id="sitename" name="sitename" value="<?= $settings->sitename;?>" placeholder="<?=lang('admin_settings_sitename_placeholder');?>">
                  </div>
                  <div class="form-group">
                    <?=lang('language', 'language');?>
                    <?php $scanned_lang_dir = array_map(function ($path) {
                        return basename($path);
                    }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                    ?>
                    <select id="language" name="language" class="form-control" style="width: 100%">
                      <?php foreach ($scanned_lang_dir as $dir):
                        $language = basename($dir); ?>
                        <option value="<?= $language; ?>" <?= ($language == $settings->language) ? 'selected' : '' ?>><?= $language; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <?php
                    $date_format = array(
                      'd-M-Y|dd-M-yy|dd-MMM-yyyy' => lang('date_format_option_1'),
                      'M-d-Y|M-dd-yy|MMM-dd-yyyy' => lang('date_format_option_2'),
                      'Y-M-d|yy-M-dd|yyyy-MMM-dd' => lang('date_format_option_3')
                    );
                    ?>
                    <label for="date_format"><?= lang('admin_settings_date_format_label'); ?></label>
                    <?php
                    echo form_dropdown('date_format', $date_format, set_value('date_format', $settings->date_format) ,array('class'=>'form-control', 'id'=>'SettingDateFormat'));
                    ?>
                  </div>
                  <div class="form-group">
                    <?php
                    $entry_form = array(
                      '0' => lang('admin_settings_entry_form_1'),
                      '1' => lang('admin_settings_entry_form_2'),
                    );
                    ?>
                    <label for="date_format"><?= lang('admin_settings_entry_form_label'); ?></label>
                    <?php
                    echo form_dropdown('entry_form', $entry_form, set_value('entry_form', $settings->entry_form) ,array('class'=>'form-control', 'id'=>'EntryFormType'));
                    ?>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="in_entries_use"><?=lang('admin_settings_in_entries_use_label');?></label>
                          <div class="input-group">
                            <select name="in_entries_use" class="form-control" id="in_entries_use" >
                              <option value="drcr" <?= ($settings->drcr_toby == 'drcr') ? "selected" : "" ?>><?=lang('admin_settings_in_entries_use_option_1');?></option>
                              <option value="toby" <?= ($settings->drcr_toby == 'toby') ? "selected" : "" ?>><?=lang('admin_settings_in_entries_use_option_2');?></option>
                            </select>
                            <div class="input-group-addon">
                              <i>
                                <div class="fa fa-info-circle" data-toggle="tooltip" title="<?=lang('admin_settings_in_entries_use_tooltip');?>">
                                </div>
                              </i>
                            </div>
                          </div>
                          <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
                    </div>
                    <div class="col-md-7">
                      <div class="form-group" style="padding-top: 30px;">
                        <div class="input-group">
                          <label><input type="checkbox" name="enable_logging" <?= ($settings->enable_logging) ? "checked" : "" ?>><?= lang('admin_settings_enable_logging_label'); ?></label>
                          <div class="input-group-addon">
                            <i>
                              <div class="fa fa-info-circle" data-toggle="tooltip" title="<?= lang('admin_settings_enable_logging_tooltip'); ?>">
                              </div>
                            </i>
                          </div>
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="rows_per_table"><?= lang("rows_per_table"); ?></label>
                    <?php
                      $rptopts = array('-1' => lang('all').' ('.lang('not_recommended').')', '10' => '10', '25' => '25', '50' => '50',  '100' => '100',);
                      echo form_dropdown('rows_per_table', $rptopts, $settings->row_count, 'id="rows_per_table" class="form-control select" style="width:100%;" required="required" placeholder="'.lang('select_rows').'"');
                    ?>
                  </div>
                </div>
              </div>
                <h2><?=lang('admin_settings_email_settings_heading');?></h2>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email_protocol"><?=lang('admin_settings_email_protocol_label');?></label>
                      <select name="email_protocol" class="form-control">
                        <option value="smtp" <?= ($settings->email_protocol == 'smtp') ? "selected" : "" ?>><?=lang('admin_settings_email_protocol_option_1');?></option>
                        <option value="mail" <?= ($settings->email_protocol == 'mail') ? "selected" : "" ?>><?=lang('admin_settings_email_protocol_option_2');?></option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="smtp_username"><?=lang('admin_settings_smtp_username_label');?></label>
                      <input type="text" class="form-control" id="smtp_username" value="<?= $settings->smtp_username ?>" name="smtp_username" placeholder="<?=lang('admin_settings_smtp_username_placeholder');?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="smtp_host"><?=lang('admin_settings_smtp_host_label');?></label>
                      <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?= $settings->smtp_host ?>" placeholder="<?=lang('admin_settings_smtp_host_placeholder');?>">
                    </div>
                    <div class="form-group">
                      <label for="smtp_password"><?=lang('admin_settings_smtp_password_label');?></label>
                      <input type="text" class="form-control" id="smtp_password" value="<?= $settings->smtp_password ?>" name="smtp_password" placeholder="<?=lang('admin_settings_smtp_password_placeholder');?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="smtp_port"><?=lang('admin_settings_smtp_port_label');?></label>
                          <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="<?= $settings->smtp_port ?>" placeholder="<?=lang('admin_settings_smtp_port_placeholder');?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="padding-top: 30px;">
                          <label><input type="checkbox" name="smtp_tls" <?= ($settings->smtp_tls) ? "checked" : "" ?>> <?=lang('admin_settings_smtp_tls_label');?></label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email_from"><?=lang('admin_settings_email_from_label');?></label>
                      <input type="text" class="form-control" id="email_from" value="<?= $settings->email_from ?>" name="email_from"  name="email_from" placeholder="<?=lang('admin_settings_email_from_placeholder');?>">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?=lang('update');?></button>
                <a style="margin-right: 5px;" href="<?= base_url(); ?>admin/" id="cancel" name="cancel" class="btn btn-default pull-right"><?=lang('admin_settings_cancel_btn');?></a>
              </div>
            <?= form_close(); ?>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->