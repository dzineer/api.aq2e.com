<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Campaignfacade.php -
 *
 */

class ExternalAPIFormsfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('CampaignExternalAPIForm_model', 'external_api_form');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function search_api_forms( $id ) {
		$api_forms = $this->CI->external_api_form->get_campaign_external_api_form( $id );
		if( count( $api_forms )) {
			return $api_forms[0];
		}
		else {
			return [];
		}
	}
	
	function get_all_api_forms() {
		return $this->CI->external_api_form->get_all_campaign_external_api_forms();
	}

}
?>