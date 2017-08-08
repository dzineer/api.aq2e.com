<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apiform extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ExternalAPIFormsfacade', null, 'external_api_forms_facade');
        $this->debug = $this->config->item('flags')['debug'];
        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->external_api_forms_facade->get_all_api_forms();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["external_api_forms" => $res]]));
    }

    public function lookup( $id ) {

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
            $res = $this->external_api_forms_facade->search_api_forms($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["external_api_forms" => $res]]));
        }
        //  echo 'hi';
    }
}

/* End of file Apiform.php */
/* Location: ./application/controllers/Apiform.php */
