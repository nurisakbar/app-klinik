<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="white-space: initial;"><?= $settings->sitename; ?></span>
      <!-- logo for regular state and mobile devices 
      <span class="logo-lg"><?= $settings->sitename; ?></span> -->
      <!-- <span class="logo-lg"><img src="<?php echo base_url();?>/assets/dist/img/logo-light.png"></span> -->
      Siklinik
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown">
            <a href="<?= base_url('user/activate'); ?>"><?=lang('main_header_active_account');?><em style="font-size: 16px;"><strong>(<?= ($this->session->userdata('active_account')) ? $this->session->userdata('active_account')->label : lang('main_header_active_account_NONE');?>)</strong></em></a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url(); ?>assets/uploads/users/<?= $current_user->image; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $current_user->first_name . ' ' . $current_user->last_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url(); ?>assets/uploads/users/<?= $current_user->image; ?>" class="img-circle" alt="User Image">
                <p>
                  <?= $current_user->first_name . ' ' . $current_user->last_name; ?>
                  <small><?=  sprintf(lang('main_header_user_dropdown_member_since'), date("D, F jS, Y", $current_user->created_on), date("g:i a", $current_user->created_on));?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if ($this->ion_auth->is_admin()) { ?>
                  <a href="<?= base_url()."admin/edit_user/".$this->session->userdata('user_id'); ?>" class="btn btn-default btn-flat"><?=lang('main_header_user_dropdown_profile_btn_label');?></a>
                  <?php }else{ ?>
                    <a href="#updateimage_modal" data-toggle="modal" class="btn btn-default btn-flat"><?=lang('main_header_user_dropdown_updateuserimage_btn_label');?></a>
                  <?php } ?>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('login/logout'); ?>" class="btn btn-default btn-flat"><?=lang('main_header_user_dropdown_logout_btn_label');?></a>
                </div>
              </li>
            </ul>
          </li>
          <?php if ($uri == 'dashboard/index' && $view_log): ?>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-history"></i></a>
            </li>
          <?php endif ?>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="<?= (isset($this->mAccountSettings) ? '' : 'height: 60px;') ?> min-height: 50px;">
        <div class="pull-left image" style="margin-top: 5px;">
          <img src="<?php if(isset($this->mAccountSettings)){ echo base_url().'assets/uploads/companies/'.$this->mAccountSettings->logo; }else{ echo '';} ?>" class="img-thumbnail" alt="Logo">
        </div>
        <div class="pull-left info" style="white-space: initial; font-size: 12px;margin-top: 3px;">
          <?php if (isset($this->mAccountSettings)) {
            echo '<strong>'.$this->mAccountSettings->name.'</strong>';
          }else{
            echo sprintf(lang('sidebar_account_not_active_msg'), base_url('user/activate'));
            } ?>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
      <?php 
      foreach ($menu as $parent => $parent_params) {
        if ((array_key_exists($parent_params['url'], $page_auth) && $page_auth[$parent_params['url']] == 1 ) || !array_key_exists($parent_params['url'], $page_auth)) {
          if (empty($parent_params['children'])) {
      ?>
      <?php 
            if($parent == 'label' or $parent == 'label1') { ?>
            <li class="header"><?php echo $parent_params['name']; ?></li>
      <?php }else{ ?>
              <li class="<?php if($uri == $parent_params['url']){echo "active";} ?>">
                <a href="<?php echo $parent_params['url']; ?>">
                  <i class="<?php echo $parent_params['icon']; ?>"></i> <span><?php echo $parent_params['name']; ?></span>
                </a>
              </li>
      <?php } ?>
    <?php }else { ?>
            <li class="<?php if(in_array($action, $parent_params['children'])){ echo "active"; } ?> treeview">
              <a href="#">
                <i class="<?php echo $parent_params['icon']; ?>"></i> <span><?php echo $parent_params['name']; ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              <?php
              if (strpos($parent_params['url'], '/') !== false) {
                $parent_params['url'] = substr_replace($parent_params['url'], '', strpos($parent_params['url'], '/'), strlen($parent_params['url']));
              }
              foreach ($parent_params['children'] as $name => $url){
                $child_url = $parent_params['url'].'/'.$url;
                if ((array_key_exists($child_url, $page_auth) && $page_auth[$child_url] == 1 ) || !array_key_exists($child_url, $page_auth)) { ?>
                  <li class="<?php if($action == $url){ echo "active"; } ?>"><a href="<?php echo $child_url ?>"><i class="fa fa-circle-o"></i> <?php echo $name; ?></a></li>
              <?php 
                }
              } 
              ?>
              </ul>
            </li>
      <?php
          }
        }
      }//$menu foreach
      ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<?php if (!$this->ion_auth->is_admin()) { ?>
<div class="modal fade" tabindex="-1" role="dialog" id="updateimage_modal" aria-labelledby="updateimage">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= lang('edit_user_modal_title'); ?></h4>
      </div>
      <?php $attributes = array('id' => 'changeimage_form');
          echo form_open_multipart('' ,$attributes); ?>
        <div class="modal-body">
        <div class="msg">
        </div>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-left: 20px;">
                <label><?=lang('edit_user_userimageupdate_label');?></label>
                <input type="file" name="image" id="image" />
              </div>
              <div style="margin-top: 20px; text-align: center;">
                <img id="image_preview" src="" style="max-width: 100%; height: auto;" />
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
        $('#image_preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#image").change(function(){
    readURL(this);
  });

  $('#changeimage_form').submit(function(event){  
    event.preventDefault();
    var userid = <?= $current_user->id; ?>;
    var data = new FormData();
    jQuery.each(jQuery('#image')[0].files, function(i, file) {
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
        var msg = '';
        if(data){
          if (data.status == 'success') {
            msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_success_label'); ?>'+ data.msg +'</div><br>';
          }else{
            msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_error_label'); ?>'+ data.msg +'</div><br>';
          }      
        }
        $('.msg').html(msg);
        $('#updateimage_modal').animate({ scrollTop: 0 }, 'fast');
      }  
    });  
  });
</script>

<?php } ?>