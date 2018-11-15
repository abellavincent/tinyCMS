<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries_model extends MY_Model {

	protected $_table_name = 'inquiries';
	protected $_order_by = 'id desc';

	function __construct(){
        parent::__construct();
    }



     /**
     * Set Query
     * @uses admin inquiries query
    */
    public function set_query(){
        $this->db->order_by($this->_order_by);
    }





    /**
     * Search Inquiry 
    */
    public function search_inquiry($keyword){
        if(empty($keyword))
            return array();

        $result = $this->db->like('name', $keyword);
        $result = $this->db->limit(10)->get($this->_table_name);

        return $result->result();
        $this->db->reset();
    }

}