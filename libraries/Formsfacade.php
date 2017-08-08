<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * AccountFacade.php - 
 *
 */

class Formsfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();
		
		$this->CI->load->model( 'CampaignFormPage_model' , 'cfp');
		$this->CI->load->model( 'CampaignForm_model', 'cf');
		$this->CI->load->model( 'CampaignFormField_model' , 'cff');
		$this->CI->load->model( 'Campaign_model' , 'camp');
		
		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function get_all_form_pages() {
		$actions = $this->CI->cfp->get_all_campaign_form_pages();
	    return $actions;
    }

    function search_form_page( $forms_page_id ) {
        $formPage = $this->CI->cfp->get_campaign_form_page( $forms_page_id );
	    $form = $this->CI->cf->get_campaign_form( $formPage['form_id'] );
	    
	    $fields = $this->CI->cff->get_campaign_form_fields( $formPage['form_id'] );
	    $campaign = $this->CI->camp->get_campaign( $formPage['campaign_id'] );
	    $page = [ 'page' => $formPage, 'form' => $form, 'fields' => $fields, 'campaign' => $campaign ];
	    
        return $page;
    }

}
?>