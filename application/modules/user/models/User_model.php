<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

	protected $_table_name = 'users';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }
    

    public $rules = array(
		'username' => array(
			'field' => 'username', 
			'label' => 'username', 
			'rules' => 'trim|required|xss_clean'
		),
		'password' => array(
			'field' => 'password', 
			'label' => 'Password', 
			'rules' => 'trim|required'
		),
	);





	/**
	 * User Login, checks username and password
	 * @param POST data
	 * @uses form login
	*/
	public function login(){
		$this->db->where('status', 'active'); //where status is active
		$user = $this->get_by(array(
			'username' => $this->input->post('username'),
			'password' => $this->hash($this->input->post('password')),
		), TRUE);

		$data = array();
		
		if(count($user)){
			// Prepare user data to be set for session use
			$data = array(
				'username' => $user->username,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'email' => $user->email,
				'image' => $user->image,
				'id' => $user->id,
				'loggedin' => TRUE,
			);

			$this->session->set_userdata($data);
			$this->update_login_info($user->id);
			$this->set_session_role($user->role_id);
	
			return TRUE;
		}else{
			return FALSE;
		}
	}





	/**
	 * Get User Loggedin Details, last_login and ip address
	 * @uses update login info, login success
	*/
	public function update_login_info($id){
		$now = date('Y-m-d H:i:s');
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$data = array(
			'last_login' => $now,
			'last_login_ip' => $ip_address,
		);

		$this->db->set($data);
		$this->db->where($this->_primary_key, $id);
		$this->db->update($this->_table_name);
	}





	/**
	 * Set Session Role
	 * @param $role_id
	 * @uses set session data
	*/
	public function set_session_role($role_id){
		$this->db->select('name, id');
    	$this->db->from('user_role');
    	$this->db->where('id', $role_id);
		$user = $this->db->get()->row();
		$data = array(
			'user_role' => $user->name,
			'role_id' => $user->id,
		);
		$this->session->set_userdata($data);
	}





	/**
	 * Set User Query
	 * @uses user admin query
	*/
	public function set_query(){
		$this->db->select('*, users.id as user_id');
		$this->db->join('user_role', 'users.role_id = user_role.id', 'inner');
		$this->db->order_by('last_login desc');	
	}






	/**
	 * Search users
	 * @return result object array
	 * @uses search user form
	*/
	public function search_users($keyword){
    	if(empty($keyword))
       		return array();

	    $this->db->like('username', $keyword);
	    $this->db->or_where("CONCAT(first_name, ' ', last_name) LIKE '%$keyword%'");

        $result = $this->db->limit(10)->get($this->_table_name);

    	return $result->result();
    	$this->db->reset();
    }




	/**
	 * Check User Logged In
	 * @return boolean
	 * @uses user login, global
	*/
	public function loggedin(){
		return (bool) $this->session->userdata('loggedin');
	}




	/**
	 * User Logout
	 * @uses clear all session data
	*/
	public function logout(){
		$this->session->sess_destroy();	
	}
	




	/**
	 * Password Encryption
	 * @param $string
	 * @return string hash
	 * @uses login, create user
	*/
	public function hash($string){
		//return hash('sha512', $string . config_item('encryption_key'));
		return hash('md5', $string);
	}






	/**
	 * Update Role Permission
	 * @param $user_role_id, $data
	 * @uses save menu group item
	*/
	public function update_role_permission($user_role_id, $data){
		$this->db->where('id', $user_role_id);
		$this->db->update('user_role', $data);
	}






	/**
	 * Check Module Permission
	 * @param $role_id, $module_request
	 * @uses global
	*/
	public function isModulePermissionAllowed($role_id, $module_request){
		if($this->loggedin()){
			
			$result = $this->db->get('user_role')->result();
			$data_module_perm = $result[0]->module_permissions;
			$dataArray = unserialize($data_module_perm);

			$module_exist = $this->search_in_array($module_request, $dataArray);
			if(!$module_exist){
				//echo "Module Access Not Authorized.<br>Please contact system administrator.<br><a href='".site_url('admin/logout')."'>Logout</a>";
				echo json_encode(array(
					'error' => 'module access permission not allowed',
					'msg' => 'please contact system administrator'
				), JSON_PRETTY_PRINT);
				exit();
			}
		}
	}



	/**
	 * Search if module request exist in module_permission
	 * @param $value, $array
	 * @uses isModulePermissionAllowed()
	*/
	public function search_in_array($value, $array) {
		if(in_array($value, $array)) {
	    	return true;
	 	}
	 	foreach($array as $item) {
	    	if(is_array($item) && $this->search_in_array($value, $item))
	        return true;
	 	}
			return false;
	}




	/**
     * Get Recent Post
     * @param $limit
     * @return object array
     * @uses global
    */
	public function get_user_activity($limit){
		$this->db->where('status', 'active');
        $this->db->order_by('last_login desc');
        $this->db->limit($limit);
        return parent::get();
	}



}