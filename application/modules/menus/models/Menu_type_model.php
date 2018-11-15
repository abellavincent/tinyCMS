<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_type_model extends MY_Model {

	protected $_table_name = 'menu_type';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }


    /**
     * Get MIN menu_type, as first display in menus index
     * @return menu_type_id as first_menu
     * @uses Admin Menus index
    */ 
    public function get_min_menu_type(){
    	$this->db->select('MIN(id) as first_menu');
    	$this->db->where('user_role_id', 4); // visitors id
    	$menu = parent::get();
    	return $menu[0]->first_menu;
    }


    /**
     * Get Menu Type where user_role_id = 4, where 4 = visitor
     * @return $menu_types object array
    */
    public function get_menu_type(){
        $this->db->where('user_role_id', 4);
        $menu_types = parent::get();
        return $menu_types;
    }


   

}