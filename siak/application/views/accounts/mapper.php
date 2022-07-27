<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3><?= lang('accounts_map_csv_heading'); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open('accounts/mapper'); ?>
            <div class="row">
                <div class="col-md-6">
                    <?php $c = 0;
                    foreach ($default_keys as $key => $value) : ?>
                    <div>
                        <p style="font-size: 14px; margin: 0 !important;"><strong><?= $value; ?></strong></p>
                        <p style="font-size: 10; font-style: italic; margin: 0 !important;"><?php echo lang('accounts_mapper_'.$key) ?></p>
                    </div>
                    <input type="hidden" name="default<?= $c; ?>" value="<?= $key; ?>"/>
                    <?php $c++; ?>
                    <hr style="margin: 4px 0 4px 0 !important;">
                    <?php endforeach; ?>
                </div>
                <div class="col-md-6">
                    <?php for($c = 0;$c < count($current_keys);$c++) : ?>
                        <div class="form-group">
                            <select class="form-control" name="current<?= $c; ?>">
                                <option value="" disabled selected><?= lang('accounts_map_csv_option_placeholder'); ?></option>
                                <?php foreach ($current_keys as $key => $value) : ?>
                                <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endfor; ?> 
                </div>
            </div>
            <input type="hidden" name="file_path" value="<?= $file_path; ?>">
            <input type="hidden" name="number_of_keys" value="<?= count($default_keys); ?>">
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><?=lang('submit');?></button>
            <a href="<?= base_url(); ?>accounts/importer" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('accounts_map_csv_cancel_button');?></a>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
<!-- <script type="text/javascript">
    $("document").ready(function(){
        $('.default_keys').each(function() {
            var default_key_id = $(this).attr('id');
            var default_key_value = $(this).val();
            $('.key').each(function() {
                var current_key_id = $(this).attr('id');
                if (default_key_id == current_key_id) {
                    $('#'+default_key_value).attr('selected', 'selected');
                }
            });
        });
    });
</script> -->