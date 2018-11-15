<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_options_model extends MY_Model {

	protected $_table_name = 'theme_options';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }


    /**
	 * Get Theme Options
	 * @param $type 
	 * @return json array
	 * @uses theme options settings, global
    */
    public function get_theme_options($type = NULL){
    	if($type){
    		$this->db->where('type', $type);
    	}

    	$data = parent::get();
    	$array = array();
    	foreach ($data as $key => $value) {
    		$array[$value->name] = $value->value;
    	}

    	return json_decode(json_encode($array));
    }


    /**
	 * Update Theme Options General Information
	 * @param POST data
	 * @return json
	 * @uses save options > general information, controller
    */
    public function save_options($field, $value){
    	$data = array(
    		'value' => $value,
    	);
    	$this->db->set($data);
    	$this->db->where('name', $field);
    	$this->db->update($this->_table_name);
    }

}