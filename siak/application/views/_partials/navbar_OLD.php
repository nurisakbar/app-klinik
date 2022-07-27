<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="white-space: initial;"><?= $settings->sitename; ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= $settings->sitename; ?></span>
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
            <a href="<?= base_url('user/activate'); ?>">Active Account <em style="font-size: 16px;"><strong>(<?= ($this->session->userdata('active_account')) ? $this->session->userdata('active_account')->label : 'NONE';?>)</strong></em></a>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url(); ?>assets/uploads/users/<?= $user->image; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $user->first_name . ' ' . $user->last_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url(); ?>assets/uploads/users/<?= $user->image; ?>" class="img-circle" alt="User Image">

                <p>
                  <?= $user->first_name . ' ' . $user->last_name; ?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= base_url()."admin/edit_user/".$this->session->userdata('user_id'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('login/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="width: auto;">
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
            echo "<strong>No Active Account</strong><br><a href=".base_url('user/activate')." style='color: #3c8dbc;'> Click here</a> to select an Account";
            } ?>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
       <ul class="sidebar-menu">
 <?php foreach ($menu as $parent => $parent_params): ?>
    <?php if ( (array_key_exists($parent_params['url'], $page_auth) && $page_auth[$parent_params['url']] == 1 ) || !array_key_exists($parent_params['url'], $page_auth) ): ?>

      <?php if ( empty($parent_params['children']) ): ?>

       <?php if($parent == 'label' or $parent == 'label1'): ?>
          <li class="header"><?= $parent_params['name']; ?></li>
        <?php else : ?>
          <?php $active = ($current_uri == $parent_params['url'] || $ctrler == $parent); //echo "active = $active"; ?>
          <li class='<?php if ($active) echo 'active'; ?>'>
            <a href='<?= base_url(); ?><?php echo $parent_params['url']; ?>'>
              <i class='<?php echo $parent_params['icon']; ?>'></i> <span><?php echo $parent_params['name']; ?></span>
            </a>
          </li>
        <?php endif; ?>

      <?php else: ?>
        <?php 
        if (isset($action) && !empty($action)) {
          if (strpos($parent, '-')) {
            $lenght = strpos($parent, '-')+1;
          }else{
            $lenght = 0;
          }
        $parent_action = substr_replace($parent, '', 0, $lenght);
        $parent_ctrler = substr_replace($parent, '', strpos($parent, '-'), strlen($parent));
        }
        $parent_active = (($ctrler == $parent_ctrler && $action == $parent_action) || $ctrler == $parent);
        ?>
        <li class='treeview <?php if ($parent_active) echo 'active'; ?>'>
          <a href='#'>
            <i class='<?php echo $parent_params['icon']; ?>'></i> <span><?php echo $parent_params['name']; ?></span> <i class='fa fa-angle-left pull-right'></i>
          </a>
          <ul class='treeview-menu'>
              <?php foreach ($parent_params['children'] as $name => $url): ?>
              <?php if ( (array_key_exists($url, $page_auth) && $page_auth[$url] == 1 ) || !array_key_exists($url, $page_auth) ): ?>
              <?php $child_active = ($current_uri==$url); ?>
              <li <?php if ($child_active) echo 'class="active"'; ?>>
                <a href='<?= base_url(); ?><?php echo $url; ?>'><i class='fa fa-circle-o'></i> <span><?php echo $name; ?></span></a>
              </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>

      <?php endif; ?>
  
    <?php endif; ?>

  <?php endforeach; ?>
</ul>