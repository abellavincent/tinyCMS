<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends MY_Model {

	protected $_table_name = 'blog';
	protected $_order_by = 'id desc';

	function __construct(){
        parent::__construct();
    }



    /**
     * Search Post
     * @param $keyword 
     * @return search result
    */
    public function search_posts($keyword){
    	if(empty($keyword))
       		return array();

	    $result = $this->db->like('title', $keyword);
        $result = $this->db->limit(10)->get($this->_table_name);

    	return $result->result();
    	$this->db->reset();
    }




    /**
     * Set Query
     * @uses Admin Query
    */
    public function set_query(){
    	$this->db->select("GROUP_CONCAT(categories.name SEPARATOR ', ') AS catname, blog.`id` as id, title, content, blog.`status` as status, blog.`image` as image, blog.`image_thumb` as image_thumb, blog.`date_created`, blog.`date_published` as date_published, blog.`date_modified` as date_modified, blog.`last_modified_by` as last_modified_by, blog.`slug` as slug, username");
        $this->db->join('users', 'blog.author_id=users.id', 'inner');
        $this->db->join('blog_category', 'blog.id=blog_category.blog_id', 'left');
        $this->db->join('categories', 'blog_category.category_id=categories.id', 'inner');
        $this->db->group_by('id');
        $this->db->order_by('id desc');
    }


    /**
     * Datatables Server Side Processing
     * @return json
     * @uses datatables display
    */ 
    // public function get_blogs($start, $length){
    //     $this->set_query();
    //     $this->db->limit($length,$start);
    //     return parent::get();
    // }

    
    // public function get_total_blogs($status){
    //     $this->db->where('blog.status', $status);
    //     $data = parent::get();
    //     if(!empty($data)){
    //         return count($data);
    //     }else{
    //         return 0;
    //     }
    // }




    /**
     * Get Posts Content
     * @param $id as NULL
     * @return blog posts 
    */
    public function get_posts($id = NULL){
        $this->db->where('status', 'publish');
        $this->db->order_by('id desc');

        if($id){
            $this->db->where('id', $id);
        }
        return parent::get();
    }

    


    /**
     * Set Display Query
     * @uses FrontEnd Query
    */
    public function set_display_query(){
        $this->db->select('blog.id AS id, title, blog.slug AS slug, content, blog.status AS status, date_published, blog.image AS image, blog.image_thumb AS image_thumb, first_name, last_name, username, categories.name AS category_name');
        $this->db->join('blog_category', 'blog.id=blog_category.blog_id', 'inner');
        $this->db->join('categories', 'categories.id=blog_category.category_id', 'inner');
        $this->db->join('users', 'users.id=blog.author_id', 'inner');
        $this->db->where('blog.status', 'publish');
        $this->db->order_by('blog.id desc');
    }





    /**
     * Get Posts by Category
     * @param $category as category_slug
     * @return blog posts
     * @uses Public View > post by category
    */  
    public function get_post_by_category($category, $limit, $page){
        $this->set_display_query();
        $this->db->where('categories.slug', $category);
        $this->db->limit($limit, $page);
        return parent::get();
    }


    public function count_post_by_category($category){
        $this->set_display_query();
        $this->db->where('categories.slug', $category);
        return count(parent::get());
    }




    /**
     * Get Recent Post
     * @param $limit
     * @return object array
     * @uses global
    */
    public function get_recent_post($limit){
        $this->db->where('status', 'publish');
        $this->db->order_by('id desc');
        $this->db->limit($limit);
        return parent::get();
    }





    /**
     * Check if the Post is already published
     * @param $post_id
     * @return date
     * @uses update post
    */
    public function is_blog_published($post_id){
        $this->db->select('status, date_published');
        $this->db->where('id', $post_id);
        $post = parent::get();
    
        if(($post[0]->status = 'publish') && ($post[0]->date_published != '0000-00-00 00:00:00')){
            return $post[0]->date_published;
        }else{
            return date("Y-m-d H:i:s");
        }
    }






    /**
     * Get Blogs for FrontEnd Display
     * @param $limit, $page
     * @return data array
     * @uses get all display
    */
    public function get_all_blogs($limit, $page){
        $this->db->where('blog.status', 'publish');
        $this->db->limit($limit, $page);
        return $data = parent::get();
    }


    public function count_all_blogs(){

        $this->db->where('status', 'publish');
        return count(parent::get());
    }

}