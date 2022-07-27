<script type="text/javascript">
$(function () {
    $('input[type="checkbox"],[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    // $('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
    //   checkboxClass: 'icheckbox_square-blue',
    //   radioClass: 'iradio_square-blue',
    //   increaseArea: '20%' // optional
    // });
});

$(document).ready(function(){
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": true,
	  "progressBar": true,
	  "positionClass": "toast-bottom-right",
	  "preventDuplicates": true,
	  "onclick": null,
	  "showDuration": "500",
	  "hideDuration": "500",
	  "timeOut": "2500",
	  "extendedTimeOut": "500",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "slideDown",
	  "hideMethod": "hide"
	};
	<?php if($this->session->flashdata('message')){ ?>
		toastr["success"]("<?php echo $this->session->flashdata('message'); ?>", "<?php echo lang('toastr_success_heading'); ?>");
	<?php } ?>

	<?php if($this->session->flashdata('error')){  ?>
		toastr["error"]("<?php echo $this->session->flashdata('error'); ?>", "<?php echo lang('toastr_error_heading'); ?>");
	<?php } ?>

	<?php if($this->session->flashdata('warning')){  ?>
		toastr["warning"]("<?php echo $this->session->flashdata('warning'); ?>", "<?php echo lang('toastr_warning_heading'); ?>");
	<?php } ?>
	<?php if($this->session->flashdata('info')){  ?>
		<?php if (is_array($this->session->flashdata('info'))) { ?>
			<?php foreach ($this->session->flashdata('info') as $value) { ?>
				toastr["info"]("<?php echo $value; ?>", "<?php echo lang('toastr_info_heading'); ?>");
			<?php } ?>
		<?php }else{ ?>
			toastr["info"]("<?php echo $this->session->flashdata('info'); ?>", "<?php echo lang('toastr_info_heading'); ?>");
		<?php } ?>
	<?php } ?>
	<?php if (validation_errors()) { ?>
		<?php $errors = trim(preg_replace('/\s+/', ' ', validation_errors())); ?>
		toastr["info"]("<?php echo $errors; ?>", "<?php echo lang('toastr_info_heading'); ?>");
	<?php } ?>
});
</script>

<!-- Pagination.js -->
<script src="<?= base_url(); ?>assets/plugins/paginationjs/pagination.min.js"></script>

<!-- Morris.js charts -->
<script src="<?= base_url(); ?>assets/plugins/raphael/raphael.js"></script>
<script src="<?= base_url(); ?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url(); ?>assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url(); ?>assets/plugins/moment/moment.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<!-- <script src="<?= base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->

<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="<?= base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- Slimscroll -->
<script src="<?= base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/app.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?= base_url(); ?>assets/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= base_url(); ?>assets/dist/js/demo.js"></script> -->

<!-- Custom JS -->
<script src="<?= base_url(); ?>assets/dist/js/myjs.js"></script>

</body>
</html>