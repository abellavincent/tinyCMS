<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_category_model extends MY_Model {

	protected $_table_name = 'blog_category';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }




   /**
    * Check Blog Category Exist
    * @param $category_id, $blog_id
    * @return blog category ids
    * @uses add new post, edit post
   */
    public function chkCatBlogExist($category_id, $blog_id){
    	$this->db->where('category_id', $category_id);
    	$this->db->where('blog_id', $blog_id);
    	
   		$data = parent::get();
   		return count($data);
    }





    /**
     * Get Category by Id
     * @param $blog_id
     * @return $category_id
     * @uses add post, edit post
    */
    public function getCategoryById($blog_id){
    	$this->db->where('blog_id', $blog_id);
		$getcategory = parent::get();
		return $getcategory;
    }




    /**
     * Delete all blog_category associated to $category_id and $blog id
     * @param $category_id, $blog_id
     * @uses update post
    */
    public function deleteCategory($category_id, $blog_id){
    	$this->db->where('category_id', $category_id);
    	$this->db->where('blog_id', $blog_id);
    	$this->db->delete($this->_table_name);

    }



    /**
     * Delete Category where $blog_id
     * @param $blog_id
     * @uses edit post
    */
    public function deleteCategoryById($blog_id){
        $this->db->where('blog_id', $blog_id);
        $this->db->delete($this->_table_name);
    }




    /**
     * Get the number of post by category id
     * @param $category_id
     * @return data array
     * @uses get categories count
    */
    public function get_count_post_by_category($category_id){
        $this->db->where('category_id', $category_id);
        return parent::get();
    }

}