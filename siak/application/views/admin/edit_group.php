<section class="content">
  <div class="box">
    <div class="box-body">
    <h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>


<?php echo form_open(uri_string());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'group_description');?> <br />
            <?php echo form_textarea($group_description);?>
      </p>

    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right"><?=lang('edit_group_submit_button');?></button>
      <a href="<?= base_url(); ?>admin/groups/" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('edit_group_cancel_button');?></a>
    </div>
<?php echo form_close();?>
</div>
</div>
</section>