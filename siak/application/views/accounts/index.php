<!-- <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script> -->

<?php

  function print_account_chart($account, $c = 0, $THIS) {
    $CI =& get_instance();

    $counter = $c;
    /* Print groups */
    if ($account->id != 0) {
      if ($account->id <= 4) {
        echo '<tr class="tr-group tr-root-group">';
      } else {
        echo '<tr class="tr-group">';
      }
      echo '<td>';
      echo print_space($counter);
      echo $account->code;
      echo '</td>';
      echo '<td class="td-group">';
      echo print_space($counter);
      echo $account->name;
      echo '</td>';

      echo '<td>'.lang('accounts_index_td_label_group').'</td>';

      echo '<td style="text-align:center;">-</td>';
      echo '<td style="text-align:center;">-</td>';

      /* If group id less than 4 dont show edit and delete links */
      if ($account->id <= 4) {
        echo '<td class="td-actions"></td>';
      } else {
        echo '<td class="td-actions">';
        echo anchor('groups/edit/'.$account->id, '<i class="glyphicon glyphicon-edit"></i>'.lang('accounts_index_edit_btn'), array('class' => 'no-hover font-normal', 'escape' => false));
        echo "<span class='link-pad'></span>";

        echo anchor('groups/delete/'.$account->id, '<i class="glyphicon glyphicon-trash"></i>'.lang('accounts_index_delete_btn'), 
            array('class' => 'no-hover font-normal',
                  'escape' => false,
                  'confirm' => lang('accounts_index_delete_group_alert'))
        );

        echo '</td>';
      }
      echo '</tr>';
    }

    /* Print child ledgers */
    if (count($account->children_ledgers) >= 1) {
      $counter++;
      foreach ($account->children_ledgers as $id => $data) {
        echo '<tr class="tr-ledger">';
        echo '<td class="td-ledger">';
        echo print_space($counter);
        echo anchor('reports/ledgerstatement/ledgerid/'.$data['id'], $data['code']);
        echo '</td>';
        echo '<td class="td-ledger">';
        echo print_space($counter);
        //to change later
        echo anchor('reports/ledgerstatement/ledgerid/'.$data['id'], $data['name']); 
        echo '</td>';
        echo '<td>'.lang('accounts_index_td_label_ledger').'</td>';

        echo '<td style="text-align:right">';
        echo $CI->functionscore->toCurrency($data['op_total_dc'], $data['op_total']);
        echo '</td>';

        echo '<td style="text-align:right">';
        echo $CI->functionscore->toCurrency($data['cl_total_dc'], $data['cl_total']);
        echo '</td>';

        echo '<td class="td-actions">';
        echo anchor('ledgers/edit/'.$data['id'], '<i class="glyphicon glyphicon-edit"></i>'.lang('accounts_index_edit_btn'), 
            array('class' => 'no-hover', 'escape' => false)
        );
        echo "<span class='link-pad'></span>";
        echo anchor('ledgers/delete/'.$data['id'], '<i class="glyphicon glyphicon-trash"></i>'.lang('accounts_index_delete_btn'), 
            array('class' => 'no-hover', 'escape' => false, 'confirm' => (lang('accounts_index_delete_ledger_alert')))
        );
        echo '</tr>';
      }
      $counter--;
    }
    
    /* Print child groups recursively */
    foreach ($account->children_groups as $id => $data) {
      $counter++;
      print_account_chart($data, $counter, $THIS);
      $counter--;
    }
  }

  function print_space($count) {
    $html = '';
    for ($i = 1; $i <= $count; $i++) {
      $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    return $html;
  }

?>
<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php if ($this->functionscore->calculate($opdiff['opdiff_balance'], 0, '!=')) {
        echo '<div><div role="alert" class="alert alert-danger">' .
          sprintf(lang('accounts_index_label_difference_bw_balance'), $this->functionscore->toCurrency($opdiff['opdiff_balance_dc'], $opdiff['opdiff_balance'])) .
          
          '</div></div>';
      }; ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?= lang('accounts_index_heading'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php
                echo '<table id="ledgertable" class="stripped">';
                echo '<thead>';
                echo '<th>' . (lang('accounts_index_account_code')) . '</th>';
                echo '<th>' . (lang('accounts_index_account_name')) . '</th>';
                echo '<th>' . (lang('type')) . '</th>';
                echo '<th>' . (lang('accounts_index_op_balance')) . ' (' .$this->mAccountSettings->currency_symbol. ')' . '</th>';
                echo '<th>' . (lang('accounts_index_cl_balance')) . ' (' .$this->mAccountSettings->currency_symbol. ')' . '</th>';
                echo '<th>' . (lang('actions')) . '</th>';
                echo '</thead>';
                echo "<tbody>";
                print_account_chart($accountlist, -1, $this);
                echo "</tbody>";
                echo '</table>';
              ?>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<script type="text/javascript">
  $.fn.dataTable.ext.buttons.creategroup =
  {
    className: 'btn btn-link',
    id: 'CreateGroupButton',
    text: "<i class='glyphicon glyphicon-plus-sign' style='margin-right: 5px; color: #428BCA;'></i><?= lang('accounts_index_add_group_btn'); ?>",
    action: function (e, dt, node, config)
    {
      //This will send the page to the location specified
      window.location.href = '<?= base_url(); ?>groups/add';
    }
  };

  $.fn.dataTable.ext.buttons.createledger =
  {
    className: 'btn btn-link',
    id: 'CreateLedgerButton',
    text: "<i class='glyphicon glyphicon-plus-sign' style='margin-right: 5px; color: #428BCA;'></i><?= lang('accounts_index_add_ledger_btn'); ?>",
    action: function (e, dt, node, config)
    {
      //This will send the page to the location specified
      window.location.href = '<?= base_url(); ?>ledgers/add';
    }
  };

  // $.fn.dataTable.ext.buttons.csv =
  // {
  //   extend: 'csvHtml5',
  //   text: '<i class="fa fa-file-text-o" style="margin-right: 5px; color: #428BCA;"></i><?= lang('accounts_index_export_to_csv_btn'); ?>',
  //   className: 'btn btn-link',
  //   titleAttr: '<?= lang('accounts_index_export_to_csv_btn'); ?>',
  //   title: "<?= $this->session->userdata('active_account')->label; ?>",
  //   exportOptions: {
  //     columns: ':not(:last-child)',
  //   }
  // };
  
  $.fn.dataTable.ext.buttons.excel =
  {
    extend: 'excelHtml5',
    text: '<i class="glyphicon glyphicon-export" style="margin-right: 5px; color: #428BCA;"></i><?= lang('export_xls'); ?>',
    className: 'btn btn-link',
    titleAttr: '<?= lang('export_xls'); ?>',
    title: "<?= $this->session->userdata('active_account')->label; ?>",
    exportOptions: {
      columns: ':not(:last-child)',

    }
  };

  $.fn.dataTable.ext.buttons.import =
  {
    className: 'btn btn-link',
    id: 'ImportToCSV',
    text: "<i class='glyphicon glyphicon-import' style='margin-right: 5px; color: #428BCA;'></i><?= lang('accounts_index_import_from_csv_btn'); ?>",
    action: function (e, dt, node, config)
    {
      //This will send the page to the location specified
      window.location.href = '<?= base_url(); ?>accounts/uploader';
    }
  };


  var ledgertable = $('#ledgertable').DataTable({
    "paging": false,
    "lengthChange": true,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    dom: 'Bfrtip',
    buttons: 
    [
      'creategroup',
      'createledger',
      'import',
      'excel',
    ],
    columnDefs: [
      { targets: [0], ordering: true},
    ],
    "order": [[ 0, "desc" ]]
  });
  // ledgertable.order([0, 'asc']).draw();
</script>