<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Frontend_Controller {
	
	function __construct(){
        parent::__construct();
      	$this->load->model('Blog_model');
        $this->load->model('Blog_categories_model');
        $this->load->model('Blog_category_model');
    } 
	


    public function index(){
        
        $this->paginate_all_blogs();
        $this->data['theme_name'] = $this->theme;
        $this->data['heading_type'] = "Blogs";

        //set open graph
        $open_graph = array(
            'title' => 'All Posts', //constructor settings data
            'url' => base_url().'blogs',
            'image' => $this->data['settings']->cover_image,
            'description' => strip_tags(truncateStringWords($this->data['settings']->tagline, 300))
        );
        $this->data['open_graph'] = $open_graph;

        $this->load->ext_view('../themes/'.$this->theme, 'blogs_list', $this->data);
    }



    /**
     * Get Blog Posts
     * @param $id as NULL
     * @return data array
     * @uses frontend blog data display
    */
    public function get_posts($id = NULL){
        if($id){
            $this->db->where('blog.status', 'publish');
            return $this->Blog_model->get($id);
        }else{
            $this->db->where('blog.status', 'publish');
            $this->db->join('users', 'blog.author_id = users.id', 'inner');
            return $this->Blog_model->get();
        }
        
    }




    /**
     * Get Recent Posts
     * @param $limit 
     * @return data array
     * @uses homepage recent posts, sidebar
    */
    public function get_recent_posts($limit){
        $this->db->select('blog.id  as id, username, date_published, title, content, blog.image as image, image_thumb, slug');
        $this->db->where('blog.status', 'publish');
        $this->db->order_by('blog.id desc');
        $this->db->limit($limit);
        $this->db->join('users','blog.author_id = users.id', 'inner');
        $data = $this->Blog_model->get();
        return $data;
    }




    /**
     * Get Posts by Category
     * @return data array
     * @param $category slug
     * @uses frontend data display
    */
    public function get_posts_by_category($category){ 
        //return $this->Blog_model->get_post_by_category($category);
        $this->paginate_blogs_category($category);
    }



    /**
     * Pagination for Blogs by Category
     * @return paginations
     * @uses display of all blogs by category
    */
    public function paginate_blogs_category($category){
        $config = array();
        $config["base_url"] = base_url() . "category/post/". $category;
        $total_row = $this->Blog_model->count_post_by_category($category);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 9;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
        $this->data['posts_by_category'] = $this->Blog_model->get_post_by_category($category, $config["per_page"], $page * $config['per_page']);
        $this->data['category_name'] = $this->data['posts_by_category'][0]->category_name;
        $this->data['pagination'] = $this->pagination->create_links();

        $data = array(
            'posts_by_category' => $this->data['posts_by_category'],
            'category_name' => $this->data['category_name'],
            'pagination' => $this->data['pagination']
        );
        
        return $data;
    }







    /**
     * Get the number of posts
     * @return posts_count
     * @uses pagination, etc
    */
    public function get_count_posts(){
        $this->db->select("SUM(IF(STATUS = 'publish',1,0)) AS 'totalPublish', SUM(IF(STATUS = 'draft',1,0)) AS 'totalDraft', SUM(IF(STATUS = 'trash',1,0)) AS 'totalTrash', SUM(IF(STATUS = 'publish' OR STATUS='draft' ,1,0)) AS 'All'"); 
        $data_array = $this->Blog_model->get();
        return $data_array;
     
    }



    


    /**
     * Pagination for All Blogs
     * @return paginations
     * @uses display of all blogs
    */
    public function paginate_all_blogs(){
        $config = array();
        $config["base_url"] = base_url() . "blogs/";
        $total_row = $this->Blog_model->count_all_blogs();
        $config["total_rows"] = $total_row;
        $config["per_page"] = 12;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;
        $this->data['blogs'] = $this->Blog_model->get_all_blogs($config["per_page"], $page * $config['per_page']);
        $this->data['pagination'] = $this->pagination->create_links();

    }






    /**
     * Get Categories Count
     * @return data array
     * @uses sidebar view post by category
    */
    public function get_categories_count(){
        $categories = $this->Blog_categories_model->get_category();
        $data = array();
        foreach ($categories as $category) {
            $count = count($this->Blog_category_model->get_count_post_by_category($category->id));
            if($count > 0){
                $data_arr = (object) array(
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'category_slug' => $category->slug,
                    'category_count' => $count,
                );

                $data[] = $data_arr;
            }
        }

        return $data;
    }






    /**
     * Search Post Articles
     * @return data array
     * @uses frontend search
    */
    public function search_post(){
        $keyword = $this->security->xss_clean($this->input->post('keyword'));
       
        
        $this->data['theme_name'] = $this->theme;
        $this->data['heading_type'] = "Search Result";

         //set open graph
        $open_graph = array(
            'title' => 'Search', //constructor settings data
            'url' => base_url().'blogs',
            'image' => $this->data['settings']->cover_image,
            'description' => strip_tags(truncateStringWords($this->data['settings']->tagline, 300))
        );
        $this->data['open_graph'] = $open_graph;

        $this->data['blogs'] = $this->Blog_model->search_posts($keyword);
        $this->data['keyword'] = $keyword;
        $this->data['count'] = count($this->Blog_model->search_posts($keyword));
        
        $this->load->ext_view('../themes/'.$this->theme, 'search_result', $this->data);
    }


}