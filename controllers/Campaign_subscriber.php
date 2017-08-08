<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_subscriber extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Campaignfacade');
        $this->debug = $this->config->item('flags')['debug'];
      //  $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->campaignfacade->get_all_campaign_subscribers();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["campaign_subscribers" => $res]]));
    }

    private function local_empty( $s ) {
        if( $s == 0 || $s == '0' ) {
            return false;
        }
        return empty( $s );
    }

    public function add_subscriber() {

        $campaign_id = ( ! $this->local_empty( $this->input->post('campaign_id', TRUE) ) ) ? $this->input->post('campaign_id', TRUE) : '';
        $subscriber_id = ( ! $this->local_empty( $this->input->post('subscriber_id', TRUE) ) ) ? $this->input->post('subscriber_id', TRUE) : '';
        $status = ( ! $this->local_empty( $this->input->post('status', TRUE) ) ) ? $this->input->post('status', TRUE) : '';
        $is_complete = ( ! $this->local_empty( $this->input->post('is_complete', TRUE) ) ) ? $this->input->post('is_complete', TRUE) : '';
        $lap = ( ! $this->local_empty( $this->input->post('lap', TRUE) ) ) ? $this->input->post('lap', TRUE) : '';
        $last_sent_email_index = ( ! $this->local_empty( $this->input->post('last_sent_email_index', TRUE) ) ) ? $this->input->post('last_sent_email_index', TRUE) : '';
        $last_email_sent_at = ( ! $this->local_empty( $this->input->post('last_email_sent_at', TRUE) ) ) ? $this->input->post('last_email_sent_at', TRUE) : '';

       // echo "<pre>" . print_r( $_POST, true ); exit;

        if( ! $this->local_empty( $campaign_id ) &&
            ! $this->local_empty( $subscriber_id ) &&
            ! $this->local_empty( $status ) &&
            ! $this->local_empty( $is_complete ) &&
            ! $this->local_empty( $lap ) ) {
       //     ! $this->local_empty( $last_sent_email_index ) &&
        //    ! $this->local_empty( $last_email_sent_at) ) {

            $this->campaignfacade->add_new_campaign_subscription(
                $campaign_id,
                $subscriber_id,
                $status,
                $is_complete,
                $lap
             //   $last_sent_email_index,
             //   $last_email_sent_at
            );
            return $this->index();
        } else {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "invalid parameters." ] ] ));
        }
    }

    public function add_campaign_subscriber_form() {
        $access_token = $_GET['access_token'];

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

        $this->load->view( 'forms/add_new_entity_form_view', [ "form_name" => "Add New Campaign Subscriber", "method" => "POST", "action" => "/v1/campaign_subscribers", "fields" => $fields ] );
    }

    public function campaign_subscriber_lookup( $id ) {

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
            $res = $this->campaignfacade->search($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["campaign_subscriber" => $res]]));
        }
        //  echo 'hi';
    }

}

/* End of file Campaign_subscriber.php */
/* Location: ./application/controllers/Campaign_subscriber.php */
