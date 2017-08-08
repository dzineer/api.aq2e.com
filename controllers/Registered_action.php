<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registered_action extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('RegisteredActionfacade');
        $this->debug = $this->config->item('flags')['debug'];
        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->registeredactionfacade->get_all_registered_actions();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["registered_actions" => $res]]));
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

    public function registered_action_lookup( $id ) {

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
            $res = $this->registeredactionfacade->search($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["registered_action" => $res]]));
        }
        //  echo 'hi';
    }
}

/* End of file Registered_action.php */
/* Location: ./application/controllers/Registered_action.php */
