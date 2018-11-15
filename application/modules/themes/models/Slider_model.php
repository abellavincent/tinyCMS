<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends MY_Model {

	protected $_table_name = 'slider';
	protected $_order_by = 'order_position';

	function __construct(){
        parent::__construct();
    }


    public function get_sliders(){
        $this->db->order_by($this->_order_by);
        return parent::get();
    }

    public function get_slider_greater_than_position($position){
        $this->db->where('order_position >=', $position);
        $this->db->order_by('order_position asc');
        return parent::get();
    }

}