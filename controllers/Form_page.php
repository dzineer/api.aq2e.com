<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Form_page extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Formsfacade');
        $this->debug = $this->config->item('flags')['debug'];
        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->formsfacade->get_all_form_pages();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["form_pages" => $res]]));
    }
/*

    public function add_campaign() {

        $campaign_id = ( ! empty( $_POST['campaign_id'] ) ) ? $_POST['campaign_id'] : '';
        $subscriber_id = ( ! empty( $_POST['subscriber_id'] ) ) ? $_POST['subscriber_id'] : '';
        $status = ( ! empty( $_POST['status'] ) ) ? $_POST['status'] : '';
        $is_complete = ( ! empty( $_POST['is_complete'] ) ) ? $_POST['is_complete'] : '';
        $lap = ( ! empty( $_POST['lap'] ) ) ? $_POST['lap'] : '';
        $last_sent_email_index = ( ! empty( $_POST['last_sent_email_index'] ) ) ? $_POST['last_sent_email_index'] : '';
        $last_email_sent_at = ( ! empty( $_POST['last_email_sent_at'] ) ) ? $_POST['last_email_sent_at'] : '';

        // echo "<pre>" . print_r( $_POST, true );

        if( ! empty( $campaign_id ) &&
            ! empty( $subscriber_id ) &&
            ! empty( $status ) &&
            ! empty( $is_complete ) &&
            ! empty( $lap ) &&
            ! empty( $last_sent_email_index ) &&
            ! empty( $last_email_sent_at) ) {

            $this->eventfacade->add_new_campaign_subscription(
                $campaign_id,
                $subscriber_id,
                $status,
                $is_complete,
                $lap,
                $last_sent_email_index,
                $last_email_sent_at
            );
            return $this->fired_event();
        } else {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "invalid parameters." ] ] ));
        }
    }*/
	
	public function add_webhook_form() {
		$access_token = $_GET['access_token'];
		$id = $this->uri->segment(3, 0);
		
		$fields = [
			[ "type" => "input", "name" => "campaign_id", "value" => "" ],
			[ "type" => "input", "name" => "subscriber_id", "value" => "" ],
			[ "type" => "input", "name" => "status", "value" => "" ],
			[ "type" => "input", "name" => "is_complete", "value" => "" ],
			[ "type" => "input", "name" => "lap", "value" => "" ],
			[ "type" => "input", "name" => "last_sent_email_index", "value" => "" ],
			[ "type" => "input", "name" => "last_email_sent_at", "value" => "" ],
			[ "type" => "hidden", "name" => "access_token", "value" => $access_token ]
		];
		
		$this->load->view( 'forms/add_new_entity_form_view', [ "form_name" => "Send Content Of Subscriber", "method" => "POST", "action" => "/webhook_action/webhook_callback/$id", "fields" => $fields ] );
	}
	
    public function form_page_action_lookup( $id ) {

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
            $res = $this->formsfacade->search_form_page( $id );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["form_page" => $res]]));
        }
        //  echo 'hi';
    }
}

/* End of file Registered_action.php */
/* Location: ./application/controllers/Webhook_action.php */
