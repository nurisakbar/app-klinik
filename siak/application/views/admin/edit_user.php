<section class="content">
  <div class="box">
    <div class="box-header">
      <h1><?php echo lang('edit_user_heading');?></h1>
      <p><?php echo lang('edit_user_subheading');?></p>
    </div>
    <?php echo form_open(uri_string());?>
    <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <p>
              <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
              <?php echo form_input($first_name);?>
            </p>

            <p>
              <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
              <?php echo form_input($last_name);?>
            </p>

            <p>
              <?php echo lang('edit_user_company_label', 'company');?> <br />
              <?php echo form_input($company);?>
            </p>
          </div>
          <div class="col-md-4">
            <p>
              <?php echo lang('edit_user_phone_label', 'phone');?> <br />
              <?php echo form_input($phone);?>
            </p>
            <p>
              <?php echo lang('edit_user_password_label', 'password');?> <br />
              <?php echo form_input($password);?>
            </p>
            <p>
              <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
              <?php echo form_input($password_confirm);?>
            </p>
          </div>
          <div class="col-md-4">
            <h3><?php echo lang('edit_user_groups_heading');?></h3>
              <?php foreach ($groups as $group):?>
                <label class="radio">
                  <?php
                    $gID=$group['id'];
                    $checked = null;
                    $item = null;
                    foreach($currentGroups as $grp) {
                        if ($gID == $grp->id) {
                            $checked= ' checked="checked"';
                        break;
                        }
                    }
                  ?>
                <input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                <?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?>
                </label>
              <?php endforeach?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div>
              <h3><?=lang('create_user_accessibleAccounts_label');?></h3>
              <select class="form-control" name="accounts[]" id="accessibleAccounts" multiple required>
                <option value="all" <?= ($user->all_accounts == 1 && $accessibleAccounts[0] == 'all') ? 'selected="selected"' : '';?> ><?=lang('create_user_accessibleAccounts_frst_option');?></option>
              <?php 
              foreach ($accounts as $row => $account){
                $selected = '';
                foreach ($accessibleAccounts as $selected_accounts) {
                  if ($selected_accounts == $account->id) {
                    $selected = 'selected="selected"';
                  }
                }
              ?>
                <option value="<?= $account->id; ?>" <?= (!empty($selected) ? $selected : ''); ?> ><?= ($account->label); ?></option>
              <?php }?>
            </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" style="margin-top: 30px;">
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#userimage" style="width: 100%;"><?=lang('edit_user_updateuserimage_btn_label');?></button>
            </div>
          </div>
        </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right"><?=lang('edit_user_submit_btn');?></button>
      <a href="<?= base_url(); ?>admin/users/" id="cancel" name="cancel" class="btn btn-default pull-right" style="margin-right: 5px;"><?=lang('edit_user_cancel_btn');?></a>
    </div>
    <?php echo form_close();?>

  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="userimage" aria-labelledby="updateuserimage">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= lang('edit_user_modal_title'); ?></h4>
      </div>
      <?php $attributes = array('id' => 'updateuserimage');
          echo form_open_multipart('' ,$attributes); ?>
        <div class="modal-body">
        <div class="msg">
        </div>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-left: 20px;">
                <label><?=lang('edit_user_userimageupdate_label');?></label>
                <input type="file" name="userimageupdate" id="userimageupdate" />
              </div>
              <div style="margin-top: 20px; text-align: center;">
                <img id="previewImage" src="" style="max-width: 100%; height: auto;" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('edit_user_modal_cancel_btn_label');?></button>
          <button type="submit" name="uploadimage" class="btn btn-primary"><?=lang('edit_user_modal_submit_btn_label');?></button>
        </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#previewImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#accessibleAccounts').select2({
    placeholder: "<?=lang('create_user_accessibleAccounts_placeholder');?>"
  });

$("#userimageupdate").change(function(){
  readURL(this);
});

$('#updateuserimage').submit(function(event){  
  event.preventDefault();
  var userid = <?= $user->id; ?>;
  var data = new FormData();
  jQuery.each(jQuery('#userimageupdate')[0].files, function(i, file) {
    data.append('userimageupdate', file);
  });

  jQuery.ajax({  
    url:"<?= base_url(); ?>admin/updateuserimage/"+userid,  
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    type: 'POST',
    success:function(data){
      var alert = '';
      if(data){
        if (data.status == 'success') {
          alert = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_success_label'); ?>'+ data.msg +'</div><br>';
        }else{
          alert = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_error_label'); ?>'+ data.msg +'</div><br>';
        }      
      }
      $('.msg').html(alert);
      $('#userimage').animate({ scrollTop: 0 }, 'fast');
    }  
  });  
});
</script>