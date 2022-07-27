<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
	<base href="<?php echo base_url(); ?>" />
	<script type="text/javascript">
		<?php if (isset($account_settings)) { ?>
			var mAccountSettings = <?=json_encode($account_settings);?>;
		<?php } else { ?>
			var mAccountSettings = "";
		<?php } ?>
		var site = <?=json_encode(array(
			'base_url' => base_url(), 
			'url' => base_url(), 
			'assets' => base_url().'assets/', 
			'msettings' => $settings,
			'account_settings' => $account_settings,
			'date_format' => $date_format))?>;
		var lang = {
			paid: '<?=lang('paid');?>',
			pending: '<?=lang('pending');?>',
			completed: '<?=lang('completed');?>',
			ordered: '<?=lang('ordered');?>',
			received: '<?=lang('received');?>',
			partial: '<?=lang('partial');?>',
			sent: '<?=lang('sent');?>',
			r_u_sure: '<?=lang('r_u_sure');?>',
			due: '<?=lang('due');?>',
			returned: '<?=lang('returned');?>',
			transferring: '<?=lang('transferring');?>',
			active: '<?=lang('active');?>',
			inactive: '<?=lang('inactive');?>',
			unexpected_value: '<?=lang('unexpected_value');?>',
			select_above: '<?=lang('select_above');?>',
			download: '<?=lang('download');?>'
		};
	</script>
	<title><?php echo $page_title; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/ionicons/css/ionicons.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	   folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/square/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
	
	<!-- bootstrap wysihtml5 - text editor -->
	<!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
	
	<!-- jQuery UI 1.11.4 -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables/media/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css">
	<!-- Bootstrap Color Picker -->
 	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
 	<!-- Toastr -->
 	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/toastr/toastr.css">
 	<!-- Custom style -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/mystyle.css">
	<!-- Pagination.js -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/paginationjs/pagination.css">
	
	<!-- jQuery 3.2.1 -->
	<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-3.2.1.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/select2/select2.min.js"></script>
	<!-- Toastr -->
	<script src="<?= base_url();?>assets/plugins/toastr/toastr.min.js"></script>
	<!-- DataTables -->
	<script src="<?= base_url();?>assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url();?>assets/plugins/datatables/media/js/dataTables.bootstrap.min.js"></script>
	<!-- DataTables - PDF Extension -->
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/pdfmake/pdfmake.min.js"></script>
	<!-- DataTables - Zip Extension -->
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/JSZip/jszip.min.js"></script>
	<!-- DataTables - Buttons Extension -->
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.print.min.js"></script>
	<!-- <script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js"></script> -->
	
	<!-- Bootstrap Color Picker -->
	<script src="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<!-- Bootbox -->
	<script src="<?= base_url(); ?>assets/plugins/bootbox/bootbox.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/accounting.js/accounting.js"></script>
	<!-- iCheck -->
	<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
	<!-- Jquery Date Format -->
	<script src="<?= base_url(); ?>assets/plugins/jquery-dateformat/jquery-dateformat.min.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body class="skin-blue" style="background-image: url('<?php echo base_url("assets/dist/img/bg.jpg");?>');width: 100%">