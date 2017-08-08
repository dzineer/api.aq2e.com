<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Campaignfacade.php -
 *
 */

class Campaignfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('Campaign_model', 'campaigns');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function add_new_capture_link( $campaign_id
							      ,$page_form_id
								  ,$form_id ) {
		
		$this->CI->load->model('CampaignCaptureLink_model', 'capture_link');
		
		return $this->CI->capture_link->add_campaign_capture_link(
			
			[
				"campaign_id" => $campaign_id,
				"subscriber_id" => $page_form_id,
				"status" => $form_id
			]
		);
		
	}
	
	function search_confirmation_page( $id ) {
		$this->CI->load->model('CampaignConfirmationPage_model', 'confirmation_page');
		return $this->CI->confirmation_page->get_confirmation_page( $id );
	}
	
	function get_all_confirmation_pages() {
		$this->CI->load->model('CampaignConfirmationPage_model', 'confirmation_page');
		return $this->CI->confirmation_page->get_all_confirmation_pages();
	}
	
	function add_new_campaign_subscription(
                                         $campaign_id,
                                         $subscriber_id,
                                         $status,
                                         $is_complete,
                                         $lap/*,
                                         $last_sent_email_index,
                                         $last_email_sent_at*/
    ) {
        $this->CI->load->model('CampaignSubscription_model', 'campaign_subscription');
        return $this->CI->campaign_subscription->add_campaign_subscription(

            [
                "campaign_id" => $campaign_id,
                "subscriber_id" => $subscriber_id,
                "status" => $status,
                "is_complete" => $is_complete,
                "lap" => $lap/*,
                "last_sent_email_index" => $last_sent_email_index,
                "last_email_sent_at" => $last_email_sent_at*/
            ]
        );
    }
	
	function search_capture_link( $id ) {
		$this->CI->load->model('CampaignCaptureLink_model', 'capture_link');
		return $this->CI->capture_link->get_campaign_capture_link( $id );
	}
	
	function search_capture_link_rules( $id ) {
		$this->CI->load->model('CampaignCaptureLink_model', 'capture_link');
		return $this->CI->capture_link->get_campaign_capture_link_rules( $id );
	}
	
    function update_campaign_subscriber( $id,
                                         $campaign_id,
                                         $subscriber_id,
                                         $status,
                                         $is_complete,
                                         $lap,
                                         $last_sent_email_index,
                                         $last_email_sent_at
                                       ) {
        $this->CI->load->model('CampaignSubscription_model', 'campaign_subscription');
        return $this->CI->campaign_subscription->update_campaign_subscription(

            $id,
            [
                "campaign_id" => $campaign_id,
                "subscriber_id" => $subscriber_id,
                "status" => $status,
                "is_complete" => $is_complete,
                "lap" => $lap,
                "last_sent_email_index" => $last_sent_email_index,
                "last_email_sent_at" => $last_email_sent_at
            ]
        );
    }
	
	function get_all_campaigns() {
		return $this->CI->campaigns->get_all_campaigns();
	}
 
	function get_all_capture_links() {
		$this->CI->load->model('CampaignCaptureLink_model', 'capture_link');
		return $this->CI->capture_link->get_all_campaign_capture_links();
    }

    function get_all_campaign_subscribers() {
        $this->CI->load->model('CampaignSubscription_model', 'campaign_subscription');
        return $this->CI->campaign_subscription->get_all_campaign_subscriptions();
    }

    function search( $id ) {
        return $this->CI->campaigns->get_campaign( $id );
    }

    function search_campaign_subscriber( $id ) {
        $this->CI->load->model('CampaignSubscription_model', 'campaign_subscription');
        return $this->CI->campaign_subscription->get_campaign_subscription( $id );
    }

    function search_campaign_event( $id ) {
        $this->CI->load->model('CampaignEvent_model', 'event');
        return $this->CI->event->get_campaign_event( $id );
    }

}
?>