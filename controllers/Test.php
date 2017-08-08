<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: niran
 * Date: 5/28/2017
 * Time: 12:48 PM
 */
class Test extends CI_Controller
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->debug = $this->config->item('flags')['debug'];
        $this->output->enable_profiler(true);
    }

    public function db() {
/*        $this->load->model('Account_model', 'account');
        $res = $this->account->get_all_aq2emp_accounts();
        echo print_r( $res, true );*/

/*        $this->load->model('Campaign_model', 'campaign');
        $res = $this->campaign->get_all_aq2emp_campaigns();
        echo print_r( $res, true );*/

        $this->load->model('Site_model', 'site');
        $res = $this->site->get_site( '30001' );
        echo '<pre>site: ' . print_r( $res, true );
    }
}