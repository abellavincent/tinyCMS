<?php $this->load->view('admin/includes/header.php');?>


<body>
	<!--error notification on load-->
	<?php if($this->session->flashdata('token_error')): ?>
	<center>
		<div style="font-size: 14px;width: 100%;padding: 20px;margin: 200px auto;">
			<?php echo $this->session->flashdata('token_error');?>
		</div>
	</center>
	<?php endif; ?>
	<!--end error notification on load-->


	<?php if(!isset($token_error)): ?>
  	<div class="container-scroller">
	    <div class="container-fluid">
	      	<div class="row">
		        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
			        <div class="card col-lg-4 mx-auto">
			            <div class="card-body px-5 py-5">
			              	<h3 class="card-title text-left mb-3"><center>Reset Your Password</center></h3>
			              	<p class="text-center">You have requested to reset the password for:</p>
			              	<p class="text-center"><strong><?php echo maskEmail($email); ?></strong></p>

					        <?php echo form_open();?>
					            <div class="form-group">
					                <?php echo form_password('password', '', 'id="password" class="form-control p_input" placeholder="Enter password"');?>
					            </div>

					            <div class="form-group">
					                <?php echo form_password('confirm_password', '', 'id="confirm_password" class="form-control p_input" placeholder="Re-type your password"');?>
					            </div>
					           	
					           	<input type="hidden" name="form_submit" value="TRUE" />
					           	<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
					          
					            <?php echo form_submit('submit', 'Reset Password', 'id="btn-reset" class="btn btn-primary btn-block enter-btn"');?>
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
  	<?php endif; ?>



  	<?php 
  		/**
	 	 * Mask the first 5 string of an email
	 	 * @usage reset password display for email address
  		*/
  		function maskEmail($email){
    		$mask_email =  str_repeat("*", strlen($email)-22) . substr($email, -22);
    		return $mask_email;
		}
  	?>


  	<!-- reset password form validation -->
  	<script type="text/javascript">
  		$(document).ready(function(){
  			
  			$("#confirm_password").keyup(function(){
  				var password = $('#password').val();
  				var confirm_password = $(this).val();

  				if(password == confirm_password){
  					$('#password').css("border", "1px solid #00cc33");
  					$(this).css("border", "1px solid #00cc33");
  					$('#btn-reset').prop("disabled", false);
  				}else{
  					$('#password').css("border", "1px solid red");
  					$(this).css("border", "1px solid red");
  					$('#btn-reset').prop("disabled", true);
  				}
			});


			$("#password").keyup(function(){
  				var confirm_password = $('#confirm_password').val();
  				var password = $(this).val();

  				if(password == confirm_password){
  					$('#confirm_password').css("border", "1px solid #00cc33");
  					$(this).css("border", "1px solid #00cc33");
  					$('#btn-reset').prop("disabled", false);
  				}else{
  					$('#confirm_password').css("border", "1px solid red");
  					$(this).css("border", "1px solid red");
  					$('#btn-reset').prop("disabled", true);
  				}
			});


			$('#btn-reset').click(function(){
				var password = $('#password').val();
				var confirm_password = $('#confirm_password').val();

				if(password.length == 0){
					$('#password').css("border", "1px solid red");
					$('#password').focus();
					return false;
				}else if(confirm_password.length == 0){
					$('#confirm_password').css("border", "1px solid red");
					$('#confirm_password').focus();
					return false;
				}else{
					return true;
				}
			});
  		});
  	</script>
  	<!-- end reset password form -->



<?php $this->load->view('admin/includes/footer.php');?>