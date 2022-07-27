<div class="login-box">
  <div style="padding-top: 120px;"></div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- <div class="flash-msg">
      <?php if (validation_errors()) { ?>
        <div class="alert alert-danger">
          <?= validation_errors(); ?>
        </div>
      <?php } ?>
      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-success">
          <?= $_SESSION['message']; ?>
        </div>
      <?php } ?>
      <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
          <?= ($_SESSION['error']); ?>
        </div>
      <?php } ?>
      <?php if (isset($_SESSION['warning'])) { ?>
          <div class="alert alert-warning">
              <?= ($_SESSION['warning']); ?>
          </div>
    <?php } ?>
    </div> -->
    <b><p class="login-box-msg"><?= lang('login_subheading'); ?></p></b>

    <?= form_open('login'); ?>
      <div class="form-group has-feedback">
        <?php echo form_input($identity); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php echo form_input($password); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> <?= lang('login_remember_label'); ?>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?= lang('login_submit_btn'); ?></button>
        </div>
        <!-- /.col -->
      </div>
    <?= form_close(); ?>
  </div>
  <!-- /.login-box-body -->
  <div class="login-logo" style="padding-top: 25px">
    <!-- Nama Perusahaan -->
    <!-- <a href="<?= base_url(); ?>"><?= $settings->sitename; ?></a> -->
    <img src="<?php echo base_url();?>/assets/dist/img/logo.png">
  </div>
  <!-- /.login-logo -->
</div>
<!-- /.login-box -->

  