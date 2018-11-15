<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends Admin_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('Routes_model');
        //$this->check_module_permission('routes');// check module permission
    }



    public function index(){
        $this->db->where('restricted', 0); //get all not restricted routes
    	$this->data['routes'] = $this->Routes_model->get();
    	$this->data['subview'] = 'index';
		$this->load->view('admin/_main_layout', $this->data);
    }




    /**
	  * Add Routes
	  * @uses Display Add Route Form
    */ 
    public function add(){
    	$this->data['subview'] = 'add_routes';
		$this->load->view('admin/_main_layout', $this->data);
    }



    /**
	 * Save New Route
	 * @param POST parameters
	 * @return json response
	 * @uses Add New Form execution
    */
    public function save(){
    	if($this->input->post('form_submit')){
    		$uri = $this->input->post('uri');
    		$controller = $this->input->post('controller');
    		$type = $this->input->post('type');

    		$data = array(
    			'uri' => $uri, 
    			'controller' => $controller,
    			'type' => $type
    		);

    		$isSave = $this->Routes_model->save($data); 
    		$route_id = $this->db->insert_id();

    		if($isSave == TRUE){
    			echo json_encode(array(
					'success' => TRUE,
					'id' => $route_id
				));
    		}else{
    			echo json_encode(array('success' => FALSE));
    		}
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }




    /**
	 * Edit Route
	 * @uses Edit Route Form
    */
    public function edit($id){
    	if($id){
    		$id = (int) $id;
    		$this->data['route'] = $this->Routes_model->get($id);
    		count($this->data['route']) || redirect('admin/routes');
    	}else{
    		redirect('admin/routes');
    	}

    	$this->data['subview'] = 'edit_routes';
		$this->load->view('admin/_main_layout', $this->data);
    }




    /**
	 * Update Routes
	 * @param POST parameters
	 * @return json response
	 * @uses Update route information form
    */ 
    public function update(){
    	if($this->input->post('form_submit')){
    		$uri = $this->input->post('uri');
    		$controller = $this->input->post('controller');
    		$type = $this->input->post('type');
    		$id = $this->input->post('route_id');

    		$data = array(
    			'uri' => $uri, 
    			'controller' => $controller,
    			'type' => $type
    		);

    		$isSave = $this->Routes_model->save($data, $id); 

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
	 * Delete Routes
	 * @param route_id
	 * @return json reponse
	 * @uses delete route info
    */
    public function delete(){
    	if($this->input->post('form_submit')){
    		$id = (int) $this->input->post('route_id');
    		$this->Routes_model->delete($id);
    		
    		echo json_encode(array('success' => TRUE));
    		
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }
}