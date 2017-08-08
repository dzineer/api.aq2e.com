<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Eventfacade.php -
 *
 */

class Eventfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('Event_model', 'events');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function add_new_event( $desc, $event ) {
        return $this->CI->events->add_event(
                [
                    "description" => $desc,
                    "event" => $event
                ]
        );
    }

    function update_event( $id, $desc, $event ) {
        return $this->CI->events->update_event(

            $id,
            [
                "description" => $desc,
                "event" => $event
            ]
        );
    }

    function add_new_fired_event( $campaign_id, $event_id, $subscriber_id, $details ) {
        $this->CI->load->model('CampaignFiredEvent_model', 'fired_events');
        return $this->CI->fired_events->add_fired_event(
            [
                "campaign_id" => $campaign_id,
                "event_id" => $event_id,
                "subscriber_id" => $subscriber_id,
                "details" => $details
            ]
        );
    }

    function update_fired_event( $id, $campaign_id, $event_id, $subscriber_id, $details ) {
        $this->CI->load->model('CampaignFiredEvent_model', 'fired_events');
        return $this->CI->fired_events->add_fired_event(

            $id,
            [
                "campaign_id" => $campaign_id,
                "event_id" => $event_id,
                "subscriber_id" => $subscriber_id,
                "details" => $details
            ]
        );
    }

    function search_fired_event( $id ) {
        $this->CI->load->model('CampaignFiredEvent_model', 'fired_events');
        return $this->CI->events->get_fired_event( $id );
    }

    function get_all_fired_events() {
        $this->CI->load->model('CampaignFiredEvent_model', 'fired_events');
        return $this->CI->fired_events->get_all_fired_events();
    }


    function get_all_events() {
	    return $this->CI->events->get_all_events();
    }

    function search( $id ) {
        return $this->CI->events->get_event( $id );
    }

    function search_event( $id ) {
        return $this->CI->events->get_event( $id );
    }

}
?>