<?php $this->load->view('admin/includes/header.php');?>


<body>
  
  	<div class="container-scroller">
	    <div class="container-fluid">
	      	<div class="row">
		        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
			        <div class="card col-lg-4 mx-auto">
			            <div class="card-body px-5 py-5">
			              	<h3 class="card-title text-left mb-3"><center>Reset Password</center></h3>
			              	<p class="text-center">Please enter your email address and we'll send you instructions on how to reset your password</p>

					        <?php echo form_open();?>
					             <div class="form-group">
					                <label style="display: none;">Email</label>
					                <?php echo form_input('email', '', 'class="form-control p_input" placeholder="Enter email address"');?>
					            </div>
					           
					          
					            <?php echo form_submit('submit', 'SUBMIT', 'class="btn btn-primary btn-block enter-btn"');?>
					        <?php echo form_close();?>

					        <!-- notification -->
					        <p>&nbsp;</p>
					        <center>
			           			<?php echo validation_errors();?>
			           			<?php echo $this->session->flashdata('error');?>

			           			<!-- success -->
			           			<?php if($this->session->flashdata('success')): ?>
				           			<div class="alert alert-warning alert-dismissible fade show" role="alert">
									  	<?php echo $this->session->flashdata('success');?>
									  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    	<span aria-hidden="true">&times;</span>
									  	</button>
									</div>
								<?php endif; ?>
								<!-- end success -->
			           		</center>
			           		<!-- ./notification -->
			           		<p class="text-center"> <a href="<?php echo site_url('admin/login'); ?>">&laquo; Back to Login</a></p>
			            </div>
			        </div>
		        </div>
	      	</div>
	    </div>
  	</div>



<?php $this->load->view('admin/includes/footer.php');?>