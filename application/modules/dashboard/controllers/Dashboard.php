<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {





	function __construct(){
        parent::__construct();
        $this->load->model('blog/Blog_model');
        $this->load->model('blog/Blog_categories_model');
        $this->load->module('blog/admin/blog');
        $this->load->module('page/admin/page');
        $this->load->module('user/admin/user');
       	$this->check_module_permission('dashboard');// check module permission
    }





	public function index(){
		$this->data['recent_posts'] = $this->Blog_model->get_recent_post(4);
		$this->data['user_activity'] = $this->User_model->get_user_activity(4);
		$this->data['categories'] = $this->Blog_categories_model->get_category();
		$this->data['posts_count'] = $this->blog->get_count_posts();
		$this->data['categories_count'] = $this->blog->get_count_blog_categories();
		$this->data['pages_count'] = $this->page->get_count_pages();
		$this->data['users_count'] = $this->user->get_count_users();
		

		$this->data['subview'] = 'dashboard';
		$this->load->view('admin/_main_layout', $this->data);
	}
	
	






	public function dashboard(){
		
		$this->data['subview'] = 'dashboard';
		$this->load->view('admin/_main_layout', $this->data);
	}




	
}