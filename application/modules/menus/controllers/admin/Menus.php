<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Admin_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Menus_model');
        $this->load->model('Menu_type_model');
        $this->check_module_permission('menus');// check module permission

        //load content from other module
        $this->load->model('blog/Blog_model');
        $this->load->model('blog/Blog_categories_model');
        $this->load->model('page/Page_model');

        //set frontend data array
        $this->data['posts'] = $this->Blog_model->get_posts();
        $this->data['categories'] = $this->Blog_categories_model->get_category();
        $this->data['pages'] = $this->Page_model->get();
        $this->data['modules'] = $this->Menus_model->get_modules();

    }



    /**
     * Admin Menus
     * Get the first menu items
    */
    public function index(){
    	//get first menu type details
    	$first_menu_id = $this->Menu_type_model->get_min_menu_type();
        redirect('admin/menus/edit/'.$first_menu_id);
       

    	//$this->data['menu_type_data_first'] = $this->Menu_type_model->get($first_menu_id);
    	// get menu items > first menu
    	//$this->data['menu_items'] = $this->Menus_model->get_menu_items($first_menu_id);
    	// get all menu type 
    	//$this->data['menu_types'] = $this->Menu_type_model->get_menu_type();
    	//$this->data['subview'] = 'edit_menu';
		//$this->load->view('admin/_main_layout', $this->data);
    }


  

    /**
     * Save Menu Type
     * @param POST data
     * @return json
     * @uses form
    */
    public function save_menu_type(){
    	if($this->input->post('form_submit')){
    		$menu_name = xss_clean($this->input->post('menu_name'));

    		$data = array(
    			'name' => $menu_name,
    			'user_role_id' => 4, // visitor id @db user_role
    		);
    		
    		if($this->Menu_type_model->save($data)){
    			$id = $this->db->insert_id();
    			echo json_encode(array(
    				'success' => TRUE,
    				'id' => $id
    			));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }

   


    /**
     * Save Menu Item
     * @param POST data
     * @return json
     * @uses form, add item > custom link
    */
    public function save_menu_item(){
    	if($this->input->post('form_submit')){

    		$title = xss_clean($this->input->post('title'));
    		$url = xss_clean($this->input->post('url'));
    		$css = xss_clean($this->input->post('css'));
    		$icon = xss_clean($this->input->post('icon'));
    		$keyword = xss_clean($this->input->post('keyword'));
    		$menu_type = (int) $this->input->post('menu_type');
    		$username = $this->session->userdata('username');
    		$position =  $this->Menus_model->get_max_position();
    		$date_added = date('Y-m-d H:i:s');

    		$data = array(
    			'title' => $title,
    			'url' => $url,
    			'class' => $css,
    			'icon' => $icon,
    			'keyword' => $keyword,
    			'menu_type_id' => $menu_type,
    			'parent' => 0,
    			'position' => $position,
    			'added_by' => $username,
    			'date_added' => $date_added
    		);

    		if($this->Menus_model->save($data) == TRUE){
    			echo json_encode(array('success' => TRUE));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }
   




    /**
     * Save Menu Group Items, save order and position
     * @param POST data
     * @return json
     * @uses form, save order and position
    */
    public function save_menugroup_items(){
   		if($this->input->post('form_submit')){

   			$jsonstring = $this->input->post('jsonstring'); // menu items in json format
   			$menu_type_id = $this->input->post('menu_type_id');

   			$jsonDecoded = json_decode($jsonstring, true, 64); // decode menu json string

   			//parse json
			function parseJsonArray($jsonArray, $parentID = 0){
			  	$return = array();
			  	foreach ($jsonArray as $subArray) {
					$returnSubSubArray = array();
				 	if (isset($subArray['children'])) {
				   		$returnSubSubArray = parseJsonArray($subArray['children'], $subArray['id']);
				 	}
				 	$return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
				 	$return = array_merge($return, $returnSubSubArray);
			  	}
			  	return $return;
			}

			// Convert json string to readable array format
			$readbleArray = parseJsonArray($jsonDecoded);

   			// Loop through the "readable" array and save changes to DB
			foreach ($readbleArray as $key => $value) {
				// $value should always be an array, but we do a check
				if (is_array($value)) {
					$data = array(	
						'position' => $key, 
						'parent' => $value['parentID'],
					);
					$this->Menus_model->save($data, $value['id']); // update order position
				}
			}

			// todo SetPermission at user_role > role_permission - ok
            $this->set_permission($menu_type_id);
			echo json_encode(array('success' => TRUE, 'id' => $menu_type_id));

   		}else{
   			echo json_encode(array('error' => 'post parameters missing'));
   		}
    }







    /**
     * Get Menu Item Details
     * @param POST data > item_id
     * @return json
     * @uses modal pop up > edit menu item
    */
    public function get_menu_item_info(){
        if($this->input->post('form_submit')){
            $item_id = (int) $this->input->post('item_id');
            $item_data = $this->Menus_model->get($item_id);
            echo json_encode($item_data);
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }






    /**
     * Update Menu Item
     * @param POST data array
     * @return json
     * @uses form, update menu item
    */
    public function update_menu_item(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('item_id');
            
            $title = xss_clean($this->input->post('title'));
            $url = xss_clean($this->input->post('url'));
            $css = xss_clean($this->input->post('css'));
            $icon = xss_clean($this->input->post('icon'));
            $keyword = xss_clean($this->input->post('keyword'));
            $target = xss_clean($this->input->post('target'));

            $data = array(
                'title' => $title,
                'url' => $url,
                'class' => $css,
                'icon' => $icon,
                'keyword' => $keyword,
                'target' => $target,
            );

            if($this->Menus_model->save($data, $id) == TRUE){
                echo json_encode(array('success' => TRUE));
            }else{
                echo json_encode(array('success' => FALSE));
            }
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
     * Delete Menu Item
     * @param POST data
     * @return json
     * @uses form, delete menu item
    */
    public function delete_menu_item(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('item_id');
            $this->Menus_model->delete($id);
            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
     * Update Menu Type Name
     * @param POST data
     * @return json
     * @uses form,edit menu type name
    */
    public function update_menutype_name(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('menu_id');
            $name = xss_clean($this->input->post('menu_name'));
            $data = array(
                'name' => $name 
            );

            $isUpdate = $this->Menu_type_model->save($data, $id);
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
     * Delete Menu Type
     * @param POST data
     * @return json
     * @uses delete menu type
    */
    public function delete_menutype(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('menu_type_id');
            $this->Menu_type_model->delete($id); //delete menu type

            $this->Menus_model->delete_menu_items($id); // delete all associated menu items

            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
     * Edit Menu Page
     * @param $id as menu_type_id
     * @uses form edit menu type
    */
    public function edit_menu($id){
        if($id){
            //get menu type details
            $this->data['menu_type_data_first'] = $this->Menu_type_model->get($id);
            count($this->data['menu_type_data_first']) || redirect('admin/menus');    

            // get menu items > first menu
            $this->data['menu_items'] = $this->Menus_model->get_menu_items($id);

            // get all menu type 
            $this->data['menu_types'] = $this->Menu_type_model->get_menu_type();
        }else{
            redirect('menus/admin/menus');
        }

        $this->data['subview'] = 'edit_menu';
        $this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Set Module Permission 
     * @param $menu_type_id
     * @uses module_permission
    */
    public function set_permission($menu_type_id){
        $this->Menus_model->set_permission($menu_type_id);
    }






    /**
     * Add Menu Item from Post Content
     * @param POST data array
     * @return json
     * @uses add menu item
    */
    public function save_menu_item_from_post(){
        if($this->input->post('form_submit')){
            $menu_type_id = (int) $this->input->post('menu_type_id');
            $posts_arr = json_decode($this->input->post('posts_selected'));

            //get extract post id and get post details from blog model
            foreach($posts_arr as $key => $post_id){
                $this->data['post'] = $this->Blog_model->get_posts($post_id);
                $posts_permalink = site_url().$this->post_uri.'/'.$post_id.'/'.$this->data['post'][0]->slug;
                $position =  $this->Menus_model->get_max_position();
                $data = array(
                    'title' => $this->data['post'][0]->title,
                    'url' => $posts_permalink,
                    'keyword' => $this->data['post'][0]->slug, //slug
                    'menu_type_id' => $menu_type_id,
                    'date_added' => date('Y-m-d H:i:s'),
                    'position' => $position,
                    'added_by' => $username = $this->session->userdata('username'),
                );

                $this->Menus_model->save($data);
            }

            echo json_encode(array('success' => TRUE));

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
          
    }
	
	


    /**
     * Add Menu Item from Post Categories
     * @param POST data
     * @return json
     * @uses add menu item
    */
    public function save_menu_item_from_post_category(){
        if($this->input->post('form_submit')){
            $menu_type_id = (int) $this->input->post('menu_type_id');
            $category_arr = json_decode($this->input->post('category_selected'));

            //get extract category id and get category details
            foreach($category_arr as $key => $category_id){
                $this->data['category'] = $this->Blog_categories_model->get_category($category_id);
                $category_permalink = site_url().$this->category_uri.'/'.$this->post_uri.'/'.$this->data['category'][0]->slug;
                $position =  $this->Menus_model->get_max_position();
                $data = array(
                    'title' => $this->data['category'][0]->name,
                    'url' => $category_permalink,
                    'keyword' => $this->data['category'][0]->slug, //slug
                    'menu_type_id' => $menu_type_id,
                    'date_added' => date('Y-m-d H:i:s'),
                    'position' => $position,
                    'added_by' => $username = $this->session->userdata('username'),
                );
                $this->Menus_model->save($data);
            }
            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }






    /**
     * Add Menu Item from Pages
     * @param POST data
     * @return json
     * @uses add menu item
    */
    public function save_menu_item_from_page(){
        if($this->input->post('form_submit')){
            $menu_type_id = (int) $this->input->post('menu_type_id');
            $page_arr = json_decode($this->input->post('page_selected'));

            //get extract page id and get page details
            foreach($page_arr as $key => $page_id){
                $this->data['page'] = $this->Page_model->get($page_id);
                $post_permalink = site_url().$this->page_uri.'/'.$this->data['page']->id .'/'.$this->data['page']->slug;
                $position =  $this->Menus_model->get_max_position();
                $data = array(
                    'title' => $this->data['page']->title,
                    'url' => $post_permalink,
                    'keyword' => $this->data['page']->slug, //slug
                    'menu_type_id' => $menu_type_id,
                    'date_added' => date('Y-m-d H:i:s'),
                    'position' => $position,
                    'added_by' => $username = $this->session->userdata('username'),
                );
                $this->Menus_model->save($data);
            }
            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }






    /**
     * Add Menu Item from Modules
     * @param POST data
     * @return json
     * @uses add menu item
    */
    public function save_menu_item_from_module(){
        if($this->input->post('form_submit')){
            $menu_type_id = (int) $this->input->post('menu_type_id');
            $module_arr = json_decode($this->input->post('module_selected'));

            //get extract page id and get page details
            foreach($module_arr as $key => $module_id){
                $this->data['module'] = $this->Menus_model->get_modules($module_id);
                $post_permalink = $this->data['module'][0]->uri_string;
                $position =  $this->Menus_model->get_max_position();
                $data = array(
                    'title' => $this->data['module'][0]->name,
                    'url' => $post_permalink,
                    'icon' => $this->data['module'][0]->icon,
                    'keyword' => $this->data['module'][0]->keyword, //slug
                    'menu_type_id' => $menu_type_id,
                    'date_added' => date('Y-m-d H:i:s'),
                    'position' => $position,
                    'added_by' => $username = $this->session->userdata('username'),
                );

                $this->Menus_model->save($data);
            }
                echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }

}
