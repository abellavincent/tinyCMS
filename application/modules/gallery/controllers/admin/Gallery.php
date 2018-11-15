<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Admin_Controller {

	function __construct(){
        parent::__construct();
      	$this->load->model('gallery_model');
      	$this->load->model('uploads_model');	

        //$this->check_module_permission('blogs');//check module permission
    }



    /**
	 * Save Images
	 * @param $image as image url
	 * @param $thumb as thumbnails
	 * @param $type as either page, blog, gallery
	 * @param $post_id as reference id of the post
	 * @uses global uploads, multiple uploader
    */
    public function save_images($image, $thumb, $type, $post_id, $filename){
		$username = $username = $this->session->userdata('username');
		$date_added = date('Y-m-d H:i:s');

		$data = array(
			'image' => $image,
			'thumb' => $thumb,
			'date_added' => $date_added,
			'added_by' => $username,
			'type' => $type,
			'post_id' => $post_id,
			'filename' => $filename,
		);

		$save = $this->uploads_model->save($data);
    }




    /**
	 * Delete Gallery Item
	 * @param POST data
	 * @return json
	 * @uses gallery delete single image
    */
    public function delete_gallery_item(){

    	if($this->input->post('form_submit')){
    		$id = (int) $this->input->post('id');
    		$data = $this->uploads_model->get($id); //get uploads data
    		$filename = $data->filename; //filename of image

    		$this->uploads_model->delete($id); //delete to database
    		$this->delete_file($filename); //delete to directory
			echo json_encode(array('success' => TRUE));
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }






    /**
	 * Delete Image File from Directory
	 * @param $filename
	 * @return NULL
	 * @uses delete image
    */
	function delete_file($filename){
		$original_path = './uploads/original/';
    	$thumb_path = './uploads/thumbs/';
    	unlink($original_path.$filename);
	    unlink($thumb_path.$filename);
	}


}