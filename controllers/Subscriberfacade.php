<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Campaignfacade.php -
 *
 */

class Subscriberfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('Subscriber_model', 'subscriber');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function add_new_subscriber( $account_id,
                                 $subscriber_id,
                                 $name,
                                 $email,
                                 $phone ) {
		
		$subscriber = $this->CI->subscriber->get_subscriber_by_email( $email );
		
		if( ! count( $subscriber ) ) {

			return $this->CI->subscriber->add_subscriber(
				
				[
					"account_id" => $account_id,
					"subscriber_id" => $subscriber_id,
					"first_name" => $name,
					"email" => $email,
					"phone" => $phone
				]
			);
			
		}
		
    }
	
	function get_all_subscribers() {
		return $this->CI->subscriber->get_all_subscribers();
	}
	
	function search_subscriber( $id ) {
		$subscriber = $this->CI->subscriber->get_subscriber( $id );
		if( ! count( $subscriber ) ) {
		
		}
	}
	
    function update_subscriber( $id,
                                $account_id,
                                $subscriber_id,
                                $name,
                                $email,
                                $phone ) {
        return $this->CI->subscriber->update_subscriber (

            $id,
            [
	            "account_id" => $account_id,
	            "subscriber_id" => $subscriber_id,
	            "first_name" => $name,
	            "email" => $email,
	            "phone" => $phone
            ]
        );
    }

}
?>