<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries extends Frontend_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('inquiries_model');	

    }


    public function save(){
       
        
    	if($this->input->post('form_submit')){
    		$name = xss_clean($this->input->post('name'));
    		$email = xss_clean($this->input->post('email'));
    		$contact = xss_clean($this->input->post('contact'));
    		$message = xss_clean($this->input->post('message'));
    		$date_now = date('Y-m-d H:i:s');

    		if($this->input->post('subject')){
    			$subject = xss_clean($this->input->post('subject'));
    		}else{
    			$subject = 'Inquiry';
    		}

    		$data = array(
    			'name' => $name,
    			'email' => $email,
    			'contact' => $contact,
    			'message' => $message,
    			'date_sent' => $date_now,
    			'status' => 'new',
    			'subject' => $subject,
    		);

    		$isSave = $this->inquiries_model->save($data);


    		if($isSave){
                $this->mailer($this->data['settings']->email, 'New Email Inquiry - '.$this->data['settings']->site_name, 'New email inquiry has been sent in our website. <br>Login now to read and reply to messages. <br> Login Now: '.base_url().'admin');
                echo json_encode(array(
                    'success' => TRUE
                ));
            }
    		else{
    			echo json_encode(array('success' => FALSE));
            }
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }



}