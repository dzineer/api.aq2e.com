<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Eventfacade');
        $this->debug = $this->config->item('flags')['debug'];

        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->eventfacade->get_all_events();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["events" => $res]]));
    }

    public function fired_event() {
        $res = $this->eventfacade->get_all_fired_events();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["events" => $res]]));
    }

    public function add_fired_event_form() {
        $access_token = $_GET['access_token'];

        $fields = [
            [ "type" => "input", "name" => "campaign_id", "value" => "" ],
            [ "type" => "input", "name" => "event_id", "value" => "" ],
            [ "type" => "input", "name" => "subscriber_id", "value" => "" ],
            [ "type" => "input", "name" => "details", "value" => "" ],
            [ "type" => "hidden", "name" => "access_token", "value" => $access_token ]
        ];

        $this->load->view( 'events/add_new_event_fired_form_view', [ "method" => "POST", "action" => "/v1/add_fired_event", "fields" => $fields ] );
    }

    public function add_fired_event() {

        $campaign_id = ( ! empty( $_POST['campaign_id'] ) ) ? $_POST['campaign_id'] : '';
        $event_id = ( ! empty( $_POST['event_id'] ) ) ? $_POST['event_id'] : '';
        $subscriber_id = ( ! empty( $_POST['subscriber_id'] ) ) ? $_POST['subscriber_id'] : '';
        $details = ( ! empty( $_POST['details'] ) ) ? $_POST['details'] : '';

        // echo "<pre>" . print_r( $_POST, true );

        if( ! empty( $campaign_id ) && ! empty( $event_id ) && ! empty( $subscriber_id ) && ! empty( $details ) ) {
            $this->eventfacade->add_new_fired_event(
                                                     $campaign_id,
                                                     $event_id,
                                                     $subscriber_id,
                                                     $details
                                                   );
            return $this->fired_event();
        } else {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "invalid parameters." ] ] ));
        }
    }


    public function add_event() {
        $desc = ( ! empty( $_POST['description'] ) ) ? $_POST['description'] : '';
        $event = ( ! empty( $_POST['event'] ) ) ? $_POST['event'] : '';

       // echo "<pre>" . print_r( $_POST, true );

        if( ! empty( $desc ) && ! empty( $event ) ) {
            $this->eventfacade->add_new_event( $desc, $event );
            return $this->index();
        } else {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "invalid parameters." ] ] ));
        }
    }

    public function add_event_form() {
        $access_token = $_GET['access_token'];
        $fields = [ [ "type" => "input", "name" => "description", "value" => "" ], [ "type" => "input", "name" => "event", "value" => "" ], [ "type" => "hidden", "name" => "access_token", "value" => $access_token ] ];
        $this->load->view( 'events/add_new_event_form_view', [ "method" => "POST", "action" => "/v1/events", "fields" => $fields ] );
    }

    public function fired_event_lookup( $id ) {

        // echo "<br>id: " . $id . "<br>";
        //  $this->output->enable_profiler(true);
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
            $res = $this->eventfacade->search_fired_event($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["event" => $res]]));
        }
        //  echo 'hi';
    }

    public function event_lookup( $id ) {

        // echo "<br>id: " . $id . "<br>";
      //  $this->output->enable_profiler(true);
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
            $res = $this->eventfacade->search_event($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["event" => $res]]));
        }
        //  echo 'hi';
    }

}

/* End of file Event.php */
/* Location: ./application/controllers/Event.php */
