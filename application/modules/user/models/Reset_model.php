<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_model extends MY_Model {

	protected $_table_name = 'users';
	protected $_order_by = '';
	protected $_unique_key = 'JKOnhj42Uko$k12faneb'; //for salting email hash

	function __construct(){
        parent::__construct();
    }
    

    public $forgot_rules = array(
		'email' => array(
			'field' => 'email', 
			'label' => 'email', 
			'rules' => 'trim|required|xss_clean'
		),
	);



	public $reset_rules = array(
		'password' => array(
			'field' => 'password', 
			'label' => 'email', 
			'rules' => 'trim|required|xss_clean|matches[confirm_password]'
		),
	);




    /**
	 * Verify the email address
	 * @param POST email
	 * @uses forgot password
	 * @return send forgot password link to user
    */
	public function check_email(){

		//preset variables
		$email = $this->input->post('email');
		$unique_key = $this->_unique_key;
		$current_datetime = date('Y-m-d H:i:s');
		$hash_expiry = date('Y-m-d H:i:s', time() + 24 * 60 * 60); //curdate + 24hrs

		//get userdata by email address
		$user_data = $this->get_by(array(
			'email' => $email,
		), TRUE);

		//check if user exist
		if(count($user_data)){
			$user_email = $user_data->email; //get email from db
			$user_id =  $user_data->id; //get user id from db
			$username =  $user_data->username; //get user id from db
			$hash = hash ("sha256", $unique_key.$user_email.$current_datetime); //generate hash

			$data = array(
				'hash' => $hash,
				'hash_expiry' => $hash_expiry,
			);

			$isUpdateHash = parent::save($data, $user_id);

			if($isUpdateHash){
				return (object) array(
					'success' => TRUE,
					'email' => $user_email,
					'username' => $username,
					'hash' => $hash,
					'hash_expiry' => $hash_expiry,
					'message' => 'User hash been generated successfully'
				);
			}else{
				return (object) array(
					'success' => FALSE,
					'message' => 'Something went wrong with the server connection. Please try again later'
				);
			}

		}else{
			return (object) array(
				'success' => FALSE,
				'message' => "The system didn't recognize your email address. Please contact your system administrator."
			);
		}
	}





	/**
	 * Verify Token
	 * @param GET token
	 * @uses reset password
	 * @return data array
	*/
	public function verify_token($token){
		
		$user_data = $this->get_by(array(
			'hash' => $token,
		), TRUE);

		return $user_data;
	}



	/**
	 * Change Password
	 * @param new_password, user_id
	 * @uses controller-> reset_password()
	 * @return boolean
	*/
	public function change_password($new_password, $user_id){
		$data = array(
			'password' => md5($new_password)
		);
		return $response = parent::save($data, $user_id);
	}




	/**
	 * Clear the hash & hash_expiry in users table
	 * @param user_id
	*/
	public function clear_hash($user_id){
		$data = array(
			'hash' => '',
			'hash_expiry' => '0000-00-00 00:00:00'
		);
		return $response = parent::save($data, $user_id);
	}



}