<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('User_model');	
        $this->check_module_permission('users');// check module permission
    }




	public function index(){	
		$this->_get_users('all');
		$this->data['users_count'] = $this->get_count_users();

		$this->data['subview'] = 'admin/index';
		$this->load->view('admin/_main_layout', $this->data);	
	}




	/**
	 * Get Users 
	 * @param $role
	 * @return user data by role
	 * @uses loadview
	*/
	public function _get_users($role){
		//$this->set_pagination($role);
		$this->User_model->set_query();

		if($role){
            switch($role){
                case 'all':{
                    $this->db->where("(user_role.name='Administrator' OR user_role.name='Editor' OR user_role.name='User')");
                    break;
                }
                case 'administrator':{
                    $this->db->where("user_role.name", 'Administrator');
                    break;
                }
                case 'editor':{
                     $this->db->where("user_role.name", 'Editor');
                    break;
                }
               	case 'user':{
                     $this->db->where("user_role.name", 'User');
                    break;
                }
                default:{
                    redirect('admin/users');
                }
            }
        }
        

        $this->data['users'] = $this->User_model->get();
	}






	/**
	 * Get Users by Role
	 * @param @role
	 * @uses user display 
	*/
	public function user_by_role($role){
        $this->data['users_count'] = $this->get_count_users();

        $this->_get_users($role);
        
        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }






    /**
	 * Get Users count by role
	 * @uses pagination
    */
    public function get_count_users(){
        $this->db->select("COUNT(*) AS 'All', SUM(IF(NAME = 'Editor',1,0)) AS 'totalEditors', SUM(IF(NAME = 'Administrator',1,0)) AS 'totalAdmins', SUM(IF(NAME = 'User',1,0)) AS 'totalUser'");
        $this->db->join('user_role', 'users.role_id=user_role.id', 'inner'); 
        $data_array = $this->User_model->get();
        return $data_array;
        $this->db->reset(); //reset all queries

    }





    /**
	 * Search Users
	 * @param POST data > keyword
	 * @return search result
	 * @uses loadview, users
    */
    public function search(){
		if($this->input->post('form_submit')){
            $this->data['users_count'] = $this->get_count_users();
            $keyword = xss_clean($this->input->post('search-keyword'));
            $this->User_model->set_query();
            $this->data['users'] = $this->User_model->search_users($keyword);
            $this->data['keyword'] = $keyword;
            $this->data['is_search'] = TRUE;
            $this->data['results_count'] = count($this->data['users']); 

        }else{
            redirect('admin/users');
        }

        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
	}





	/**
	 * Set Users Pagination
	 * @param $role
	 * @return pagination links
	 * @uses users admin display
	*/
	public function set_pagination($role){
        $users_count = $this->get_count_users(); //get user count

        //get the total number of rows per user role
        switch($role){
            case 'all':{
                $count = $users_count[0]->All;
                break;
            }
            case 'administrator':{
                $count = $users_count[0]->totalAdmins;
                break;
            }
            case 'editor':{
                $count = $users_count[0]->totalEditors;
                break;
            }
            case 'user': {
                $count =$users_count[0]->totalUser;
                break;
            }
            default:{
                return FALSE;
            }
        }
        

        // pagination settings
        $perpage = 10;
        if($count > $perpage){
            $this->load->library('pagination');
            $config['base_url'] = site_url('admin/users/role/'. $role .'/');
            $config['total_rows'] = $count;
            $config['per_page'] = $perpage;
            $config['uri_segment'] = 5;
			$config["num_links"] = 3;

            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $offset = ($this->uri->segment(5) != NULL ? $this->uri->segment(5) - 1 : $this->uri->segment(5));
            $this->db->limit($perpage, $offset);
 
        }else{
            $this->data['pagination'] = '';
            $offset = 0;
        }
        
    }






	/**
	 * User Login
	 * @uses user login
	*/
	public function login(){
		$dashboard = 'admin/dashboard';
		$this->User_model->loggedin() == FALSE || redirect($dashboard);

		$rules = $this->User_model->rules;
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == TRUE){
			if($this->User_model->login() == TRUE){
				redirect($dashboard);
			}else{
				$this->session->set_flashdata('error', 'Login Failed: Please check your username or password.');
				redirect('admin/login', 'refresh');
			}
		}

		$this->load->view('admin/_login_layout', $this->data);
	}






	/**
	 * User Logout
	 * @uses clear user session
	*/
	public function logout(){
		$this->User_model->logout();
		redirect('admin/login');
	}





	/**
	 * Add New User
	 * @uses loadview, add user form
	*/
	public function add_user(){
		$this->data['user_role'] = $this->db->get('user_role')->result();

		$this->data['subview'] = 'admin/add_user';
		$this->load->view('admin/_main_layout', $this->data);
	}






	/**
	 * Edit User
	 * @param $id as user id
	 * @return user content
	 * @uses edit user form
	*/
	public function edit($id){
		$this->data['user_role'] = $this->db->get('user_role')->result();

		if($id){
			$this->data['user'] = $this->User_model->get($id);
			count($this->data['user']) || redirect('admin/users');
		}else{
			redirect('admin/users');
		}

		$this->data['subview'] = 'admin/edit_user';
		$this->load->view('admin/_main_layout', $this->data);
	}





	/**
	 * Save New User
	 * @param POST data array
	 * @return json
	 * @uses add new user form
	*/
	public function save(){
		$date_created = date('Y-m-d H:i:s');
		$modified_by = $this->session->userdata('username');
		$image = site_url('assets/images/default-profile-pic.png'); //default image

		$data = array(
			'username' => xss_clean($this->input->post('username')), 
			'first_name' => xss_clean($this->input->post('first_name')), 
			'last_name' => xss_clean($this->input->post('last_name')), 
			'email' => xss_clean($this->input->post('email')),
			'password' => xss_clean($this->User_model->hash($this->input->post('password'))),
			'role_id' => xss_clean($this->input->post('role_id')),
			'status' =>   xss_clean($this->input->post('status')),
			'date_created' => $date_created,
			'modified_by' => $modified_by,
			'image' => $image,
		);
		

		$isSave = $this->User_model->save($data);
		$id =  $this->db->insert_id();

		if($isSave == TRUE){
			echo json_encode(array(
				'success' => TRUE,
				'id' => $id, 
			));

		}else{
			echo json_encode(array('success' => FALSE));
		}
	}






	/**
	 * Update User Info
	 * @param POST data array
	 * @return json
	 * @uses edit user form, backend
	*/
	public function update(){
		$user_id = (int) $this->input->post('user_id');
		$date_modified = date('Y-m-d H:i:s');
		$modified_by = $this->session->userdata('username');

		if(strlen($this->input->post('password')) == 0){
			$data = array( 
				'first_name' => xss_clean($this->input->post('first_name')), 
				'last_name' => xss_clean($this->input->post('last_name')), 
				'email' => xss_clean($this->input->post('email')),
				'role_id' => xss_clean($this->input->post('role_id')),
				'status' => xss_clean($this->input->post('status')),
				'date_modified' => $date_modified,
				'modified_by' => $modified_by,
			);
		}else{
			$data = array( 
				'first_name' => xss_clean($this->input->post('first_name')), 
				'last_name' => xss_clean($this->input->post('last_name')), 
				'email' => xss_clean($this->input->post('email')),
				'role_id' => xss_clean($this->input->post('role_id')),
				'status' => xss_clean($this->input->post('status')),
				'date_modified' => $date_modified,
				'modified_by' => $modified_by,
				'password' => xss_clean($this->User_model->hash($this->input->post('password'))),
			);
		}
		

		$isUpdate = $this->User_model->save($data, $user_id);
		echo json_encode(array(
			'id' => $user_id,
			'success' => ($isUpdate == TRUE) ? 'true':'false',
		));
	}





	/**
	 * Delete User
	 * @param POST data
	 * @return json
	 * @uses delete user
	*/
	public function delete(){
		$user_id = (int) $this->input->post('user_id');
		$isDelete = $this->User_model->delete($user_id);

		echo json_encode(array(
			'id' => $user_id,
			'success' => TRUE,
		));
	}
		




	/**
	 * Check Username Exist
	 * @param POST data > username
	 * @return json
	 * @uses create user, ajax
	*/
	public function is_username_exist(){
		$username = xss_clean($this->input->post('username'));

		$user = $this->User_model->get_by(array(
			'username' => $username,
		), TRUE);

		if(count($user)){
			echo json_encode(array('exist' => TRUE));
		}else{
			echo json_encode(array('exist' => FALSE));
		}
	}






	/**
	 * Users Profile
	 * @uses form loadview
	*/
	public function profile(){
		$user_id = $this->session->userdata('id');
		$this->data['user'] = $this->User_model->get($user_id);

		$this->data['subview'] = 'admin/profile';
		$this->load->view('admin/_main_layout', $this->data);
	}




	/**
     * Update User Profile > Avatar
     * @param POST data
     * @return json
     * @uses edit profile change avatar
    */
    public function update_avatar(){
        if($this->input->post('form_submit')){
            $image = $this->input->post('image');
            $user_id = (int) $this->session->userdata('id');

            $data = array(
            	'image' => $image
            );

            $isUpdate = $this->User_model->save($data, $user_id);
            if ($isUpdate) {
            	echo json_encode(array('success' => TRUE));
            }else{
            	echo json_encode(array('success' => FALSE));
            }

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }




    /**
	 * Update User Profile > Info
	 * @param POST data
	 * @return json
	 * @uses edit user info
    */
    public function update_user_info(){
    	if($this->input->post('form_submit')){
    		$user_id = (int) $this->session->userdata('id');
    		$email = xss_clean($this->input->post('email'));
    		$first_name = xss_clean($this->input->post('first_name'));
    		$last_name = xss_clean($this->input->post('last_name'));

    		$data = array(
    			'email' => $email,
    			'first_name' => $first_name,
    			'last_name' => $last_name,
    		);	

    		$isUpdate = $this->User_model->save($data, $user_id);
    		if($isUpdate){
    			echo json_encode(array('success' => TRUE));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }





    /**
	 * Update User Profile > Change Password
	 * @param POST data
	 * @return json
	 * @uses edit profile change password
    */
    public function change_password(){
    	if($this->input->post('form_submit')){
    		$user_id = (int) $this->session->userdata('id');
    		$old_password = xss_clean($this->input->post('old_password'));
    		$new_password = xss_clean($this->input->post('new_password'));

    		//get user base on old_password
    		$check_password = $this->User_model->get_by(array(
    			'password' => $this->User_model->hash($old_password),
    			'id' => $user_id
    		), TRUE);
    		
    		//check old password if match
    		if(count($check_password)){
    			$data = array(
    				'password' => $this->User_model->hash($new_password)
    			);

    			$isUpdate = $this->User_model->save($data, $user_id);
    			if($isUpdate){
    				echo json_encode(array('success' => TRUE)); 
    			}else{
    				echo json_encode(array('success' => FALSE));
    			}
    		}else{
    			echo json_encode(array('success' => 'authenticate_failed'));
    		}

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }


}