<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * AccountFacade.php - 
 *
 */

class Accountfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('ProductModel', 'Products');
		$this->aqprodDBConfig = new AqprodDBConfig();
		$this->CI->Products->initDB($this->aqprodDBConfig);

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function test() {
	    echo print_r( $this->CI->Products->getAll());
    }

}
?>