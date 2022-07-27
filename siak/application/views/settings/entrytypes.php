<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#dynamic-table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            'displayLength': site.msettings.row_count,
            "order": [[0, "asc"]], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?=base_url(); ?>account_settings/getAllET",
                "type": "POST",
            // 'data': {form_data: $('#search_form').serializeArray()}
            },
            "columns": [
                {
                    data: 'label'
                },
                {
                    data: 'name',
                },
                {
                    data: 'description',
                },
                {
                    data: 'prefix'
                },
                {
                    data: 'suffix',
                },
                {
                    data: 'zero_padding',
                },
                {
                    data: 'actions',
                    "orderable": false
                },
            ]
        });

    });

    $(document).on("click", "#delete", function (e) {
        e.preventDefault();

        var num = $(this).data("num");

        $.ajax({
            type: "POST",
            url: "<?=base_url(); ?>" + "account_settings/entrytypes/delete",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data == 'true') {
                    toastr["success"]("<?php echo lang('entrytype_deleted'); ?>", "<?php echo lang('toastr_success_heading'); ?>");
                    $('#dynamic-table').DataTable().ajax.reload();
                } else if ('false') {
                    $(this).tooltip('hide');
                    toastr["error"]("<?php echo lang('entrytype_not_deleted'); ?>", "<?php echo lang('toastr_error_heading'); ?>");
                }                
            }
        });
    });
</script>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">
                        <?php echo lang('entrytypes');?>
                    </h1>
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('actions') ?>" data-placement="left">
                                <i class="fa fa-wrench"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" data-target="#clientmodal" class="add_c">
                                        <i class="fa fa-plus-circle">
                                            <?php echo lang('add_entrytype') ?>
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped custom-table" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th><?= lang('settings_views_entrytypes_thead_label'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_name'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_description'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_prefix'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_suffix'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_zero_padding'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_thead_actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?= lang('settings_views_entrytypes_tfoot_label'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_name'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_description'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_prefix'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_suffix'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_zero_padding'); ?></th>
                                    <th><?= lang('settings_views_entrytypes_tfoot_actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- ./able-responsive -->
                </div>
                <!-- ./box-body -->
            </div>
            <!-- ./box -->
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
</section>

<!-- ============= MODAL MODIFICA CLIENTI ============= -->
<div class="modal fade" id="clientmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titclienti"></h4>
            </div>
            <!-- /.modal-header -->
            <div class="modal-body">
                <div class="panel-body">
                    <form id="myForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_label'); ?></label>
                                    <input name="et_label" id="et_label" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_description'); ?></label>
                                    <input name="description" id="description" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_perfix'); ?></label>
                                    <input name="prefix" id="prefix" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_zero_padding'); ?></label>
                                    <input name="zero_padding" id="zero_padding" type="text" class="form-control" required>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_name'); ?></label>
                                    <input name="et_name" id="et_name" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_numbering'); ?></label>
                                    <select name="numbering" id="numbering" class="select form-control">
                                        <option value="1"><?= lang('settings_views_entrytypes_modal_numbering_option_1'); ?></option>
                                        <option value="2"><?= lang('settings_views_entrytypes_modal_numbering_option_2'); ?></option>
                                        <option value="3"><?= lang('settings_views_entrytypes_modal_numbering_option_3'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_suffix'); ?></label>
                                    <input name="suffix" id="suffix" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label><?= lang('settings_views_entrytypes_modal_label_restrictions'); ?></label>
                                    <select id="restriction_bankcash" name="restriction_bankcash" class="select form-control" required="required">
                                        <option value="1"><?= lang('settings_views_entrytypes_modal_restrictions_option_1'); ?></option>
                                        <option value="2"><?= lang('settings_views_entrytypes_modal_restrictions_option_2'); ?></option>
                                        <option value="3"><?= lang('settings_views_entrytypes_modal_restrictions_option_3'); ?></option>
                                        <option value="4"><?= lang('settings_views_entrytypes_modal_restrictions_option_4'); ?></option>
                                        <option value="5"><?= lang('settings_views_entrytypes_modal_restrictions_option_5'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                    </form>
                    <!-- /#myForm -->
                </div>
                <!-- /.panel-body -->
                <div class="modal-footer" id="footerClient1">
                    
                </div>
                <!-- /.modal-footer -->
            </div>
            <!-- /.modal-body -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    $(".add_c").on("click", function (e) {
        e.preventDefault();

        $('#clientmodal').modal('show');

        $('#myForm').find("input[type=text], .select").val("").trigger('change');

        $('#titclienti').html("<?= lang('add_entrytype');?>");

        $('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i><?= lang('go_back'); ?></button><button role="submit" form="myForm" id="submit" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i><?= lang('add_entrytype'); ?></button>');
    });

    $(document).on("click", "#modify", function (e) {
        e.preventDefault();

        $('#clientmodal').modal('show');

        $('#titclienti').html("<?= lang('edit_entrytype');?>");

        var num = $(this).data("num");

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>account_settings/entrytypes/getByID",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {

                $('#et_label').val(data.label);
                $('#et_name').val(data.name);
                $('#description').val(data.description);
                $('#numbering').val(data.numbering).trigger('change');
                $('#prefix').val(data.prefix);
                $('#suffix').val(data.suffix);
                $('#zero_padding').val(data.zero_padding);
                $('#restriction_bankcash').val(data.restriction_bankcash).trigger('change');

                $('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang('go_back'); ?></button><button role="submit" form="myForm" id="submit" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> <?= lang('update_entrytype');?></button>')
            }
        });
    });

    $("#myForm").submit(function(e) {
        e.preventDefault();

        var mode = $('#submit').data("mode");
        var id = $('#submit').data("num");

        //validate
        var valid = true;

        if (valid) {
            var url = "";
            var dataString = $('form').serialize();

            if (mode == "add") {
                url = "<?= base_url(); ?>" + "account_settings/entrytypes/add";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr["success"]("<?php echo lang('entrytype_added'); ?>", "<?php echo lang('toastr_success_heading'); ?>");

                        setTimeout(function () {
                            $('#clientmodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            } else if (mode == "modify") {
                url = "<?= base_url(); ?>" + "account_settings/entrytypes/edit";
                dataString += "&id=" + encodeURI(id);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr["success"]("<?php echo lang('entrytype_updated'); ?>", "<?php echo lang('toastr_success_heading'); ?>");

                        setTimeout(function () {
                            $('#clientmodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            }
        }
        return false;

    });
</script>