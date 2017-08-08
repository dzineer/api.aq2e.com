<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->debug = $this->config->item('flags')['debug'];
        $this->validateOAuth2();
    }

    public function index() {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode( [ "response" => [ "error" => "id is required." ] ] ));

        /*        $this->get( function( $g ) {
                    echo 'a: ' . print_r( $g, true );
                },['id']);*/
    }

    public function site_lookup( $id ) {
        $this->load->library('Sitefacade');
        $id = $this->uri->segment(3);
       // $this->output->enable_profiler(true);
        $res = $this->sitefacade->search( $id );
    //    echo '<br/>' . print_r( $res, true ) . "<pre>";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode( [ "response" => [ "site" => $res ] ] ));
    }

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */
