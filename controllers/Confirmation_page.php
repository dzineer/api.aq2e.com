<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmation_page extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Campaignfacade');
        $this->debug = $this->config->item('flags')['debug'];
        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->campaignfacade->get_all_confirmation_pages();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["confirmation_pages" => $res]]));
    }

    public function page_lookup( $id ) {

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
            $res = $this->campaignfacade->search_confirmation_page( $id );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["confirmation_page" => $res]]));
        }
        //  echo 'hi';
    }
}

/* End of file Confirmation_page.php */
/* Location: ./application/controllers/Confirmation_page.php */
