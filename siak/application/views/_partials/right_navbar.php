  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <div class="box box-solid">
      <div class="box-header with-border">
        <i class=""></i>
        <h3 class="box-title"><?=lang('right_sidebar_menu_activity_log');?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <?php
            if (count($logs) <= 0) {
              echo 'Nothing here.';
            } else {
              echo '<dl class="dl-horizontal">';
              foreach ($logs as $row => $data) {
                if ($row >= 24) {
                  echo "<dd><a href=".base_url('accounts/log')." class='btn btn-default btn-link pull-right'>".lang('right_sidebar_menu_view_all_log').'</a></dd>';
                  break;
                }
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
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <style type="text/css">
    .dl-horizontal{
      overflow: auto;
      /*max-height: 500px;*/
    }
  </style>
