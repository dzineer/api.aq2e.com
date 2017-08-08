<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * AccountFacade.php - 
 *
 */

class Productfacade
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

	function getAll() {
	    echo $this->CI->Products->getAll();
    }

    function search( $product_id ) {
        echo $this->CI->Products->search( $product_id );
    }

}
?>