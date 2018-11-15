<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes_model extends MY_Model {

	protected $_table_name = 'routes';
	protected $_order_by = '';

	function __construct(){
        parent::__construct();
    }
}