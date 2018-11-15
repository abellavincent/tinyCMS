<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller{

	public $theme;  //north_shore


	public function __construct(){
		parent::__construct();

		$this->load->module('page');
        $this->load->module('blog');
        $this->load->model('menus/Menus_model');
        
        $this->load->model('settings/Settings_model');
        $this->load->model('gallery/uploads_model');
        $this->load->model('themes/Theme_options_model'); 
               
        $this->set_theme();
        $this->data['theme_name'] = $this->theme;
        $this->data['top_menu_left'] = $this->Menus_model->get_menus(7);
        $this->data['top_menu_right'] = $this->Menus_model->get_menus(8);
        $this->data['mobile_menu'] = $this->Menus_model->get_menus(9);
        $this->data['settings'] = $this->Settings_model->get_settings();
        $this->data['theme_options'] = $this->Theme_options_model->get_theme_options();
        $this->load->library('pagination');
	}


    /**
     * Set Global Themes
    */
    public function set_theme(){
        $this->load->model('themes/Themes_model');
        $this->theme = $this->Themes_model->get_active_theme();
    }



    /**
     * System FrontEnd Mailer
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