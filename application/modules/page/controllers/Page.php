<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Frontend_Controller {
	
	function __construct(){
        parent::__construct();
      	$this->load->model('page_model');
    } 

    // testing cross-module call for controllers
    public function index(){
    	dump("Page frontend controller is working");
    }

    public function get_pages($id = NULL){
        if($id){
            $this->db->where('status', 'publish');
            return $this->page_model->get($id);
        }else{
            $this->db->where('status', 'publish');
            return $this->page_model->get();
        }
        
    }
}