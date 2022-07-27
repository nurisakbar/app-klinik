<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- ./col -->
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('lock_account_title'); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?= form_open(); ?>
            <div class="form-group">
              <input type="hidden" value="0" name="locked">
              <label><input type="checkbox" value="1" name="locked" <?= ($locked) ? 'checked' : '' ?>> <?= lang('lock_account_btn'); ?></label>
              <small><?= lang('lock_account_span'); ?></small>
            </div>
            <div class="form-group">
            <?php
            echo form_submit('submit', 'Submit', array('class'=> 'btn btn-success'));
            ?>
            </div>
          <?= form_close(); ?>
        </div>
      </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->