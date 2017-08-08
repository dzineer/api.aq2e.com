<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_link_monitor extends ResourceController
{
    public $debug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Registeredcampaignlinkfacade');
        $this->debug = $this->config->item('flags')['debug'];
        // $this->output->enable_profiler(true);
    }

    public function index() {

        $res = $this->registeredcampaignlinkfacade->get_all_registered_links();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["registered_links" => $res]]));
    }
	
	private function local_empty( $s ) {
		if( $s == 0 || $s == '0' ) {
			return false;
		}
		return empty( $s );
	}

    public function link_clicked() {
		
		$hash = ( ! $this->local_empty( $this->input->post('hash', TRUE) ) ) ? $this->input->post('hash', TRUE) : '';
		$email = ( ! $this->local_empty( $this->input->post('email', TRUE) ) ) ? $this->input->post('email', TRUE) : '';
		   
	    $this->registeredcampaignlinkfacade->register_clicked_link( $hash, $email );
	    
    }
    
    public function registered_link_lookup( $hash ) {

        // echo "<br>id: " . $id . "<br>"; exit;
	    $hash = $this->uri->segment(3, 0);
	   // echo "<br>id: " . $id . "<br>"; exit;
        // echo "<br>id: " . $id . "<br>";
        if( strlen($hash ) == 0 ) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( [ "response" => [ "error" => "id is required." ] ] ));
            // exit;
        }
        else {
            // $this->output->enable_profiler(true);
	        $res = $this->registeredcampaignlinkfacade->search( $hash );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["registered_link" => $res]]));
        }
        //  echo 'hi';
    }
}

/* End of file Registered_action.php */
/* Location: ./application/controllers/Link_monitor.php */
