<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller{

	public function __construct(){
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('user/User_model');
		$this->load->module('gallery/admin/gallery');
		$this->load->model('settings/Settings_model');
		$this->data['settings'] = $this->Settings_model->get_settings(); //get all settings
		$this->data['meta_title'] = $this->data['settings']->site_name;
		$this->get_menu();
		

		// Login check
		$exception_uris = array(
			'admin/login',
			'admin/logout',
			'admin/user/forgot_password',
			'admin/user/reset_password',
		);
		if(in_array(uri_string(), $exception_uris) == FALSE){
			if($this->User_model->loggedin() == FALSE){
				redirect('admin/login');
			}
		}
		
	}





	/**
	 * Image Uploader
	 * @param POST data image
	 * @return json image_url, thumb_url
	 * @uses upload image, global
	*/
	public function upload_image(){
		$new_name = time().'_'.$_FILES["photoimg"]['name'];

		$config = array(
			'upload_path' => "./uploads/original/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => TRUE,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'file_name' => $new_name
		);
			
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		
		if($this->upload->do_upload('photoimg')){
			$image_data = array('upload_data' => $this->upload->data());

			$image_path = $image_data['upload_data']['full_path'];
			

			//upload thumbnails
			$config = array(
				'image_library' => 'gd2',
		    	'source_image'      => $image_path, //path to the uploaded image
		    	'new_image'         => "./uploads/thumbs/", //path to thumbs folder
		    	'maintain_ratio'    => TRUE,
		    	'width'             => 400,
		    	'height'            => 400,
		      
		    );
		    $this->image_lib->initialize($config);
    		$this->image_lib->resize();
    		
    		//return urls 
    		$thumb_url = 'uploads/thumbs/'. $image_data['upload_data']['file_name']; 
    		$image_url = 'uploads/original/'. $image_data['upload_data']['file_name']; 

			$image_urls = array(
				'image_url' => $image_url,
				'thumb_url' => $thumb_url,
			);

			echo json_encode($image_urls);
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		}
		
	}




	/**
     * File Uploader
     * @param POST data file
     * @return json file_url
     * @uses upload files, global
    */
    public function upload_files(){
        $new_name = time().'_'.$_FILES["photoimg"]['name'];

        $config = array(
            'upload_path' => "./uploads/files/",
            'allowed_types' => "doc|docx|pdf",
            'overwrite' => TRUE,
            'max_size' => "10048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'file_name' => $new_name
        );
            
        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('photoimg')){
            $image_data = array('upload_data' => $this->upload->data());

            //return urls 
            $image_url = 'uploads/files/'. $image_data['upload_data']['file_name'];
            $image_filename =  $image_data['upload_data']['file_name'];

            $image_urls = array(
                'file_url' => $image_url,
                'file_name' => $image_filename
            );

            echo json_encode($image_urls);
        }
        else{
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }
        
    }






	/**
	 * Froala Image Uploader
	 * @param POST data image
	 * @return json image_url
	 * @uses froala editor > insert image
	*/
	public function froala_upload_image(){
		$new_name = time().'_'.$_FILES["file"]['name'];

		$config = array(
			'upload_path' => "./uploads/original/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => TRUE,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'file_name' => $new_name
		);
			
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		
		if($this->upload->do_upload('file')){
			$image_data = array('upload_data' => $this->upload->data());

			$image_path = $image_data['upload_data']['full_path'];
			

			//upload thumbnails
			$config = array(
				'image_library' => 'gd2',
		    	'source_image'      => $image_path, //path to the uploaded image
		    	'new_image'         => "./uploads/thumbs/", //path to thumbs folder
		    	'maintain_ratio'    => TRUE,
		    	'width'             => 400,
		    	'height'            => 400,
		      
		    );
		    $this->image_lib->initialize($config);
    		$this->image_lib->resize();
    		
    		//return urls 
    		$thumb_url = site_url() . 'uploads/thumbs/'. $image_data['upload_data']['file_name']; 
    		$image_url = site_url() . 'uploads/original/'. $image_data['upload_data']['file_name']; 

			$image_urls = array(
				'image_url' => $image_url,
				'thumb_url' => $thumb_url,
			);

			//echo json_encode($image_urls);
			// Generate response.
		    $response = new StdClass;
		    $response->link = $image_url;
		    echo stripslashes(json_encode($response));
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		}
		
	}





	/**
	 * Image Multiple Uploader
	 * @param images array
	 * @return json
	 * @uses gallery image multiple upload
	*/
	public function image_multiple_uploader(){
		$data = array();
		$type = $this->input->post('type');
		$post_id = $this->input->post('post_id');

		if(!empty($_FILES['photoimgs']['name'])){
            $filesCount = count($_FILES['photoimgs']['name']);

            //load through images array
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['photoimg']['name'] = $_FILES['photoimgs']['name'][$i];
                $_FILES['photoimg']['type'] = $_FILES['photoimgs']['type'][$i];
                $_FILES['photoimg']['tmp_name'] = $_FILES['photoimgs']['tmp_name'][$i];
                $_FILES['photoimg']['error'] = $_FILES['photoimgs']['error'][$i];
                $_FILES['photoimg']['size'] = $_FILES['photoimgs']['size'][$i];


                $new_name = time().'_'.$_FILES['photoimg']['name']; //rename image filename

                $config = array(
					'upload_path' => "./uploads/original/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => TRUE,
					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'file_name' => $new_name
				);
                
                //upload original image
                $this->load->library('upload', $config);
                $this->load->library('image_lib');

                $this->upload->initialize($config);

                if($this->upload->do_upload('photoimg')){

                	//create thumbnails
                    $image_data = array('upload_data' => $this->upload->data());
                    $image_path = $image_data['upload_data']['full_path'];
                    $filename = $image_data['upload_data']['file_name'];

                    $config = array(
						'image_library' => 'gd2',
				    	'source_image'      => $image_path, //path to the uploaded image
				    	'new_image'         => "./uploads/thumbs/", //path to thumbs folder
				    	'maintain_ratio'    => TRUE,
				    	'width'             => 400,
				    	'height'            => 400,
				    );

                    $this->image_lib->initialize($config);
				    $this->image_lib->resize();

		    		/*$img_thumb = './uploads/thumbs/'. $image_data['upload_data']['file_name']; 

                    //resize
                    $this->image_lib->initialize($config);
				    $this->image_lib->resize();


				    //crop
                    $crop_config = array(
						'image_library' => 'gd2',
						'source_image' => $img_thumb,
						'create_thumb' => FALSE,
						'maintain_ratio' => FALSE,
						'width' => 200,
						'height' => 200,
						'x_axis' => 0,
						'y_axis' => 0,
                    );

                    $this->image_lib->initialize($crop_config);
		    		$this->image_lib->crop();*/
                    //end create thumbnails


                    $thumb_url = 'uploads/thumbs/'. $image_data['upload_data']['file_name']; 
		    		$image_url = 'uploads/original/'. $image_data['upload_data']['file_name']; 

					$image_urls = array(
						'image_url' => $image_url,
						'thumb_url' => $thumb_url,
					);

					//save to uploads db
					$this->gallery->save_images($image_url, $thumb_url, $type, $post_id, $filename);

					$data[] = $image_urls;

                }
            }

            echo json_encode($data);
        }
	}







	/**
	 * Check User Module Permission
	 * @param $module_request as keyword
	 * @uses global
	*/
	public function check_module_permission($module_request){
		//Check module permission 
        $role_id = $this->session->userdata('role_id');
        $this->User_model->isModulePermissionAllowed($role_id, $module_request);
	}







	/**
	 * Get Module Access of Currently Logged In User
	 * @return bool, menu_items array
	 * @uses admin navigation, admin global
	*/
	public function get_menu(){
		if($this->session->userdata('username')){
			$this->load->model('menus/menus_model');
			$results = $this->menus_model->get_menu();
			$menu_type_id = $results[0]->menu;

			$this->data['admin_menu'] = $this->menus_model->get_menu_items($menu_type_id);
		}else{
			return FALSE;
		}
		
	}

	




	/**
	 * Check if user who loggedin is Administrator
	 * @uses global 
	 * @return user boolean
	*/
	public function is_admin(){
		$role = $this->session->userdata('user_role');
		if($role == "Administrator"){
			return TRUE;
		}else{
			return FALSE;
		}
	}





	/**
	 * System Admin Mailer
	 * @param $to = person to recieve the email
	 * @param $subject = email subject line
	 * @param $message = email content
	 * @return boolean
	 * @uses global mailer
	*/
	public function mailer($to, $subject, $message){
		$mail_from_email = $this->data['settings']->mail_from_email;
		$mail_from_name = $this->data['settings']->mail_from_name;

		$smtp_protocol = $this->data['settings']->smtp_protocol;
		$smtp_host = $this->data['settings']->smtp_host;
		$smtp_port = $this->data['settings']->smtp_port;
		$smtp_user = $this->data['settings']->smtp_user;
		$smtp_pass = $this->data['settings']->smtp_pass;
		

		try{
			$config = array(
				'protocol' => $smtp_protocol,
				'smtp_host' => $smtp_host,
				'smtp_port' => $smtp_port,
				'smtp_user' => $smtp_user,
				'smtp_pass' => $smtp_pass
			);
		
			$this->load->library('email');
			$this->email->initialize($config);
			
			$this->email->set_newline("\r\n");
			$this->email->set_mailtype("html");
			
			$this->email->from($mail_from_email, $mail_from_name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send()){
				return TRUE;
			}else{
				//show_error($this->email->print_debugger());
				return FALSE;
			}
		
		}catch(Exception $e){
			//echo "ERROR HEREY:".$e->getMessage(); 
			return FALSE;
		}
	}



}
