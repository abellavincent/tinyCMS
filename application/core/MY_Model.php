<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	public $rules = array();
	


	function __construct(){
		parent::__construct();
	}




	/**
	 * Format Array Post
	 * @param $fields
	*/
	public function array_from_post($fields){
		$data = array();
		foreach($fields as $field){
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}





	/**
	 * Get Data
	 * @param $id, $single
	 * @return object array
	 * @uses global
	*/
	public function get($id = NULL, $single = FALSE){
		if($id != NULL){
			$filter = $this->_primary_filter;
			$id  = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = "row"; //returns single row of data
		}else if($single == TRUE){
			$method = "row"; //returns single row of data
		}else{
			$method = "result"; // returns results set
		}

		if(!count($this->db->order_by($this->_order_by))){
			$this->db->order_by($this->_order_by);
		}

		return $this->db->get($this->_table_name)->$method();
	}






	/**
	 * Get Data by column
	 * @param $where, $single
	 * @return object array
	*/ 
	public function get_by($where, $single = FALSE){
		$this->db->where($where);
		return $this->get(NULL, $single);
	}





	/**
	 * Save or Update Data
	 * @param $data, $id
	 * @return $id
	 * @uses global
	*/
	public function save($data, $id = NULL){
		// insert data if no $id
		if($id === NULL){
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);	
			$id = $this->db->insert_id();
		}

		// update data if has $id
		else{
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}

		return $id;
	}




	/**
	 * Delete Data
	 * @param $id
	 * @uses global
	*/
	public function delete($id){
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if(!$id){
			return FALSE;
		}

		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
	}



	/**
	 * Slug Writer - check for duplicate slug
	 * @param $slug
	 * @return $slug + timestamp, $slug
	*/
	public function slug_writer($slug){
		$this->db->where('slug', $slug);
		$count = $this->db->get($this->_table_name)->num_rows();
		if($count){
			$date = date_create(); //get date
			$timestamp = date_timestamp_get($date);	//get timestamp
			return $slug .'-'. $timestamp;
		}else{
			return $slug;
		}
	}



}