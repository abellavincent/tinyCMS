<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends MY_Model {

	protected $_table_name = 'gallery';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }
}