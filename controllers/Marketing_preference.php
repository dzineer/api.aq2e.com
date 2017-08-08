<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_preference extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->debug = $this->config->item('flags')['debug'];
       // $this->output->enable_profiler(true);
    }

    public function index() {

        $this->load->library('Marketingfacade', null, 'marketing');
        $res = $this->marketing->get_all_marketing_preferences();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["marketing_preferences" => $res]]));
    }
}

/* End of file Marketing_preferences.php */
/* Location: ./application/controllers/Marketing_preferences.php */
