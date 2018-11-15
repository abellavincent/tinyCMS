<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('Settings_model');
        $this->check_module_permission('settings');// check module permission
    }



    public function index(){
    	$this->data['settings'] = $this->Settings_model->get_settings('site_settings');
    	$this->data['subview'] = 'admin/index';
		$this->load->view('admin/_main_layout', $this->data);
    }




    /**
     * Load Mail Settings View
    */
    public function mail_settings(){
        $this->data['settings'] = $this->Settings_model->get_settings('mailer');
        $this->data['subview'] = 'admin/mail_settings';
        $this->load->view('admin/_main_layout', $this->data);
    }



    /**
     * Save Mail Settings
     * @param POST data
     * @return json response
     * @uses mail settings save
    */
    public function save_mail_settings(){
        if($this->input->post('form_submit')){
            $from_email = xss_clean($this->input->post('from_email'));
            $from_name = xss_clean($this->input->post('from_name'));
            $protocol = xss_clean($this->input->post('protocol'));
            $host = xss_clean($this->input->post('host'));
            $port = xss_clean($this->input->post('port'));
            $username = xss_clean($this->input->post('username'));
            $password = xss_clean($this->input->post('password'));


            $data = array(
                'mail_from_email' => $from_email,
                'mail_from_name' => $from_name,
                'smtp_protocol' => $protocol,
                'smtp_host' => $host,
                'smtp_port' => $port,
                'smtp_user' => $username,
                'smtp_pass' => $password,
            );

            //loop through data and perform insert
            foreach ($data as $key => $value) { 
                $isUpdate = $this->Settings_model->save_settings($key, $value);
            }

            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post paramters missing'));
        }
    }




    /**
	 * Update Settings General Information
	 * @param POST data
	 * @return json
	 * @uses save settings > general information
    */
    public function update_general_info(){
    	if($this->input->post('form_submit')){ 
    		$site_name = xss_clean($this->input->post('site_name'));
    		$tagline = xss_clean($this->input->post('tagline'));
    		$base_url = xss_clean($this->input->post('base'));
    		$email = xss_clean($this->input->post('email'));

    		$data = array(
    			'site_name' => $site_name,
    			'tagline' => $tagline,
    			'base_url' => $base_url,
    			'email' => $email,
    		);

    		//loop through data and perform insert
    		foreach ($data as $key => $value) {	
				$isUpdate = $this->Settings_model->save_settings($key, $value);
			}

			echo json_encode(array('success' => TRUE));

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }





    /**
	 * Update New Logo 
	 * @param POST data
	 * @return json
	 * @uses settings save new logo
    */
    public function save_logo(){
    	if($this->input->post('form_submit')){
    		$logo = $this->input->post('logo');
    		$this->Settings_model->save_settings('logo', $logo);
    		echo json_encode(array('success' => TRUE));
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }




    /**
     * Update Favicon Image
     * @param POST data
     * @return json
     * @uses settings save new favicon
    */
    public function save_favicon(){
        if($this->input->post('form_submit')){
            $logo = $this->input->post('favicon');
            $this->Settings_model->save_settings('favicon', $logo);
            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }
}