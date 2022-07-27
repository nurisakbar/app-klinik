<section class="content">
  <div class="box">
    <div class="box-header">
      <h1><?php echo lang('create_user_heading');?></h1>
      <p><?php echo lang('create_user_subheading');?></p>
    </div>
    <!-- /.box-header -->
    <?php echo form_open_multipart("admin/create_user");?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <p>
              <?php echo lang('create_user_fname_label', 'first_name');?> <br />
              <?php echo form_input($first_name);?>
            </p>
            <p>
              <?php echo lang('create_user_lname_label', 'last_name');?> <br />
              <?php echo form_input($last_name);?>
            </p>
            <p>
              <?php echo lang('create_user_company_label', 'company');?> <br />
              <?php echo form_input($company);?>
            </p>
            <p>
              <?php echo lang('create_user_phone_label', 'phone');?> <br />
              <?php echo form_input($phone);?>
            </p>
          </div>
          <!-- /.col-md-4 -->
          <div class="col-md-4">
            <p>
              <?php echo lang('create_user_email_label', 'email');?> <br />
              <?php echo form_input($email);?>
            </p>
            <p>
              <?php echo lang('create_user_username_label', 'username');?> <br />
              <?php echo form_input($username);?>
            </p>
            <p>
              <?php echo lang('create_user_password_label', 'password');?> <br />
              <?php echo form_input($password);?>
            </p>
            <p>
              <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
              <?php echo form_input($password_confirm);?>
            </p>
          </div>
          <!-- /.col-md-4 -->
          <div class="col-md-4">
            <h3><?php echo lang('edit_user_groups_heading');?></h3>
            <?php foreach ($groups as $group):?>
              <label class="radio">
              <input type="radio" name="groups" value="<?php echo $group['id'];?>" required>
              <?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?>
              </label>
            <?php endforeach?>
          </div>
          <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-6">
            <div>
              <h3><?=lang('create_user_accessibleAccounts_label');?></h3>
              <select class="form-control" name="accounts[]" id="accessibleAccounts" multiple required>
              <option value="all"><?=lang('create_user_accessibleAccounts_frst_option');?></option>
              <?php foreach ($accounts as $account):?>
                <option value="<?= $account->id; ?>"><?= ($account->label); ?></option>
              <?php endforeach?>
            </select>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-md-6">
            <div style="margin: 20px;">
              <h3><?=lang('create_user_uploadprofilepicture_label');?></h3>
              <input type="file" name="uploadprofilepicture" id="uploadprofilepicture">
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right"><?=lang('create_user_submit_btn');?></button>
        <a href="<?= base_url(); ?>admin/users/" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('create_user_cancel_btn');?></a>
      </div>
      <!-- /.box-footer -->
    <?php echo form_close();?>
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
<script type="text/javascript">
$('#accessibleAccounts').select2({
    placeholder: "<?=lang('create_user_accessibleAccounts_placeholder');?>"
  });
</script>
