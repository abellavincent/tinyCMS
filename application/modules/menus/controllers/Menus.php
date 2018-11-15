<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Frontend_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('menus_model');
        $this->load->model('menu_type_model');
    }

}