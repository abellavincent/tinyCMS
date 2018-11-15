<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Themes_model extends MY_Model {

	protected $_table_name = 'themes';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }




    /**
	 * Get Active Theme
	 * @return active theme name keyword
	 * @uses front end global theme
    */
    public function get_active_theme(){
    	$this->db->where('is_active', 1);
    	$this->db->limit(1);
   	$data = parent::get();
   	$theme_name = $data[0]->keyword;
   	return $theme_name;
    }



    /**
     * Get Active Theme id
     * @return $theme_id
     * @uses deactivate_current_active_theme
    */
    public function get_active_theme_id(){
         $this->db->where('is_active', 1);
         $this->db->limit(1);
         $data = parent::get();
         $theme_id = $data[0]->id;
         return $theme_id;
    }
}