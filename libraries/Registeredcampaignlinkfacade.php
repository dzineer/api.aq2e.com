<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Registeredcampaignlinkfacade.php -
 *
 */

class Registeredcampaignlinkfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {

		$this->CI =& get_instance();
		
		$this->CI->load->model('CampaignSubscriberLink_model', 'RegisteredCampaignLink');
		
		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];

	}

	function register_clicked_link( $hash, $email ) {
		
		$this->CI->load->model('CampaignSubscriberTag_model', 'subscriber_tag');
		$this->CI->load->model('Subscriber_model', 'Subscriber');
		
		$subscriber = $this->CI->Subscriber->get_subscriber_by_email( $email );
		
		if( ! empty( $subscriber ) ) {
			$subscriber_id = $subscriber['subscriber_id'];
			$link = $this->search( $hash );
			if( ! empty( $link ) ) {
				$link = array_pop( $link );
			}
			// echo "<pre>link: " . print_r( $link, true );
			$tag = 'Clicked link: ' . $link['name'];
			$this->CI->subscriber_tag->add_campaign_subscriber_tag( [ "subscriber_id" => strval( $subscriber_id ) , "tag" => $tag ] );
		}
		
	}
	
	function get_all_registered_links() {
		$links = $this->CI->RegisteredCampaignLink->get_all_monitor_links();
	    return $links;
    }

    function search( $hash ) {
        $link = $this->CI->RegisteredCampaignLink->get_monitor_link( $hash );
        return $link;
    }

}
?>