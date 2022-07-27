<!-- <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script> -->
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12">
    <div class="box">
        <div class="box-header">
          <h1 class="box-title"><?= lang('accounts_heading'); ?></h1>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="companylist" class="table table-striped custom-table" width="100%" cellspacing="0">
            <thead>
            <tr>
              <th><?= lang('companylist_table_label'); ?></th>
              <th><?= lang('companylist_table_db_type'); ?></th>
              <th><?= lang('companylist_table_db_name'); ?></th>
              <th><?= lang('companylist_table_db_host'); ?></th>
              <th><?= lang('companylist_table_db_port'); ?></th>
              <th><?= lang('companylist_table_db_prefix'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($accounts) : ?>
            <?php foreach ($accounts as $account) : ?>
              <tr>
                <td><?= $account->label; ?></td>
                <td><?= $account->db_datasource; ?></td>
                <td><?= $account->db_database; ?></td>
                <td><?= $account->db_host; ?></td>
                <td><?= $account->db_port; ?></td>
                <td><?= $account->db_prefix; ?></td>
              </tr>
          <?php endforeach; ?>
          <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
              <th><?= lang('companylist_table_label'); ?></th>
              <th><?= lang('companylist_table_db_type'); ?></th>
              <th><?= lang('companylist_table_db_name'); ?></th>
              <th><?= lang('companylist_table_db_host'); ?></th>
              <th><?= lang('companylist_table_db_port'); ?></th>
              <th><?= lang('companylist_table_db_prefix'); ?></th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->

<script type="text/javascript">
  $(document).ready(function() {

    $.fn.dataTable.ext.buttons.create =
    {
      className: 'btn btn-link',
      id: 'CreateAccountButton',
      text: "<i class='glyphicon glyphicon-plus-sign' style='margin-right: 5px; color: #428BCA;'></i><?= lang('accounts_add_btn'); ?>",
      action: function (e, dt, node, config)
      {
        //This will send the page to the location specified
        window.location.href = 'admin/create_account';
      }
    };

    $('#companylist').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    dom: 'Bfrtip',
      buttons: [
          'create'
      ]
    });

  });
</script>