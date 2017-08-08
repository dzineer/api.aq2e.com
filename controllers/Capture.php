<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Capture extends ResourceController
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

        $res = $this->campaignfacade->get_all_capture_links();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(["response" => ["capture_links" => $res]]));
    }
	
    private function local_empty( $s ) {
        if( $s == 0 || $s == '0' ) {
            return false;
        }
        return empty( $s );
    }

    public function capture_link_lookup( $id ) {

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
            $res = $this->campaignfacade->search_capture_link($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(["response" => ["capture_links" => $res]]));
        }
        //  echo 'hi';
    }
	
	public function capture_link_rule_lookup( $id ) {
		
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
			$res = $this->campaignfacade->search_capture_link_rules($id);
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(["response" => ["capture_link_rules" => $res]]));
		}
		//  echo 'hi';
	}
 
}

/* End of file Campaign_subscriber.php */
/* Location: ./application/controllers/capture_links.php */
