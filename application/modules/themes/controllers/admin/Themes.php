<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Themes extends Admin_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('Themes_model');
        $this->load->model('Theme_options_model');
        $this->load->model('Slider_model');
        $this->check_module_permission('themes');// check module permission
    
    }




    /**
     * Load All Themes 
     * @uses all themes
    */
    public function index(){
        $this->data['themes'] = $this->Themes_model->get();
        $this->data['subview'] = 'admin/index';
        $this->load->view('admin/_main_layout', $this->data);
    }






    /**
	 * Get Theme Options 
	 * @uses get all theme options settings
    */
    public function get_theme_options(){
    	$this->data['theme_options'] = $this->Theme_options_model->get_theme_options();
    	
    	$this->data['subview'] = 'admin/theme_options';
		$this->load->view('admin/_main_layout', $this->data);
    }







    /**
     * Display All Homepage
     * @uses load view slider all
    */
    public function homepage_slider(){
        $this->data['sliders'] = $this->Slider_model->get();
        $this->data['subview'] = 'admin/homepage_slider';
        $this->load->view('admin/_main_layout', $this->data);
    }





    /**
     * Add New Slider
     * @uses load view add slider
    */
    public function add_slider(){
        $this->data['subview'] = 'admin/add_slider';
        $this->load->view('admin/_main_layout', $this->data);
    }




    /**
     * Save New Slider
     * @param POST data
     * @return json response
     * @uses save new slider form
    */
    public function save_slider(){
        if($this->input->post('form_submit')){
            $title = xss_clean($this->input->post('title'));
            $link = xss_clean($this->input->post('link'));
            $order_position = xss_clean($this->input->post('order_position'));
            $description = xss_clean($this->input->post('description'));
            $image_url = xss_clean($this->input->post('image_url'));

            $data = array(
                'title' => $title,
                'link' => $link,
                'order_position' => $order_position,
                'description' => $description,
                'image' => $image_url,
                'date_added' => date('Y-m-d H:i:s'),
                'added_by' => $this->session->userdata('username'),
            );


            $isSave = $this->Slider_model->save($data);
            $slider_id = $this->db->insert_id();

            if($isSave == TRUE){
                echo json_encode(array(
                    'success' => TRUE,
                    'id' => $slider_id
                ));
            }else{
                echo json_encode(array('success' => FALSE));
            }

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }






    /**
	 * Save Options > General Info
	 * @param POST data
	 * @return json
	 * @uses save theme options general information
    */
    public function save_options(){
    	if($this->input->post('form_submit')){
    		$contact = xss_clean($this->input->post('contact'));
    		$email = xss_clean($this->input->post('email'));
    		$address = xss_clean($this->input->post('address'));
    		$copyright = xss_clean($this->input->post('copyright'));

    		$data = array(
    			'copyright' => $copyright,
    			'email' => $email,
    			'contact' => $contact,
    			'address' => $address,
    		);

    		//loop through data and perform insert
    		foreach ($data as $key => $value) {	
				$isUpdate = $this->Theme_options_model->save_options($key, $value);
			}

			echo json_encode(array('success' => TRUE));
    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }




    /**
     * Load Edit Slider View
     * @param $slider_id
     * @return load view
     * @uses edit slider
    */
    public function edit_slider($slider_id){
        if($slider_id){
            $slider_id = (int) $slider_id;
            $this->data['slider'] = $this->Slider_model->get($slider_id);
            if(count($this->data['slider']) == 0)
                show_404();
        }else{
            redirect('admin/themes/slider');
        }
        
        //$this->update_order_sequence(3, 2);
        

        $this->data['subview'] = 'admin/edit_slider';
        $this->load->view('admin/_main_layout', $this->data);
    }



    



     /**
     * Update Slider
     * @param POST data
     * @return json response
     * @uses update slider form
    */
    public function update_slider(){
        if($this->input->post('form_submit')){
            $title = xss_clean($this->input->post('title'));
            $link = xss_clean($this->input->post('link'));
            $order_position = xss_clean($this->input->post('order_position'));
            $description = xss_clean($this->input->post('description'));
            $image_url = xss_clean($this->input->post('image_url'));
            $slider_id = (int) $this->input->post('slider_id');

            $data = array(
                'title' => $title,
                'link' => $link,
                'order_position' => $order_position,
                'description' => $description,
                'image' => $image_url,
            );


            $this->update_order_sequence($slider_id, $order_position);

            $isSave = $this->Slider_model->save($data, $slider_id);
            if($isSave == TRUE){
                echo json_encode(array(
                    'success' => TRUE
                ));
            }else{
                echo json_encode(array('success' => FALSE));
            }



        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }









    /**
     * Update Order Position Sequence
     * @param $id as slider id, $position
     * @uses update ordering position update_slider()
    */
    public function update_order_sequence($id, $position){
        $data = array(
            'order_position' => $position
        ); 
        $this->Slider_model->save($data, $id);

        //get data
        $slider_data = $this->Slider_model->get_slider_greater_than_position($position);

        $order = $position;

        foreach($slider_data as $slider){
            // if($this->is_position_exist($position) == TRUE){
            //     $order++;
            // }

            $data = array(
                'order_position' => $order
            ); 

            //dump('slider_id: ' .$slider->id .' => '. 'order_position: '.$order.'<br>');
            $this->Slider_model->save($data, $slider->id); 
            $order++;
        }        
    }


    public function is_position_exist($position){
        $data = $this->Slider_model->get_by(array('order_position' => $position));
        if(count($data))
            return TRUE;
        else 
            return FALSE;
    }





    /**
     * Delete Slider
     * @param $id as slider id
     * @return json response
     * @uses sliders delete permanently
    */
    public function delete_slider(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('slider_id');
            $this->Slider_model->delete($id);
            echo json_encode(array('success' => TRUE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
	 * Save Social Media Settings
	 * @param POST data
	 * @return json
	 * @uses theme options > save social media
    */
    public function save_social(){
    	if($this->input->post('form_submit')){
    		$facebook = xss_clean($this->input->post('facebook'));
    		$twitter = xss_clean($this->input->post('twitter'));
    		$instagram = xss_clean($this->input->post('instagram'));
    		$youtube = xss_clean($this->input->post('youtube'));
    		$google_plus = xss_clean($this->input->post('google_plus'));

    		$data = array(
    			'facebook' => $facebook,
    			'twitter' => $twitter,
    			'instagram' => $instagram,
    			'youtube' => $youtube,
    			'google_plus' => $google_plus,
    		);

    		//loop through data and perform insert
    		foreach ($data as $key => $value) {	
				$isUpdate = $this->Theme_options_model->save_options($key, $value);
			}

			echo json_encode(array('success' => TRUE));

    	}else{
    		echo json_encode(array('error' => 'post parameters missing'));
    	}
    }




    /**
     * Save Promo Content
     * @param POST data
     * @return json
     * @uses theme options > save promo content
    */
    public function save_promo_content(){
        if($this->input->post('form_submit')){
            $content = xss_clean($this->input->post('content'));
           

            $data = array(
                'promo_content' => $content,
            );

            //loop through data and perform insert
            foreach ($data as $key => $value) { 
                $isUpdate = $this->Theme_options_model->save_options($key, $value);
            }

            echo json_encode(array('success' => TRUE));

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }






    /**
     * Save Homepage Settings
     * @param POST data
     * @return json
     * @uses theme options > homepage background
    */
    public function save_home_bg(){
        if($this->input->post('form_submit')){
            $home_background = xss_clean($this->input->post('home_background'));
           

            $data = array(
                'home_background' => $home_background,
            );

            //loop through data and perform insert
            foreach ($data as $key => $value) { 
                $isUpdate = $this->Theme_options_model->save_options($key, $value);
            }

            echo json_encode(array('success' => TRUE));

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }







    /**
     * Save Promo Background Settings
     * @param POST data
     * @return json
     * @uses theme options > promo background
    */
    public function save_promo_bg(){
        if($this->input->post('form_submit')){
            $promo_background = xss_clean($this->input->post('promo_background'));
           

            $data = array(
                'promo_background' => $promo_background,
            );

            //loop through data and perform insert
            foreach ($data as $key => $value) { 
                $isUpdate = $this->Theme_options_model->save_options($key, $value);
            }

            echo json_encode(array('success' => TRUE));

        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }







    /**
     * Activate Themes
     * @param POST data
     * @return json 
     * @uses activate theme 
    */
    public function activate_themes(){
        if($this->input->post('form_submit')){
            $id = (int) $this->input->post('theme_id');
            $this->deactivate_current_active_theme();

            $data = array(
                'is_active' => 1
            );

            $isSave = $this->Themes_model->save($data, $id);
            if($isSave)
                echo json_encode(array('success' => TRUE));
            else
                echo json_encode(array('success' => FALSE));
        }else{
            echo json_encode(array('error' => 'post parameters missing'));
        }
    }





    /**
     * Deactivate Current Active Theme
     * @uses activate_themes()
    */
    public function deactivate_current_active_theme(){
        $theme_id = $this->Themes_model->get_active_theme_id();
        $data = array(
            'is_active' => 0
        );
        $this->Themes_model->save($data, $theme_id);
    }




}