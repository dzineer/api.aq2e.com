<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * AccountFacade.php - 
 *
 */

class Sitefacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('Site_model', 'sites');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function get_all_sites() {
	    return $this->CI->sites->get_all_sites();
    }

    function search( $site_id ) {
        return $this->CI->sites->get_site( $site_id );
    }

}
?>