<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads_model extends MY_Model {

	protected $_table_name = 'uploads';
	protected $_order_by = 'id asc';

	function __construct(){
        parent::__construct();
    }
}