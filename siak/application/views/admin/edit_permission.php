<style type="text/css">
  label {
    margin-right: 10px;
    padding: 5px;
  }
</style>
<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=lang('edit_permission_heading');?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?= form_open(); ?>
                <input type="hidden" name="group_id" value="<?= $group_id; ?>">                                   
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                      <tr>
                          <th rowspan="2" class="text-center"><?=lang('edit_permission_module_name_label');?></th>
                          <th colspan="5" class="text-center"><?=lang('edit_permission_permissions_label');?></th>
                      </tr>
                      <tr>
                          <th class="text-center"><?=lang('edit_permission_view_label');?></th>
                          <th class="text-center"><?=lang('edit_permission_add_label');?></th>
                          <th class="text-center"><?=lang('edit_permission_edit_label');?></th>
                          <th class="text-center"><?=lang('edit_permission_delete_label');?></th>
                          <th class="text-center"><?=lang('edit_permission_miscellaneous_label');?></th>
                      </tr>
                      </thead>
                      <tbody>
                      

                      <tr>
                          <td><?=lang('edit_permission_accounts_label');?></td>
                          <td class="text-center">
                              <input type="hidden" name="accounts-index" value="0">                                   
                              <input type="checkbox" name="accounts-index" id="checkall_ledgers_groups" value="1" <?= ($permission['accounts-index'] == 1) ? 'checked' : '' ?>>
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                            <input type="hidden" name="admin-log" value="0">                                   
                            <label><input type="checkbox" name="admin-log" value="1" <?= ($permission['admin-log'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_admin_log_label');?></label>
                          </td>
                      </tr>

                      <tr>
                          <td><?=lang('edit_permission_dashboard_label');?></td>
                          <td class="text-center">
                              <input type="hidden" name="dashboard-index" value="0">                                   
                              <input type="checkbox" name="dashboard-index" value="1" <?= ($permission['dashboard-index'] == 1) ? 'checked' : '' ?>>                                   
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                            <input type="hidden" name="search-index" value="0">                                   
                            <label><input type="checkbox" name="search-index" value="1" <?= ($permission['search-index'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_search_index_label');?></label>
                          </td>
                      </tr>

                      <tr>
                          <td><?=lang('edit_permission_entries_label');?></td>
                          <td class="text-center">
                              <input type="hidden" name="entries-index" value="0">                                   
                              <input type="checkbox" name="entries-index" id="checkall_entries" value="1" <?= ($permission['entries-index'] == 1) ? 'checked' : '' ?>>                   
                          </td>
                        <!-- <div id="entries"> -->
                          <td class="text-center">
                              <input type="hidden" name="entries-add" value="0">                                   

                              <input type="checkbox" name="entries-add" value="1" class="entries" <?= ($permission['entries-add'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="entries-edit" value="0">                                   

                              <input type="checkbox" name="entries-edit" value="1" class="entries" <?= ($permission['entries-edit'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="entries-delete" value="0">                                   

                              <input type="checkbox" name="entries-delete" value="1" class="entries" <?= ($permission['entries-delete'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="entries-view" value="0">                                   
                              <label><input type="checkbox" name="entries-view" value="1" class="entries" <?= ($permission['entries-view'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_entries_view_single_entry_label');?></label>
                          </td>
                        <!-- </div> -->
                      </tr>

                      <tr>
                          <td><?=lang('edit_permission_groups_label');?></td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="groups-add" value="0">                                   
                              <input type="checkbox" name="groups-add" value="1" class="groups" <?= ($permission['groups-add'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="groups-edit" value="0">                                   
                              <input type="checkbox" name="groups-edit" value="1" class="groups" <?= ($permission['groups-edit'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="groups-delete" value="0">                                   
                              <input type="checkbox" name="groups-delete" value="1" class="groups" <?= ($permission['groups-delete'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td>
                          </td>
                      </tr>

                      <tr>
                          <td><?=lang('edit_permission_ledgers_label');?></td>
                          <td class="text-center">
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="ledgers-add" value="0">                                   

                              <input type="checkbox" name="ledgers-add" value="1" class="ledgers" <?= ($permission['ledgers-add'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="ledgers-edit" value="0">                                   

                              <input type="checkbox" name="ledgers-edit" value="1" class="ledgers" <?= ($permission['ledgers-edit'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="ledgers-delete" value="0">                                   

                              <input type="checkbox" name="ledgers-delete" value="1" class="ledgers" <?= ($permission['ledgers-delete'] == 1) ? 'checked' : '' ?>>                                    
                          </td>
                          <td>
                          </td>
                      </tr>
                      <tr>
                          <td><?=lang('edit_permission_account_settings_label');?></td>
                          <td colspan="5">
                              <input type="hidden" name="account_settings-index" value="0">                                   
                              <label><input type="checkbox" name="account_settings-index" id="checkall_account_settings" value="1" <?= ($permission['account_settings-index'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_index_label');?></label>

                              <input type="hidden" name="account_settings-main" value="0">
                              
                              <div id="account_settings">
                                <label><input type="checkbox" name="account_settings-main" value="1" <?= ($permission['account_settings-main'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_main_label');?></label>

                                <input type="hidden" name="account_settings-cf" value="0">                                   
                                <label><input type="checkbox" name="account_settings-cf" value="1" <?= ($permission['account_settings-cf'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_cf_label');?></label>

                                <input type="hidden" name="account_settings-email" value="0">                                   
                                <label><input type="checkbox" name="account_settings-email" value="1" <?= ($permission['account_settings-email'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_email_label');?></label>

                                <input type="hidden" name="account_settings-printer" value="0">                                   
                                <label><input type="checkbox" name="account_settings-printer" value="1" <?= ($permission['account_settings-printer'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_printer_label');?></label>

                                <input type="hidden" name="account_settings-tags" value="0">                                   
                                <label><input type="checkbox" name="account_settings-tags" value="1" <?= ($permission['account_settings-tags'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_tags_label');?></label>

                                <input type="hidden" name="account_settings-entrytypes" value="0">
                                <label><input type="checkbox" name="account_settings-entrytypes" value="1" <?= ($permission['account_settings-entrytypes'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_entrytypes_label');?></label>

                                <input type="hidden" name="account_settings-lock" value="0">                                   
                                <label><input type="checkbox" name="account_settings-lock" value="1" <?= ($permission['account_settings-lock'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_account_settings_lock_label');?></label>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td><?=lang('edit_permission_report_label');?></td>
                          <td colspan="5">
                              <span style="inline-block">
                                  <input type="hidden" name="reports-index" value="0">
                                  <label><input type="checkbox" name="reports-index" id="checkall_reports" value="1" <?= ($permission['reports-index'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_index_label');?></label>
                              </span>
                              <div id="reports">
                                <span style="inline-block">
                                    <input type="hidden" name="reports-balancesheet" value="0">
                                    <label><input type="checkbox" name="reports-balancesheet" value="1" <?= ($permission['reports-balancesheet'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_balancesheet_label');?></label>
                                </span>
                                <span style="inline-block">
                                    <input type="hidden" name="reports-profitloss" value="0">
                                    <label><input type="checkbox" name="reports-profitloss" value="1" <?= ($permission['reports-profitloss'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_profitloss_label');?></label>
                                </span>
                                <span style="inline-block">
                                    <input type="hidden" name="reports-trialbalance" value="0">
                                     <label><input type="checkbox" name="reports-trialbalance" value="1" <?= ($permission['reports-trialbalance'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_trialbalance_label');?></label>
                                </span>
                                <span style="inline-block">
                                    <input type="hidden" name="reports-ledgerstatement" value="0">
                                    <label><input type="checkbox" name="reports-ledgerstatement" value="1" <?= ($permission['reports-ledgerstatement'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_ledger_statement_label');?></label>
                                </span>
                                <span style="inline-block">
                                    <input type="hidden" name="reports-ledgerentries" value="0">
                                    <label><input type="checkbox" name="reports-ledgerentries" value="1" <?= ($permission['reports-ledgerentries'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_ledger_entries_label');?></label>
                                </span>
                                <span style="inline-block">
                                    <input type="hidden" name="reports-reconciliation" value="0">
                                    <label><input type="checkbox" name="reports-reconciliation" value="1" <?= ($permission['reports-reconciliation'] == 1) ? 'checked' : '' ?>><?=lang('edit_permission_report_reconciliation_label');?></label>
                                </span>
                              </div>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
              <input type="submit" value="<?=lang('submit');?>" class="btn btn-primary">
              <?= form_close(); ?>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <script type="text/javascript">
      $(document).ready(function() {

        $('#checkall_reports').on('ifClicked', function(event){
          var checked = $(this).prop('checked');

          if (!checked) {
            $('#reports [type=checkbox]').iCheck('check');
          }else{

          }
          if(checked){
            $('#reports [type=checkbox]').iCheck('uncheck');
          }
        });

        $('#reports [type=checkbox]').on('ifChanged', function(event){
          var numOfCheckedCheckboxes = $('#reports [type=checkbox]:checked').length;
          if (numOfCheckedCheckboxes == 0){
            $('#checkall_reports').iCheck('uncheck');
          }else{
            $('#checkall_reports').iCheck('check');
          }
        });

        $('#checkall_account_settings').on('ifClicked', function(event){
          var checked = $(this).prop('checked');

          if (!checked) {
            $('#account_settings [type=checkbox]').iCheck('check');
          }else{

          }
          if(checked){
            $('#account_settings [type=checkbox]').iCheck('uncheck');
          }
        });

        $('#account_settings [type=checkbox]').on('ifChanged', function(event){
          var numOfCheckedCheckboxes = $('#account_settings [type=checkbox]:checked').length;
          if (numOfCheckedCheckboxes == 0){
            $('#checkall_account_settings').iCheck('uncheck');
          }else{
            $('#checkall_account_settings').iCheck('check');
          }
        });

        $('#checkall_entries').on('ifClicked', function(event){
          var checked = $(this).prop('checked');

          if (!checked) {
            $('.entries').iCheck('check');
          }else{

          }
          if(checked){
            $('.entries').iCheck('uncheck');
          }
        });

        $('.entries').on('ifChanged', function(event){
          var numOfCheckedCheckboxes = $('input:checkbox.entries:checked').length;
          if (numOfCheckedCheckboxes == 0){
            $('#checkall_entries').iCheck('uncheck');
          }else{
            $('#checkall_entries').iCheck('check');
          }
        });

        $('#checkall_ledgers_groups').on('ifClicked', function(event){
          var checked = $(this).prop('checked');

          if (!checked) {
            $('.ledgers, .groups').iCheck('check');
          }else{

          }
          if(checked){
            $('.ledgers, .groups').iCheck('uncheck');
          }
        });

        $('.ledgers, .groups').on('ifChanged', function(event){
          var numOfCheckedCheckboxes = $('input:checkbox.ledgers:checked').length + $('input:checkbox.groups:checked').length;
          if (numOfCheckedCheckboxes == 0){
            $('#checkall_ledgers_groups').iCheck('uncheck');
          }else{
            $('#checkall_ledgers_groups').iCheck('check');
          }
        });
      })
    </script>