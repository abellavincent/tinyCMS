<?php $this->load->view('admin/includes/header.php');?>


<body>
  	<!-- password change successful -->
  	<?php if($this->session->flashdata('reset_password_success')): ?>
	  	<div style="text-align: center;width: 100%; background: #89C35C; color: #fff; font-weight: bold;padding: 20px;">
	  		<?php echo $this->session->flashdata('reset_password_success');?>
	  	</div>
  	<?php endif; ?>
	<!-- password change successful -->

  	<div class="container-scroller">
	    <div class="container-fluid">
	      	<div class="row">
		        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
			        <div class="card col-lg-4 mx-auto">
			            <div class="card-body px-5 py-5">
			              	<h3 class="card-title text-left mb-3"><center>Admin Login</center></h3>

					        <?php echo form_open();?>
					             <div class="form-group">
					                <label>Username</label>
					                <?php echo form_input('username', '', 'class="form-control p_input"');?>
					            </div>
					            <div class="form-group">
					                <label>Password</label>
					                <?php echo form_password('password', '', 'class="form-control p_input"');?>
					            </div>

					            <div class="form-group d-flex align-items-center justify-content-between">
				                  	<a href="<?php echo site_url('admin/user/forgot_password'); ?>" class="forgot-pass">Forgot password?</a>
				                </div>
					          
					            <?php echo form_submit('submit', 'LOG IN', 'class="btn btn-primary btn-block enter-btn"');?>
					        <?php echo form_close();?>

					        <!-- error notification -->
					        <p>&nbsp;</p>
					        <center>
			           			<?php echo validation_errors();?>
			           			<?php echo $this->session->flashdata('error');?>
			           		</center>
			           		<!-- ./error notification -->

			            </div>
			        </div>
		        </div>
	      	</div>
	    </div>
  	</div>



<?php $this->load->view('admin/includes/footer.php');?>