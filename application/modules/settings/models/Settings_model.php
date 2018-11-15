<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends MY_Model {

	protected $_table_name = 'settings';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }




    /**
     * Get Settings Data
     * @param $settings_type
     * @return array object
     * @uses admin settings 
    */
    public function get_settings($settings_type = NULL){
        if($settings_type){
            $this->db->where('type', $settings_type);
        }
    	
    	$data = parent::get();
    	$array = array();
    	foreach ($data as $key => $value) {
    		$array[$value->name] = $value->value;
    	}

    	return json_decode(json_encode($array));
    }




    /**
	 * Update Settings General Information
	 * @param POST data
	 * @return json
	 * @uses save settings > general information, controller
    */
    public function save_settings($field, $value){
    	$data = array(
    		'value' => $value,
    	);
    	$this->db->set($data);
    	$this->db->where('name', $field);
    	$this->db->update($this->_table_name);
    }
}

