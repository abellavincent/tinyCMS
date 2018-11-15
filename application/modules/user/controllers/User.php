<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Frontend_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('User_model');	
    }


    public function save_subscriber(){
    	
    	if($this->input->post('form_submit')){
    		$email = $this->input->post('email');
    		$email = $this->security->xss_clean($email);
			$is_email_exist = $this->check_email_exist($email);
			if($is_email_exist == FALSE){
				$username = date('YmdHis');
				$image = site_url('assets/images/default-profile-pic.png'); //default image

				$data = array(
					'username' => $username,
					'role_id' => '5', //subscriber role id
					'email' => $email,
					'status' => 'inactive',
					'date_created' => date('Y-m-d H:i:s'),
					'image' => $image,
				);
				$isSave = $this->User_model->save($data);
				if($isSave){
					echo json_encode(array('success' => TRUE));
				}else{
					echo json_encode(array('success' => FALSE));
				}
			}else{
				echo json_encode(array('success' => 'email_exist'));
			}
		}else{
			echo json_encode(array('error' => 'post parameters missing'));
		}
    }



    /**
	 * Check if email already exist
	 * @param $email
	 * @return boolean
	 * @uses save_subscriber
    */
    public function check_email_exist($email){
    	if($email){
    		$data = $this->User_model->get_by(array('email' => $email));
    		if(count($data)){
    			return TRUE;
    		}else{
    			return FALSE;
    		}
    	}else{
    		echo json_encode(array('error' => 'no valid arguments'));
    	}
    }
	
}