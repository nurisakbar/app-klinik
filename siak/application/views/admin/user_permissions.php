<!-- <script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js"></script> -->
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?=lang('user_permission_heading');?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped custom-table" id="userGroup"  width="100%" cellspacing="0">
              <thead>
                <th><?= lang('user_permission_table_id'); ?></th>
                <th><?= lang('user_permission_table_group'); ?></th>
                <th><?= lang('user_permission_table_action'); ?></th>
              </thead>
              <tbody>
                <?php foreach ($permissions as $key => $permission): ?>
                  <tr>
                    <td><strong><?= $permission->id; ?></strong></td>
                    <td><?= $permission->description; ?></td>
                    <td><a href="<?= base_url(); ?>admin/delete_group/<?= $permission->gp_id; ?>"><i class="glyphicon glyphicon-trash pull-right" style="padding-right: 5px;" data-toggle="tooltip" title="<?=lang('user_permission_delete_group_tooltip');?>"></i></a><a href="<?= base_url(); ?>admin/edit_group/<?= $permission->gp_id; ?>"><i class="glyphicon glyphicon-edit pull-right" style="padding-right: 5px;" data-toggle="tooltip" title="<?=lang('user_permission_edit_group_tooltip');?>"></i></a><a href="<?= base_url(); ?>admin/edit_permission/<?= $permission->gp_id; ?>"><i class="glyphicon glyphicon-cog pull-right" style="padding-right: 5px;" data-toggle="tooltip" title="<?=lang('user_permission_edit_group_permission_tooltip');?>"></i></a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
             <tfoot>
                <th><?= lang('user_permission_table_id'); ?></th>
                <th><?= lang('user_permission_table_group'); ?></th>
                <th><?= lang('user_permission_table_action'); ?></th>
              </tfoot>
            </table>
        </div>
      </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function() {

      $.fn.dataTable.ext.buttons.create =
      {
        className: 'btn btn-link',
        id: 'CreateGroupButton',
        text: "<i class='fa fa-users' style='margin-right: 5px; color: #428BCA;'></i><?=lang('user_permission_add_group_btn');?>",
        action: function (e, dt, node, config)
        {
          //This will send the page to the location specified
          window.location.href = 'admin/create_group';
        }
      };

      $('#userGroup').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      dom: 'Bfrtip',
        buttons: [
            'create',
        ],
      "columnDefs": [
        { "width": "10px", "targets": 0 },
        { "width": "20px", "targets": 2 }
      ]
      });
    });
</script>