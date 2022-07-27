<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h4><?= lang('accounts_importer_heading'); ?></h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart('accounts/uploader'); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="accountcsv"><?= 'Select CSV File:'; ?></label>
                        <input type="file" name="accountcsv" id="accountcsv">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well well-lg">
                        <a href="<?= base_url().'accounts/download/import.csv'?>" class="btn btn-primary"><?=lang('accounts_importer_sample_button');?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><?=lang('submit');?></button>
            <a href="<?= base_url(); ?>accounts/index" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('accounts_importer_cancel_button');?></a>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->