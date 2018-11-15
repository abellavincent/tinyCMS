<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Admin_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('Blog_model');	
      	$this->load->model('Blog_categories_model');
      	$this->load->model('Blog_category_model');
        $this->load->model('gallery/Uploads_model');

        $this->check_module_permission('blogs');//check module permission
    }




    public function index(){
    	$this->_get_blog('publish');
        $this->data['posts_count'] = $this->get_count_posts();
        $this->data['subview'] = 'admin/index';
		$this->load->view('admin/_main_layout', $this->data);

        
    }




    /**
     * Datatables Server Side Processing
     * @return json
     * @uses datatables display
    */ 
    public function blog_datatables($status){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        
        if($status){
            switch($status){
                case 'all':{
                    $this->db->where("(blog.status='publish' OR blog.status='draft')");
                    break;
                }
                case 'publish':{
                    $this->db->where("blog.status", 'publish');
                    break;
                }
                case 'draft':{
                     $this->db->where("blog.status", 'draft');
                    break;
                }
                case 'trash':{
                    $this->db->where("blog.status", 'trash');
                    break;
                }
                default:{
                    redirect('admin/blogs');
                }
            }
        }

        $blogs = $this->Blog_model->get_blogs($start, $length);
        

        $data = array();
        foreach($blogs as $post) {
           $data[] = array(
                $post->id,
                $post->title,
                $post->status,
                $post->username,
                $post->catname,
                formatDate($post->date_created).' '. formatTime($post->date_created),
                "edit"
           );
        }

        $total_blogs = $this->Blog_model->get_total_blogs($status);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_blogs,
            "recordsFiltered" => $total_blogs,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }






    /**
     * Get Blog 
     * @param $status - blog status
     * @uses display blog by status, etc
    */
    public function _get_blog($status){
        //$this->set_pagination($status);
        $this->Blog_model->set_query();
        $this->set_data_restriction();

        if($status){
            switch($status){
                case 'all':{
                    $this->db->where("(blog.status='publish' OR blog.status='draft')");
                    break;
                }
                case 'publish':{
                    $this->db->where("blog.status", 'publish');
                    break;
                }
                case 'draft':{
                     $this->db->where("blog.status", 'draft');
                    break;
                }
                case 'trash':{
                    $this->db->where("blog.status", 'trash');
                    break;
                }
                default:{
                    redirect('admin/blogs');
                }
            }
        }

        $this->data['posts'] = $this->Blog_model->get();
       
    }




    /**
     * Display all data if admin, otherwise display data based on user loggedin
     * @uses _get_blog
     * @return false, set where status
    */
    public function set_data_restriction(){
        if($this->is_admin() == FALSE){
            $user_id = $this->session->userdata('id');
            $this->db->where('blog.author_id', $user_id);
        }else{
            return FALSE;
        }
    }





    /**
     * Get the number of posts
     * @return posts_count
     * @uses pagination, etc
    */
    public function get_count_posts(){
        $this->db->select("SUM(IF(STATUS = 'publish',1,0)) AS 'totalPublish', SUM(IF(STATUS = 'draft',1,0)) AS 'totalDraft', SUM(IF(STATUS = 'trash',1,0)) AS 'totalTrash', SUM(IF(STATUS = 'publish' OR STATUS='draft' ,1,0)) AS 'All'"); 
        $this->set_data_restriction();
        $data_array = $this->Blog_model->get();
        return $data_array;
        $this->db->reset(); //reset all queries

    }



    /**
     * Get blog content by status
     * @param $status
    */
    public function blog_by_status($status){
        $this->data['posts_count'] = $this->get_count_posts();
        $this->_get_blog($status);
        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }




    /**
     * Setup Blog Pagination
     * @param $status
     * @uses pagination of blog content
    */
    public function set_pagination($status){
        $posts_count = $this->get_count_posts(); //get post count

        //get the total number of rows per post status
        switch($status){
            case 'all':{
                $count = $posts_count[0]->All;
                break;
            }
            case 'publish':{
                $count = $posts_count[0]->totalPublish;
                break;
            }
            case 'draft':{
                $count = $posts_count[0]->totalDraft;
                break;
            }
            case 'trash': {
                $count =$posts_count[0]->totalTrash;
                break;
            }
            default:{
                return FALSE;
            }
        }
        

        // pagination settings
        $perpage = 10;
        if($count > $perpage){
            $this->load->library('pagination');
            $config['base_url'] = site_url('admin/blogs/status/'. $status .'/');
            $config['total_rows'] = $count;
            $config['per_page'] = $perpage;
            $config['uri_segment'] = 5;
            $config["num_links"] = 3;

            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $offset = ($this->uri->segment(5) != NULL ? $this->uri->segment(5) - 1 : $this->uri->segment(5));
            $this->db->limit($perpage, $offset);
 
        }else{
            $this->data['pagination'] = '';
            $offset = 0;
        }
        
    }




    /**
     * Add New Post
     * @uses form
    */
    public function add_post(){
    	$this->data['form_categories'] = $this->Blog_categories_model->form_categories();
    	$this->data['subview'] = 'admin/add_post';
		$this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Edit Post Content
     * @param POST data
     * @uses form
    */
    public function edit_post($id){
  		//setup categories
    	$this->data['form_categories_db'] = $this->Blog_categories_model->form_categories();
    	$form_categories = '';

    	if($id){

    		$this->db->select('blog.`id` as id, title, content, blog.`status` as status, blog.`image` as image, blog.`image_thumb` as image_thumb, blog.`date_created`, blog.`date_published` as date_published, blog.`date_modified` as date_modified, blog.`last_modified_by` as last_modified_by, slug, first_name, last_name');
    		$this->db->join('users', 'blog.author_id=users.id', 'inner');
    		$this->db->where('blog.id', $id);
    		$this->data['post'] = $this->Blog_model->get();
            count($this->data['post']) || redirect('admin/blogs'); //redirect if no posts found

    		// format categories display
    		foreach($this->data['form_categories_db'] as $category){
    			$form_categories .= '
    				<li class="list-group-item" >
                        <div class="form-check">
                            <label for="parent'.$category->id.'">
                                <input type="checkbox" value="'.$category->id.'" id="parent'.$category->id.'" class="form-check-input" '. checkboxCheck($this->Blog_category_model->chkCatBlogExist($category->id, $this->data['post'][0]->id)) .'>
                               	'.$category->name.' <i class="input-helper"></i>
                            </label>
                        </div>
                    </li>
    			';
    		}

    		$this->data['form_categories'] = $form_categories;

            $this->data['gallery'] = $this->Uploads_model->get_by(array('post_id' => $id, 'type' => 'blog'));

    	}else{
    		redirect('admin/blogs');
    	}

    	$this->data['subview'] = 'admin/edit_post';
		$this->load->view('admin/_main_layout', $this->data);
    }






    /**
     * Save Post Data
     * @param POST data
     * @uses insert data to database, backend
    */
    public function save_post(){
        if($this->input->post('form_submit')){
        	$date_now = date('Y-m-d H:i:s');
        	$author_id = (int) $this->session->userdata('id');
        	$username = $this->session->userdata('username');
        	$category_arr = json_decode($this->input->post('category_selected'), true); 
        	$date_published = ($this->input->post('status') == 'publish') ? $date_now:'';

        	$data = array(
        		'title' => xss_clean($this->input->post('title')),
        		'content' => $this->db->escape_str($this->input->post('content')),
        		'slug' => $this->Blog_model->slug_writer(url_title(strtolower(xss_clean($this->input->post('title'))))),
        		'status' => xss_clean($this->input->post('status')),
        		'date_created' => $date_now,
        		'image' => xss_clean($this->input->post('image')),
        		'image_thumb' => xss_clean($this->input->post('image_thumb')),
        		'author_id' => $author_id,
        		'date_published' => $date_published,
        		'last_modified_by' => $username,
        		'date_modified' => $date_now,
        	);

    	
    		$isSave = $this->Blog_model->save($data); 
    		$blog_id = $this->db->insert_id();

    		if($isSave == TRUE){

    			//insert blog id to blog_category multiple
		    	foreach($category_arr as $key => $category_id){
					$isExist = $this->Blog_category_model->chkCatBlogExist($category_id, $blog_id); //check if category already exist
					if($isExist == 0){
						$data = array(
							'blog_id' => $blog_id, 
							'category_id' => $category_id
						);
						$this->Blog_category_model->save($data); //insert selected category 
					}else{
						continue;
					}
				}

				echo json_encode(array(
					'success' => TRUE,
					'id' => $blog_id
				));

			}else{
				echo json_encode(array('success' => FALSE));
			}
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}

    }






    /**
     * Update Post Content
     * @param POST data
     * @uses update data to database, backend
    */
    public function update_post(){
    	if($this->input->post('form_submit')){
        	$date_now = date('Y-m-d H:i:s');
        	$username = $this->session->userdata('username');
        	$category_arr = json_decode($this->input->post('category_selected'), true); 
        	$date_published = ($this->input->post('status') == 'publish') ? $date_now:'';
            $post_id = (int) $this->input->post('post_id');

        	$data = array(
        		'title' => xss_clean($this->input->post('title')),
        		'content' => $this->db->escape_str($this->input->post('content')),
        		'status' => xss_clean($this->input->post('status')),
        		'image' => xss_clean($this->input->post('image')),
        		'image_thumb' => xss_clean($this->input->post('image_thumb')),
        		'date_published' => ($this->input->post('status') == "publish" ? $this->Blog_model->is_blog_published($post_id):"0000-00-00 00:00:00"),
        		'last_modified_by' => $username,
        		'date_modified' => $date_now,
        	);

    		
    		$isSave = $this->Blog_model->save($data, $post_id); 
    		

    		if($isSave == TRUE){

    			// delete category
    			$getcategory = $this->Blog_category_model->getCategoryById($post_id);
				foreach($getcategory as $row){
					$cat_id = $row->category_id;
					if(!in_array($cat_id, $category_arr)){
						$delete = $this->Blog_category_model->deleteCategory($cat_id, $post_id);
					}
				}

    			//insert blog id to blog_category multiple
		    	foreach($category_arr as $key => $category_id){
					$isExist = $this->Blog_category_model->chkCatBlogExist($category_id, $post_id); //check if category already exist
					if($isExist == 0){
						$data = array(
							'blog_id' => $post_id, 
							'category_id' => $category_id
						);
						$this->Blog_category_model->save($data); //insert selected category 
					}
				}

				// return json response
				echo json_encode(array(
					'success' => TRUE,
				));

			}else{
				echo json_encode(array('success' => FALSE));
			}
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}

    }





    /**
     * Search Post 
     * @param POST data
     * @return search result
     * @uses form, search
    */
    public function search(){
        if($this->input->post('form_submit')){
            
            $this->data['posts_count'] = $this->get_count_posts();
            $keyword = xss_clean($this->input->post('search-keyword'));
            
            $this->Blog_model->set_query(); 
            $this->set_data_restriction();
            
            $this->data['posts'] = $this->Blog_model->search_posts($keyword);
            $this->data['keyword'] = $keyword;
            $this->data['is_search'] = TRUE;
            $this->data['results_count'] = count($this->data['posts']); 
        }else{
            redirect('admin/blogs');
        }

        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Delete Post
     * @param POST data
     * @return json
    */
    public function delete_post(){
    	if($this->input->post('form_submit')){
    		$id = (int) $this->input->post('post_id');
    
    		$this->Blog_model->delete($id);
    		$this->Blog_category_model->deleteCategoryById($id);
    		
    		echo json_encode(array('success' => TRUE));
    		
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    	
    }




    /**
     * Move to Trash - Update post status to trash
     * @param POST data
     * @uses form,
     * @return json
    */
    public function move_to_trash(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('post_id');

            $data = array(
                'status' => 'trash'
            );
            $isUpdate = $this->Blog_model->save($data, $id);
            if($isUpdate == TRUE){
                echo json_encode(array('success' => TRUE));
            }else{
                echo json_encode(array('success' => FALSE));
            }
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
     * Manage Categories
     * @uses form
    */
    public function categories(){
    	$this->data['form_categories'] = $this->Blog_categories_model->form_categories();

    	$this->data['categories'] = $this->Blog_categories_model->get(); // get all blog categories
   
    	$this->data['subview'] = 'admin/categories';
		$this->load->view('admin/_main_layout', $this->data);
    }






    /**
     * Edit Category
     * @param POST data
     * @uses form
    */
    public function edit_category($id){
    	$this->data['form_categories'] = $this->Blog_categories_model->form_categories();

    	if($id){
			$this->data['category'] = $this->Blog_categories_model->get($id);
			count($this->data['category']) || redirect('admin/blogs/categories');
		}else{
			redirect('admin/blogs/categories');
		}
    	
    	$this->data['subview'] = 'admin/edit_category';
		$this->load->view('admin/_main_layout', $this->data);
    }







    /**
     * Save Category
     * @param POST data
     * @return json
     * @uses add new category, form
    */
    public function save_category(){
    	$data = array(
    		'name' => xss_clean($this->input->post('name')),
    		'slug' => url_title(xss_clean($this->input->post('slug'))),
    		'type' => 'blog',
    		'parent_id' => xss_clean($this->input->post('parent_id')),
    		'description' => xss_clean($this->input->post('description')),
    	);
		
		if($this->input->post('form_submit')){

			$isSave = '';
			if($this->input->post('category_id')){
				$id = (int) $this->input->post('category_id');
				$isSave = $this->Blog_categories_model->save($data, $id); //update category
			}else{
				$isSave = $this->Blog_categories_model->save($data); //save new category
			}
			

			if($isSave == TRUE){
				echo json_encode(array(
					'success' => TRUE,
				));

			}else{
				echo json_encode(array('success' => FALSE));
			}
			
		}else{
			echo json_encode(array('error' => 'post parameters missing'));
		}    	
    }






    /**
     * Delete Category
     * @param POST data
     * @return json
    */
    public function delete_category(){
    
		if($this->input->post('form_submit')){
			$category_id = (int) $this->input->post('category_id');
			$isDelete = $this->Blog_categories_model->delete($category_id);

			echo json_encode(array(
				'id' => $category_id,
				'success' => TRUE,
			));
		}else{
			echo json_encode(array('error' => 'post parameters missing'));
		}
    }




    /**
     * Count total number of categories
     * @return total count of categories
     * @uses dashboard statistics
    */
    public function get_count_blog_categories(){
        $data = $this->Blog_categories_model->get();
        return count($data);
    }


 }