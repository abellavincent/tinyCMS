<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_categories_model extends MY_Model {

	protected $_table_name = 'categories';
	protected $_order_by = 'name asc';

	function __construct(){
        parent::__construct();
    }




    /**
     * Get All Form Categories - Blog
     * @return blog categories
     * @uses add new post, edit post
    */
    public function form_categories(){
    	$this->db->where('type =', 'blog');
    	$this->db->where('parent_id =', 0);
    	$categories = parent::get();
    	return $categories;
    }





    /**
     * Get All Category or by $id
     * @param $id
     * @return object array
    */
    public function get_category($id = NULL){
        if($id){
            $this->db->where('id', $id);
        }
        $this->db->where('type =', 'blog');
        $this->db->where('parent_id =', 0);
        return parent::get();
    }



    /**
     * Delete Category
     * @param $id
     * @uses blog categories
    */
    public function delete($id){
		parent::delete($id);

		// Reset parent_id for its children
		$this->db->set(array('parent_id' => 0));
		$this->db->where('parent_id', $id);
		$this->db->update($this->_table_name);
    }

}