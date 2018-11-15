<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Admin_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('Page_model');
        $this->load->model('gallery/Uploads_model');
        $this->check_module_permission('pages');// check module permission
    }


    public function index(){
    	$this->_get_page('publish');

        $this->data['pages_count'] = $this->get_count_pages();
    	$this->data['subview'] = 'admin/index';
		$this->load->view('admin/_main_layout', $this->data);
    }



    /**
     * Get Pages Content
     * @param $status 
     * @return pages data
     * @uses page by status
    */
    public function _get_page($status){
        //$this->set_pagination($status);
        
        $this->Page_model->set_query();

        if($status){
            switch($status){
                case 'all':{
                    $this->db->where("(pages.status='publish' OR pages.status='draft')");
                    break;
                }
                case 'publish':{
                    $this->db->where("pages.status", 'publish');
                    break;
                }
                case 'draft':{
                     $this->db->where("pages.status", 'draft');
                    break;
                }
                case 'trash':{
                    $this->db->where("pages.status", 'trash');
                    break;
                }
                default:{
                    redirect('admin/pages');
                }
            }
        }
        $this->data['pages'] = $this->Page_model->get();
    }





    /**
     * Get the total numer of Pages by status
     * @return pages data
     * @uses pagination
    */
    public function get_count_pages(){
        $this->db->select("SUM(IF(STATUS = 'publish',1,0)) AS 'totalPublish', SUM(IF(STATUS = 'draft',1,0)) AS 'totalDraft', SUM(IF(STATUS = 'trash',1,0)) AS 'totalTrash', SUM(IF(STATUS = 'publish' OR STATUS='draft' ,1,0)) AS 'All'");
        $data_array = $this->Page_model->get();
        return $data_array;
        $this->db->reset(); //reset all queries
    }




    /**
     * Get Pages by status
     * @param $status
     * @uses pages display
    */
    public function page_by_status($status){
        $this->data['pages_count'] = $this->get_count_pages();
        $this->_get_page($status);

        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Set Pages pagination
     * @param @status
     * @return pagination links
     * @uses pages display 
    */
    public function set_pagination($status){
        $pages_count = $this->get_count_pages(); //get page count

        //get the total number of rows per page status
        switch($status){
            case 'all':{
                $count = $pages_count[0]->All;
                break;
            }
            case 'new':{
                $count = $pages_count[0]->totalPublish;
                break;
            }
            case 'read':{
                $count = $pages_count[0]->totalDraft;
                break;
            }
            case 'trash': {
                $count =$pages_count[0]->totalTrash;
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
            $config['base_url'] = site_url('admin/pages/status/'. $status .'/');
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
     * Add New Page
     * @uses form page
    */
    public function add_page(){
    	$this->data['subview'] = 'admin/add_page';
		$this->load->view('admin/_main_layout', $this->data);
    }







    /**
     * Save Page Data
     * @param POST data array
     * @return json
     * @uses save page form
    */
    public function save_page(){
    	if($this->input->post('form_submit')){
    		$date_now = date('Y-m-d H:i:s');
	    	$author_id = (int) $this->session->userdata('id');
	    	$username = $this->session->userdata('username');
	    	$date_published = ($this->input->post('status') == 'publish') ? $date_now:'';

	    	$data = array(
        		'title' => xss_clean($this->input->post('title')),
        		'content' => $this->db->escape_str($this->input->post('content')),
        		'slug' => $this->Page_model->slug_writer(url_title(strtolower(xss_clean($this->input->post('title'))))),
        		'status' => xss_clean($this->input->post('status')),
        		'date_created' => $date_now,
        		'image' => (!empty($this->input->post('image')) ? xss_clean($this->input->post('image')):''),
        		'image_thumb' => (!empty($this->input->post('image_thumb')) ? xss_clean($this->input->post('image_thumb')):''),
        		'author_id' => $author_id,
        		'date_published' => $date_published,
        		'last_modified_by' => $username,
        		'date_modified' => $date_now,
        	);

	    	$isSave = $this->Page_model->save($data); 
    		$page_id = $this->db->insert_id();

    		if($isSave == TRUE){
    			echo json_encode(array(
					'success' => TRUE,
					'id' => $page_id
				));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }






    /**
     * Edit Page
     * @param @id
     * @uses form edit page
    */
    public function edit_page($id){
    	if($id){
    		$id = (int) $id;
    		$this->db->select('pages.id as id, date_published, pages.date_created as date_created, title, pages.image as image, pages.image_thumb as image_thumb, content, pages.status as status, username, first_name, last_name, last_modified_by, pages.date_modified as date_modified');
    		$this->db->join('users', 'pages.author_id=users.id', 'inner');
    		$this->db->where('pages.id', $id);
    		$this->data['page'] = $this->Page_model->get();
    		count($this->data['page']) || redirect('admin/pages');
    	}else{
    		redirect('admin/pages');
    	}

        $this->data['gallery'] = $this->Uploads_model->get_by(array('post_id' => $id, 'type' => 'page'));

    	$this->data['subview'] = 'admin/edit_page';
		$this->load->view('admin/_main_layout', $this->data);
    }






    /**
     * Update Page Content
     * @param POST data
     * @return json
     * @uses update page > edit form backend
    */
    public function update_page(){
    	if($this->input->post('form_submit')){
    		$date_now = date('Y-m-d H:i:s');
	    	$username = $this->session->userdata('username');
	    	$date_published = ($this->input->post('status') == 'publish') ? $date_now:'';
            $page_id = (int) $this->input->post('page_id');

	    	$data = array(
        		'title' => xss_clean($this->input->post('title')),
        		'content' => $this->db->escape_str($this->input->post('content')),
        		'status' => xss_clean($this->input->post('status')),
        		'image' => (!empty($this->input->post('image')) ? xss_clean($this->input->post('image')):''),
        		'image_thumb' => (!empty($this->input->post('image_thumb')) ? xss_clean($this->input->post('image_thumb')):''),
        		'date_published' => ($this->input->post('status') == "publish" ? $this->Page_model->is_page_published($page_id):"0000-00-00 00:00:00"),
        		'last_modified_by' => $username,
        		'date_modified' => $date_now,
        	);

        	
    		$isSave = $this->Page_model->save($data, $page_id); 
    		
    		if($isSave == TRUE){
    			echo json_encode(array('success' => TRUE));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }





    /**
     * Search Pages
     * @param POST data
     * @uses form search
    */
    public function search(){
        if($this->input->post('form_submit')){
            
            $this->data['pages_count'] = $this->get_count_pages();
            $keyword = xss_clean($this->input->post('search-keyword'));
            
            $this->Page_model->set_query(); 
            $this->data['pages'] = $this->Page_model->search_pages($keyword);
            $this->data['keyword'] = $keyword;
            $this->data['is_search'] = TRUE;
            $this->data['results_count'] = count($this->data['pages']); 
        }else{
            redirect('admin/pages');
        }

        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Delete Page 
     * @param POST data > page_id
     * @return json
     * @uses delete page
    */
    public function delete_page(){
    	if($this->input->post('form_submit')){
    		$id = (int) $this->input->post('page_id');
    		$this->Page_model->delete($id);
    		
    		echo json_encode(array('success' => TRUE));
    		
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}

    }




    /**
     * Move Page to Trash
     * @param POST data
     * @return json
     * @uses pages move to trash
    */
    public function move_to_trash(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('page_id');

            $data = array(
                'status' => 'trash'
            );
            $isUpdate = $this->Page_model->save($data, $id);
            if($isUpdate == TRUE){
                echo json_encode(array('success' => TRUE));
            }else{
                echo json_encode(array('success' => FALSE));
            }
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }

    
}