<style type="text/css">
  /* .info-box-icon animation */
  .hover:hover .info-box-icon{
    font-size: 60px;
  }
  .hover .info-box-icon {
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    color: rgba(0, 0, 0, 0.35);
  }
  /* .progress-description position */
  .hover {
    position: relative;
  }
  .progress-description {
    position: absolute;
    margin: 4px 4px;
    left: 95px;
    bottom: 5px;
  }
  /* .progress-description color */
  .hover:hover .progress-description {
    color: rgba(0, 0, 0, 0.50);
  }

  /* .info-box-number animation */
  .hover:hover .info-box-number{
    font-size: 22px;
    color: rgba(0, 0, 0, 0.35);
  }
  .hover .info-box-number {
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
  }

</style>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-4">
      <!-- Custom Info Boxes By Omar Sher -->
      <a href="<?= base_url('admin/create_account');?>" style="color: white;">
        <div class="info-box bg-aqua hover">
          <span class="info-box-icon"><i class="fa fa-plus-square"></i></span>
          <div class="info-box-content">
            <span class="info-box-number"><?= lang('dashboard_create_account_label'); ?></span>
            <span class="progress-description"><?= lang('dashboard_create_account_label_description'); ?><i class="fa fa-arrow-circle-right"></i></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </a>
      <!-- /.admin/create_account -->
      <a href="<?= base_url('admin/accounts');?>" style="color: white;">
        <div class="info-box bg-green hover">
          <span class="info-box-icon"><i class="ion ion-stats-bars"></i></span>
          <div class="info-box-content">
            <span class="info-box-number"><?= lang('dashboard_manage_account_label'); ?></span>
            <span class="progress-description"><?= lang('dashboard_manage_account_label_description'); ?><i class="fa fa-arrow-circle-right"></i></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </a>
      <!-- /.admin/accounts -->
      <a href="<?= base_url('admin/users');?>" style="color: white;">
        <div class="info-box bg-yellow hover">
          <span class="info-box-icon"><i class="ion ion-person"></i></span>
          <div class="info-box-content">
            <span class="info-box-number"><?= lang('dashboard_manage_user_label'); ?></span>
            <span class="progress-description"><?= lang('dashboard_manage_user_label_description'); ?><i class="fa fa-arrow-circle-right"></i></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </a>
      <!-- /.admin/user -->
      <a href="<?= base_url('admin/settings');?>" style="color: white;">
        <div class="info-box bg-red hover">
          <span class="info-box-icon"><i class="fa fa-cogs"></i></span>
          <div class="info-box-content">
            <span class="info-box-number"><?= lang('dashboard_general_settings_label'); ?></span>
            <span class="progress-description"><?= lang('dashboard_general_settings_label_description'); ?><i class="fa fa-arrow-circle-right"></i></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </a>
      <!-- /.admin/settings -->     
    </div>
    <!-- ./col-md-4 -->
    <div class="col-md-8">
      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('dashboard_accountlist_table_heading'); ?></h3>
          <p class="pull-right" style="padding-right: 50px;">
            <strong><?= lang('dashboard_accountlist_table_sub_heading') ?><em style="font-size: 18px; padding-left: 30px">"(<?= (isset($_SESSION['active_account'])) ? $_SESSION['active_account']->label : lang('dashboard_accountlist_table_sub_heading_option');?>)"</em></strong>
          </p>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive" style="max-height: 300px;">
            <table id="accounts" class="table table-striped table-hover custom-table">
              <thead>
                <tr>
                  <th><?= lang('dashboard_accountlist_table_label'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_name'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_fiscal_year'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_status'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($accounts) {
                  foreach ($accounts as $account) {
                    $href = base_url()."user/activate/".$account->id;
                    if ($active_account_id == $account->id) {
                      $href = base_url()."user/deactivate/".$account->id;
                      if ($account->account_locked == 1) {
                        $label = lang('dashboard_accountlist_table_status_label_active_locked');
                        $title = lang('dashboard_accountlist_table_status_tooltip_title_active_locked');
                        $class = 'label label-warning';
                      }else{
                        $label = lang('dashboard_accountlist_table_status_label_active');
                        $title = lang('dashboard_accountlist_table_status_tooltip_title_active');
                        $class = 'label label-success';
                      }
                    }elseif ($account->account_locked == 1) {
                      $label = lang('dashboard_accountlist_table_status_label_locked_inactive');
                      $title = lang('dashboard_accountlist_table_status_tooltip_title_locked_inactive');
                      $class = 'label label-danger';
                    }else{
                      $label = lang('dashboard_accountlist_table_status_label_inactive');
                      $title = lang('dashboard_accountlist_table_status_tooltip_title_inactive');
                      $class = 'label label-default';
                    }
                ?>
                  <tr>
                    <td><?= "<em>".$account->label."</em>"; ?></td>
                    <td><?= $account->name; ?></td>
                    <td>
                      <?= "<strong>".$this->functionscore->dateFromSql($account->fy_start).lang('dashboard_accountlist_table_fiscal_year_to').$this->functionscore->dateFromSql($account->fy_end)."</strong>"; ?>
                    </td>
                    <td data-toggle="tooltip" data-container="body" title="<?= $title; ?>">
                      <a href="<?= $href; ?>"><span class="<?= $class; ?>"><?= $label; ?></span></a>
                    </td>                    
                  </tr>
                <?php } } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th><?= lang('dashboard_accountlist_table_label'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_name'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_fiscal_year'); ?></th>
                  <th><?= lang('dashboard_accountlist_table_status'); ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <p style="font-size: 18px;"><?= lang('dashboard_accountlist_table_note'); ?></p>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- ./col-md-8 -->    
  </div>
  <!-- ./row --> 
</section>
<!-- /.content -->
<script>
  $(document).ready(function() {
    var datatables = $('#accounts').DataTable( {
        "scrollY":        "160px",
        "scrollCollapse": true,
        "paging":         false,
        "info":           false,
        "searching":      true,
        "autoWidth":      true
    });
    $(".sidebar-toggle").click(function() {
      setTimeout(function() {
        datatables.columns.adjust().draw();    
      },310);
    });
    $( ".main-sidebar" ).hover(function() {
      setTimeout(function() {
        datatables.columns.adjust().draw();    
      },310);
    });
  });
</script>