<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends Admin_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Reset_model');	
    }


    /**
	 * Restrict User to Load the default display of controller
    */
    public function index(){
    	dump('You are not allowed to access this server resource.');
    }




    /** 
	 * Forgot Password
	 * @uses Load Forgot Password form
    */
    public function forgot_password(){

    	$rules = $this->Reset_model->forgot_rules;
		$this->form_validation->set_rules($rules);



		if($this->form_validation->run() == TRUE){

			$response = $this->Reset_model->check_email();
			if($response->success == TRUE){
		
				$email = $response->email;
				$username = $response->username;
				$hash = $response->hash;
				$confirm_link = base_url().'admin/user/reset_password?token='.$hash;

				$message = $this->format_template_message($username, $confirm_link);

			 	//send reset email
			 	$isSendEmail = $this->mailer($email, 'Password reset request', $message); 
			 	if($isSendEmail == TRUE){
			 		$this->session->set_flashdata('success', 'A message has been sent to your email address with an instruction to reset your password.');
			 	}else{
			 		$this->session->set_flashdata('error', 'There is something wrong with the email sender. Please contact your system administrator.');
			 	}
			}else{
				$this->session->set_flashdata('error', $response->message);
				redirect('admin/user/forgot_password', 'refresh');	
			}
		}

		$this->load->view('admin/_forgot_password', $this->data);
    }






    /**
	 * Reset Password
	 * @uses Load Reset Password  Form
    */
    public function reset_password(){

    	//token validation
    	$token = $this->input->get('token');
    	if($token){
    		$response = $this->Reset_model->verify_token($token);

    		if(count($response)){
    			$this->data['email'] = $response->email; //uses by reset form

    			//check hash expiration
    			$hash_expiry = $response->hash_expiry;
    			$current_date = date('Y-m-d H:i:s');

    			$is_hash_valid = $this->check_hash_expiry_valid($hash_expiry);//check hash if valid 
    			if($is_hash_valid == FALSE){
    				$this->session->set_flashdata('token_error', 'The password reset link is no longer valid or it may have expired. <br><a href="'.site_url('admin/user/forgot_password').'">Request a new password reset link.</a>');
    				$this->data['token_error'] = true;
    			}
    		
    		}else{
    			$this->session->set_flashdata('token_error', 'The token is not recognized by the system and could not be validated. <br><a href="'.site_url('admin/user/forgot_password').'">Request a new password reset link.</a>');
    			$this->data['token_error'] = true;
    		}
    		
    	}
    	//end token validation



    	//password reset execution
		if($this->input->post('form_submit')){
			$token = xss_clean($this->input->post('token'));
			$new_password = xss_clean($this->input->post('password'));

			//get data by token and verify
			$response = $this->Reset_model->verify_token($token);//verify token
			if(count($response)){
				$hash_expiry = $response->hash_expiry;
				$user_id = $response->id;
				$email = $response->email;
				$username = $response->username;

				$is_hash_valid = $this->check_hash_expiry_valid($hash_expiry);//check hash if valid 
				if($is_hash_valid == TRUE){
					$is_password_changed = $this->Reset_model->change_password($new_password, $user_id);
					if($is_password_changed){
						//send email
						$message = $this->template_message_password_changed($username); //format html msg
						$isSendEmail = $this->mailer($email, 'Password changed successfully', $message); //send

						$this->Reset_model->clear_hash($user_id);
						$this->session->set_flashdata('reset_password_success', 'Congratulations! You have successfully changed your password.');
						redirect('admin/login', 'refresh');
					}	
				}
			}else{
				$this->session->set_flashdata('token_error', 'The token is not recognized by the system and could not be validated. <br><a href="'.site_url('admin/user/forgot_password').'">Request a new password reset link.</a>');
    			$this->data['token_error'] = true;
				redirect('admin/user/reset_password?token='.$token, 'refresh');	
			}
		}
    	//end password reset execution



    	$this->load->view('admin/_reset_password', $this->data);
    }





    /**
	 * Check if the hash is valid within 24hrs
	 * @param hash_expiry 
	 * @uses reset_password()
    */
    public function check_hash_expiry_valid($hash_expiry){
    	$current_date = new DateTime();
		$hash_expiry = new DateTime($hash_expiry);
		$interval = $current_date->diff($hash_expiry); //currentdate - hashexpiry

		//get elapsed
		$elapsed_day = $interval->format('%a');
		$elapsed_hour = $interval->format('%h');

		if($elapsed_day <= 1){
			$hrOneDay = ($elapsed_day == 1 ? 24:0);
			$total_elapsed_hour = $hrOneDay + $elapsed_hour;

			if($total_elapsed_hour <= 24){
				//return "Valid:: ".$elapsed_day ." day, " . $elapsed_hour ." hours";
				return TRUE;
			}else{
				//return "ExpiredE:: ".$elapsed_day ." day, " . $elapsed_hour ." hours";
				return FALSE;
			}
			
		}else{
			//return "ExpiredDay:: ".$elapsed_day ." day, " . $elapsed_hour ." hours";
			return FALSE;
		}
    }





    /**
	 * HTML Email Template for Password Reset
	 * @param usename, confirm_link
	 * @uses forgot_password()
    */
    public function format_template_message($username, $confirm_link){
    	$html = '
    		<p>Hi '.$username.',</p>
    		<br>
    		
    		<p>You recently requested to reset your password for your account. Use the button below to reset it. <b>This password reset is only valid for the next 24 hours.</b></p>
    		<br>

    		<p><a href="'.$confirm_link.'" target="_blank" style="text-decoration: none;color: #fff; background: #00cc33; padding: 15px 25px;">Reset your password</a></p>

    		<br>
    		<p>For security, this request was received from <b>'. $_SERVER['HTTP_USER_AGENT'] .'</a></b> with an IP Address <b>'.$_SERVER['SERVER_ADDR'].'</b> on <b>'.date('Y-m-d H:i:s').'</b>. If you did not request a password reset, please ignore this email or contact your system administrator if you have questions.</p>

    		<br>
    		<p>Thanks</p>


    		<hr>
    		<p>If you are having trouble with the button above, copy and paste the URL below into your web browser:</p>
    		<p><a href="'.$confirm_link.'">'.$confirm_link.'</a></p>
    	';
    	return $html;
    }


    /**
	 * HTML Email Template for Password Changed successful
	 * @param username
	 * @uses reset_password()
    */
    public function template_message_password_changed($username){
    	$html = '
    		<p>Hi '.$username.',</p>
    		<br>
    		
    		<h1>You have got a new password.</h1>
    		<p>Congratulations! Your password has been changed successfully.</p>
    		<br>

    		<p><a href="'.site_url('admin/login').'" target="_blank" style="text-decoration: none;color: #fff; background: #1991EB; padding: 15px 25px;">Login to your account</a></p>

    		<br>
    		<p>For security, this password changed was received from <b>'. $_SERVER['HTTP_USER_AGENT'] .'</a></b> with an IP Address <b>'.$_SERVER['SERVER_ADDR'].'</b> on <b>'.date('Y-m-d H:i:s').'</b>. If the changes described above are accurate, no further action is needed. If anything does not look right, follow the link below to make changes: <a href="'.site_url('admin/user/forgot_password').'"><b>Reset password</b></a></p>

    		<br>
    		<p>Thanks</p>

    	';
    	return $html;
    }

}