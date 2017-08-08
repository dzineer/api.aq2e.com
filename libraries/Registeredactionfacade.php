<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Registeredactionfacade.php -
 *
 */

class Registeredactionfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();
		
		$this->CI->load->model('Registeredaction_model', 'RegisteredAction');
		
		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function get_all_registered_actions() {
		$actions = $this->CI->RegisteredAction->get_registered_actions();
	    return $actions;
    }

    function search( $action_id ) {
        $actions = $this->CI->RegisteredAction->get_registered_action( $action_id );
	    $action = array_pop( $actions );
        return $action;
    }

}
?>