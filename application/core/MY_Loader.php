<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	function ext_view($folder, $view, $vars = array(), $return = FALSE) {
	    $this->_ci_view_paths = array_merge($this->_ci_view_paths, array(APPPATH . $folder . '/' => TRUE));
	    return $this->_ci_load(array(
	        '_ci_view' => $view,
	        '_ci_vars' => $this->_ci_object_to_array($vars),
	        '_ci_return' => $return
	    ));
	}
}