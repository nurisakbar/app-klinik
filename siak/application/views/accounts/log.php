<!-- Main content -->
<section class="content">

  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-history"></i>

      <h3 class="box-title"><?=lang('accounts_log_heading');?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <?php
        if (count($logs) <= 0) {
          echo lang('no_records_found');
        } else {
          echo '<dl class="dl-horizontal">';
          foreach ($logs as $row => $data) {
            echo '<dt>' . $data['date'] . '</dt>';
            echo '<dd>' . $data['message'] . '</dd>';
          }
          echo '</dl>';
        }
      ?>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->