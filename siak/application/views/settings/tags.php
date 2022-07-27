<script type="text/javascript">
    $(function() {
        $('#cp_background').colorpicker();
        $('#cp_color').colorpicker();
    });

    function color(x){
        return '<button class="btn btn-sm" data-toggle="tooltip" title="'+((x === 'ffffff') ? 'White' : (x === '000000') ? 'Black' : '#'+x)+'" style="height:20px; '+((x === 'ffffff') ? 'border: 1px solid #000000;' : 'border: 1px solid #ffffff;')+' background-color: #'+x+'"></button>'
    }

    $(document).ready(function () {
        $("#tag_color").focus(function(e) {
            $('#cp_color').colorpicker('show');
        });

        $("#tag_bg").focus(function(e) {
            $('#cp_background').colorpicker('show');
        });

        var oTable = $('#dynamic-table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            'displayLength': site.msettings.row_count,
            "order": [[0, "asc"]], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?=base_url(); ?>account_settings/getAllTags",
                "type": "POST",
            },
            "columns": [
                {
                    data: 'title'
                },
                {
                    data: 'color',
                    "render": color
                },
                {
                    data: 'background',
                    "render": color
                },
                {
                    data: 'actions',
                    "orderable": false
                },
            ]
        });      
    });

    jQuery(document).on("click", "#delete", function (e) {
        e.preventDefault();
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: "<?=base_url(); ?>" + "account_settings/tags/delete",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data == 'true') {
                    toastr["success"]("<?php echo lang('tag_deleted'); ?>", "<?php echo lang('toastr_success_heading'); ?>");
                    $('#dynamic-table').DataTable().ajax.reload();
                } else {
                    $(this).tooltip('hide');
                    toastr["error"]("<?php echo lang('tag_not_deleted'); ?>", "<?php echo lang('toastr_error_heading'); ?>");
                }
                
            }
        });
    });
</script>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h1 class="box-title"><?php echo lang('tags');?></h1>
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                          <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('actions') ?>" data-placement="left">
                            <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" data-target="#clientmodal" class="add_c">
                                        <i class="fa fa-plus-circle">
                                            <?php echo lang('add_tag') ?>
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped custom-table" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th><?= lang('tag_name'); ?></th>
                                    <th><?= lang('tag_color'); ?></th>
                                    <th><?= lang('tag_background'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?= lang('tag_name'); ?></th>
                                    <th><?= lang('tag_color'); ?></th>
                                    <th><?= lang('tag_background'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============= MODAL MODIFICA CLIENTI ============= -->
<div class="modal fade" id="clientmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titclienti"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                    <div class="row">
                        <form class="col s12" id="myForm">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('tag_name', 'tag_name'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input name="tag_name" id="tag_name" type="text" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('tag_color', 'tag_color'); ?>
                                    <div id="cp_color" class="input-group colorpicker-component">
                                        <input type="text" name="tag_color" id="tag_color" value="#000" class="form-control"  required />
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('tag_background', 'tag_bg'); ?>
                                    <div id="cp_background" class="input-group colorpicker-component">
                                        <input type="text" name="tag_bg" id="tag_bg" value="#FFF" class="form-control"  required />
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer" id="footerClient1">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(".add_c").on("click", function (e) {
        e.preventDefault();
        $('#clientmodal').modal('show');

        jQuery('#tag_name').val('');
        jQuery('#tag_color').val('');
        jQuery('#tag_bg').val('');

        $('#cp_color').colorpicker('setValue', '#000000');
        $('#cp_background').colorpicker('setValue', '#000000');

        jQuery('#titclienti').html("<?= lang('add_tag'); ?>");

        jQuery('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?php echo lang('go_back'); ?></button><button id="submit" class="btn btn-success" form="myForm" role="submit" data-mode="add"><i class="fa fa-user"></i> <?php echo lang('add_tag'); ?></button>');
    });

    jQuery(document).on("click", "#modify", function (e) {
        e.preventDefault();
        $('#clientmodal').modal('show');
        jQuery('#titclienti').html('<?= lang('edit_tag'); ?>');
        var num = jQuery(this).data("num");
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>account_settings/tags/getByID",
                data: "id=" + encodeURI(num),
                cache: false,
                dataType: "json",
                success: function (data) {
                    jQuery('#tag_name').val(data.title);
                    jQuery('#tag_color').val('#'+data.color);
                    jQuery('#tag_bg').val('#'+data.background);

                    $('#cp_color').colorpicker('setValue', '#'+data.color);
                    $('#cp_background').colorpicker('setValue', '#'+data.background);

                    jQuery('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang('go_back'); ?></button><button id="submit" form="myForm" role="submit" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> <?= lang('update_tag'); ?></button>')
                }
            });
        });

    $("#myForm").submit(function( event ) {
        var mode = jQuery('#submit').data("mode");
        var id = jQuery('#submit').data("num");

        //validate
        var valid = true;

        if (valid) {
            var url = "";
            var dataString = $('form').serialize();
            if (mode == "add") {
                url = "<?= base_url(); ?>" + "account_settings/tags/add";
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr["success"]("<?php echo lang('tag_added'); ?>", "<?php echo lang('toastr_success_heading'); ?>");
                        setTimeout(function () {
                            $('#clientmodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            } else {
                url = "<?= base_url(); ?>" + "account_settings/tags/edit";
                dataString += "&id=" + encodeURI(id);
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr["success"]("<?php echo lang('tag_updated'); ?>", "<?php echo lang('toastr_success_heading'); ?>");
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
