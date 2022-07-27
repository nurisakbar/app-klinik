<?php $this->load->view('_partials/navbar'); ?>
   
<div class="content-wrapper">
	
	<!-- <section class="content-header">
		<?php if (validation_errors()) { ?>
	      	<div class="alert alert-danger">
	          	<button data-dismiss="alert" class="close" type="button">×</button>
	          	<?= validation_errors(); ?>
	      	</div>
	  	<?php } ?>
		<?php if ($this->session->flashdata('message')) { ?>
	      	<div class="alert alert-success">
	          	<button data-dismiss="alert" class="close" type="button">×</button>
	          	<?= $_SESSION['message']; ?>
	      	</div>
	  	<?php } ?>
	  	<?php if ($this->session->flashdata('error')) { ?>
	      	<div class="alert alert-danger">
	          	<button data-dismiss="alert" class="close" type="button">×</button>
	          	<?= ($_SESSION['error']); ?>
	      	</div>
	  	<?php } ?>
	  	<?php if ($this->session->flashdata('warning')) { ?>
	      	<div class="alert alert-warning">
	          	<button data-dismiss="alert" class="close" type="button">×</button>
	          	<?= ($_SESSION['warning']); ?>
	      	</div>
	 	<?php } ?>
	</section> -->
	
	<?php $this->load->view($inner_view); ?>
</div>
<?php $this->load->view('_partials/footer'); ?>
<?php 
	if ($view_log)
	{
		$this->load->view('_partials/right_navbar');
	}
?>