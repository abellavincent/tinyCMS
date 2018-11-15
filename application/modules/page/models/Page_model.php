<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends MY_Model {

	protected $_table_name = 'pages';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }



    /**
     * Set Query
     * @uses admin pages query
    */
    public function set_query(){
    	$this->db->select('pages.id as id, date_published, pages.date_created as date_created, title, slug, pages.status as status, username');
        $this->db->join('users', 'pages.author_id=users.id', 'inner');
        $this->db->order_by('pages.id desc');
    }



    /**
     * Search Pages
     * @param @keyword
     * @return object array
     * @uses search form
    */
    public function search_pages($keyword){
        if(empty($keyword))
            return array();

        $result = $this->db->like('title', $keyword);
        $result = $this->db->limit(10)->get($this->_table_name);

        return $result->result();
        $this->db->reset();
    }



    /**
     * Check if the Page is already published
     * @param $page_id
     * @return date
     * @uses update page
    */
    public function is_page_published($page_id){
        $this->db->select('status, date_published');
        $this->db->where('id', $page_id);
        $page = parent::get();
    
        if(($page[0]->status = 'publish') && ($page[0]->date_published != '0000-00-00 00:00:00')){
            return $page[0]->date_published;
        }else{
            return date("Y-m-d H:i:s");
        }
    }
}