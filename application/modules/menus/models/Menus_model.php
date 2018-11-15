<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_model extends MY_Model {

	protected $_table_name = 'menus';
	protected $_order_by = 'id';

	function __construct(){
        parent::__construct();
    }



    /**
     * Get Max Position of Menu Items
     * @uses add_menu_item
    */
    public function get_max_position(){
    	$this->db->select('MAX(POSITION) AS max_position');
    	$max_position = parent::get();
    	$last_position = $max_position[0]->max_position;
    	return $last_position + 1;
    }



    /**
     * Get Menu Items by object
     * @param $menu_type_id
    */
    public function get_menu_items($menu_type_id){
        $this->db->where('parent', 0);
    	$this->db->where('menu_type_id', $menu_type_id);
    	$this->db->order_by('position asc');
    	return parent::get();
    }





    /**
     * Get Child items of Parent Menu
     * @param $parent_id
     * @uses get_menu_items loop
    */
    public function get_menu_nested($parent_id){
        $this->db->where('parent', $parent_id);
        $this->db->order_by('position asc');
        return parent::get();
    }




    /**
     * Delete Menu Items
     * @param $menu_type_id
     * @uses delete all items associated to menu_type_id
    */
    public function delete_menu_items($menu_type_id){
        $this->db->where('menu_type_id', $menu_type_id);
        $this->db->delete($this->_table_name);
    }



    /**
     * Set Permission of base on the menu ite,s
     * @param $menu_type_id
     * @uses saving menugroup items
    */
    public function set_permission($menu_type_id){
        $this->db->select('menus.keyword, user_role_id');
        $this->db->join('menu_type', 'menus.menu_type_id=menu_type.id', 'inner');
        $this->db->where('menu_type_id', $menu_type_id);
        $data = $this->db->get($this->_table_name)->result();
        $user_role_id = $data[0]->user_role_id;

        
        //convert object array to plain array 
        $data = json_decode(json_encode($data), TRUE);

        $serialize_data = serialize($data);

        $data_array = array(
            'module_permissions' => $serialize_data
        );

        $this->load->model('user/user_model');
        $this->user_model->update_role_permission($user_role_id, $data_array);
    }





    /**
     * Get Menu Items of Currently Logged In user
     * @uses Get All Items
    */
    public function get_menu(){
        $username = $this->session->userdata('username');
        $this->db->select('menu_type.id as menu');
        $this->db->join('user_role', 'menu_type.user_role_id=user_role.id', 'inner');
        $this->db->join('users', 'user_role.id=users.role_id', 'inner');
        $this->db->where('users.username', $username);
        return $this->db->get('menu_type')->result();
    }




    /**
     * Get Modules 
     * @param $id - get by id
     * @uses Menus Module > Add Item by module
    */
    public function get_modules($id = NULL){
        if($id){
            $this->db->where('id', $id);
            return $this->db->get('module')->result();
        }else{
            $modules = $this->db->get('module')->result_array();
            $array = array();
            foreach($modules as $module){
                if($module['parent'] == 0){
                    //this is parent
                    $array[$module['id']] = $module;
                }else{
                    //this is child
                    $array[$module['parent']]['children'][] = $module;
                }
            }
            return $array;
        }
    }




    /**
     * Get Menu Items by array
     * @param $menu_type_id
     * @uses get_frontend_menu, etc
    */
    function get_menus($menu_type_id){
        $this->db->where('menu_type_id', $menu_type_id);
        $this->db->order_by('position asc');
        $data = $this->db->get($this->_table_name)->result_array();
        
        $array = array();
        foreach($data as $item){
            if($item['parent'] == 0){
                //this is parent
                $array[$item['id']] = $item;
            }else{
                //this is parent with child
                $array[$item['parent']]['children'][] = $item;
            }
        }

        return $array;
    }

}