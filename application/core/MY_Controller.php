<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller{

	public $data = array();
	public $post_uri = 'post'; //displays /post/21/my-new-blog-post
	public $page_uri = 'page'; // displays /page/4/about-us
	public $category_uri = 'category'; //displays /category/post/politics
	
	public function __construct(){
		parent::__construct();
		$this->data['errors'] = array();
		$this->data['site_name'] = config_item('site_name');
	}
}