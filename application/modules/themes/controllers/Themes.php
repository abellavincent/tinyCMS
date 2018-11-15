<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Themes extends Frontend_Controller {


	function __construct(){
        parent::__construct();
        $this->load->model('themes/Slider_model');
        
    }





    /**
     * Load Active Theme
     * @uses site homepage
    */
    public function index(){
        //set open graph
        $open_graph = array(
            'title' => 'Home',
            'url' => base_url(),
            'image' => $this->data['settings']->cover_image,
            'description' => strip_tags(truncateStringWords($this->data['settings']->tagline, 300))
        );
        $this->data['open_graph'] = $open_graph;

        $this->data['sliders'] = $this->Slider_model->get_sliders();
    	$this->data['pages'] = $this->page->get_pages();
        $this->data['recent_posts'] = $this->blog->get_recent_posts(3);
        $this->data['post_category'] = $this->blog->get_categories_count();
            
    	$this->load->ext_view('../themes/'.$this->theme, 'index', $this->data);
    }





    /**
     * Get Page Single Display
     * @param $id, $slug
     * @return page content, load view
     * @uses themes
    */
    public function page($id, $slug){
        if($id){
            $id = (int) $id;
            $this->data['page'] = $this->page->get_pages($id);
            count($this->data['page']) || show_404(uri_string());

            //get gallery 
            $this->data['gallery'] = $this->uploads_model->get_by(array('post_id' => $id, 'type' => 'page'));


            //set open graph
            $open_graph = array(
                'title' => $this->data['page']->title, //constructor settings data
                'url' => base_url().'page/'. $this->data['page']->id .'/'. $this->data['page']->slug,
                'image' => $this->data['settings']->cover_image,
                'description' => strip_tags(truncateStringWords($this->data['settings']->tagline, 300))
            );
            $this->data['open_graph'] = $open_graph;


            //get categories count
            $this->data['categories_count'] = $this->blog->get_categories_count();

            //get recent posts
            $this->data['recent_posts'] = $this->blog->get_recent_posts(3);

            // Redirect to correct slug if incorrect
            $requested_slug = $this->uri->segment(3);
            $set_slug = $this->data['page']->slug;
            if($requested_slug != $set_slug){
                redirect('page/'. $this->data['page']->id .'/'. $this->data['page']->slug, 'location', '301');
            }
        }else{
            show_404();
        }
    	

		$this->data['theme_name'] = $this->theme;
    	$this->load->ext_view('../themes/'.$this->theme, 'page', $this->data);
    }







    /**
     * Get Blog Post Single Display
     * @param $id, $slug
     * @return page content, load view
     * @uses themes
    */
    public function post($id, $slug){
        if($id){
            $id = (int) $id;
            $this->data['post'] = $this->blog->get_posts($id);
            count($this->data['post']) || show_404(uri_string());

            //get gallery 
            $this->data['gallery'] = $this->uploads_model->get_by(array('post_id' => $id, 'type' => 'blog'));

            //set open graph
            $open_graph = array(
                'title' => $this->data['post']->title,
                'url' => site_url('post/'.$this->data['post']->id.'/'.$this->data['post']->slug.''),
                'image' => $this->data['post']->image,
                'description' => strip_tags(truncateStringWords($this->data['post']->content, 300))
            );
            $this->data['open_graph'] = $open_graph;

            //get categories count
            $this->data['categories_count'] = $this->blog->get_categories_count();

            //get recent posts
            $this->data['recent_posts'] = $this->blog->get_recent_posts(3);

            // Redirect to correct slug if incorrect
            $requested_slug = $this->uri->segment(3);
            $set_slug = $this->data['post']->slug;
            if($requested_slug != $set_slug){
                redirect('post/'. $this->data['post']->id .'/'. $this->data['post']->slug, 'location', '301');
            }
        }else{
            show_404();
        }

        $this->data['theme_name'] = $this->theme;
        $this->load->ext_view('../themes/'.$this->theme, 'post', $this->data); 
    }






    /**
     * Get Posts by Category
     * @param $type, $category
     * @return posts by categories, load view
     * @uses themes
    */
    public function category($type, $category){

        $data = $this->blog->paginate_blogs_category($category);

        //set open graph
        $open_graph = array(
            'title' => ucfirst($data['category_name']), //constructor settings data
            'url' => base_url().'category/'.$type.'/'.$category,
            'image' => $this->data['settings']->cover_image,
            'description' => strip_tags(truncateStringWords($this->data['settings']->tagline, 300))
        );
        $this->data['open_graph'] = $open_graph;

        

        $this->data['theme_name'] = $this->theme;
        
        $this->data['category_name'] = $data['category_name'];
        $this->data['posts_by_category'] = $data['posts_by_category'];
        $this->data['pagination'] = $data['pagination'];
        $this->load->ext_view('../themes/'.$this->theme, 'category', $this->data); 
    }



    



}