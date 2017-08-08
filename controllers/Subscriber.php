<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Subscriberfacade', null, 'subscriber_facade');
        $this->debug = $this->config->item('flags')['debug'];
      //  $this->output->enable_profiler(true);
    }
    
    /*

      ,account_id
      ,email
      ,first_name
      ,last_name
      ,full_name
      ,subscriber_id
      ,state
      ,time_zone
      ,tags
      ,has_custom_fields
    
    */
    
    public function index() {

        $res = $this->subscriber_facade->get_all_subscribers();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["subscribers" => $res]]));
    }

    private function local_empty( $s ) {
        if( $s == 0 || $s == '0' ) {
            return false;
        }
        return empty( $s );
    }

    public function add_subscriber() {
	
	    $account_id = ( ! $this->local_empty( $this->input->post('account_id', TRUE) ) ) ? $this->input->post('account_id', TRUE) : '';
	    $subscriber_id = ( ! $this->local_empty( $this->input->post('subscriber_id', TRUE) ) ) ? $this->input->post('subscriber_id', TRUE) : '';
    	$subscriber_first_name = ( ! $this->local_empty( $this->input->post('first_name', TRUE) ) ) ? $this->input->post('first_name', TRUE) : '';
        $subscriber_email = ( ! $this->local_empty( $this->input->post('email', TRUE) ) ) ? $this->input->post('email', TRUE) : '';
        $subscriber_phone = ( ! $this->local_empty( $this->input->post('phone', TRUE) ) ) ? $this->input->post('phone', TRUE) : '';

       // echo "<pre>" . print_r( $_POST, true ); exit;

        if( ! $this->local_empty( $account_id ) &&
            ! $this->local_empty( $subscriber_id ) &&
            ! $this->local_empty( $subscriber_first_name ) &&
            ! $this->local_empty( $subscriber_email ) &&
            ! $this->local_empty( $subscriber_phone ) ) {
       //     ! $this->local_empty( $last_sent_email_index ) &&
        //    ! $this->local_empty( $last_email_sent_at) ) {

            $this->subscriber_facade->add_new_subscriber(
	            $account_id,
	            $subscriber_id,
	            $subscriber_first_name,
	            $subscriber_email,
	            $subscriber_phone
            );
            return $this->index();
        } else {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "invalid parameters." ] ] ));
        }
    }

    public function add_subscriber_form() {
    	
        $access_token = $_GET['access_token'];

        $fields = [
	        [ "type" => "input", "name" => "account_id", "value" => "" ],
	        [ "type" => "input", "name" => "subscriber_id", "value" => "" ],
	        [ "type" => "input", "name" => "first_name", "value" => "" ],
            [ "type" => "input", "name" => "email", "value" => "" ],
            [ "type" => "input", "name" => "phone", "value" => "" ],
            [ "type" => "hidden", "name" => "access_token", "value" => $access_token ]
        ];

        $this->load->view( 'forms/add_new_entity_form_view', [ "form_name" => "Add New Subscriber", "method" => "POST", "action" => "/v1/subscribers", "fields" => $fields, "button_text" => "Add Subscriber" ] );
        
    }

    public function subscriber_lookup( $id ) {

        // echo "<br>id: " . $id . "<br>";
        $id = $this->uri->segment(3, 0);
        // echo "<br>id: " . $id . "<br>";
        if( $id == 0 ) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "id is required." ] ] ));
           // exit;
        }
        else {
            // $this->output->enable_profiler(true);
            $res = $this->subscriber_facade->search( $id );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( ["response" => ["subscriber" => $res] ] ) );
        }
        //  echo 'hi';
    }

}

/* End of file Subscriber.php */
/* Location: ./application/controllers/Subscriber.php */
