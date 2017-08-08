<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->debug = $this->config->item('flags')['debug'];
    }

    public function index() {
        $this->load->library('Productfacade');
        $this->productfacade->getAll();

        /*$this->attributes( ['id'] );*/

/*        $this->get( function( $g ) {
            echo 'a: ' . print_r( $g, true );
        },['id']);*/
    }

    public function product_lookup( $id ) {
        $this->load->library('Productfacade');
        $id = $this->uri->segment(3);

        $this->productfacade->search( $id );
        //  echo 'hi';
    }

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */
