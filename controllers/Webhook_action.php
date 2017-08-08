<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('aq2emm_json_log2screen')) {
	
	function aq2emm_json_log2screen( $obj )
	{
		header("Content-type: application/json");
		$s = json_encode( $obj, true );
		echo $s;
		exit;
	}
	
}

if (!class_exists('AQ2EMM_WPDebugLogger')) {
	
	class AQ2EMM_WPDebugLogger
	{
		static $fd;
		static $logs;
		static $buffer;
		
		public static function start($logFile = 'api_aq2e_com_actions.log')
		{
			self::$logs = array();
			// echo "creating log file: " . $logFile;
			// exit;
			self::$fd = fopen($logFile, "a+");
		}
		
		public static function log($str, $level = 'INFO')
		{
			if (is_array($str)) {
				static::$logs[] = "\n" . "[" . $level . "]" . "[" . $_SERVER['REMOTE_ADDR'] . "]" . "[" . date("Y/m/d h:i:s", time()) . "] " . print_r($str, true);
			} else {
				static::$logs[] = "\n" . "[" . $level . "]" . "[" . $_SERVER['REMOTE_ADDR'] . "]" . "[" . date("Y/m/d h:i:s", time()) . "] " . $str;
			}
			
		}
		
		public static function end()
		{
			// write string
			static::$buffer = '';
			
			$s_cwd = getcwd();
			
			$s_cwd = '----------------- ' . $s_cwd . ' -----------------';
			
			foreach (self::$logs as $log) {
				static::$buffer = static::$buffer . $log;
			}
			
			fwrite(self::$fd, $s_cwd . "\n");
			fwrite(self::$fd, self::$buffer . "\n");
			
			// close file
			fclose(self::$fd);
		}
	}
}

if (!function_exists('aq2emm_convertkit_log')) {
	
	function aq2emm_convertkit_log($msgs, $logFile = 'api_aq2e_com_actions.log')
	{
		
		$logFile = '..\logs\api_aq2e_com_actions.log';
		AQ2EMM_WPDebugLogger::start( $logFile );
		
		if( is_array( $msgs ) ) {
			foreach ($msgs as $s) {
				AQ2EMM_WPDebugLogger::log( $s );
			}
		}
		else {
			AQ2EMM_WPDebugLogger::log( $msgs );
		}
		AQ2EMM_WPDebugLogger::end();
		
	}
	
}

if (!function_exists('fd3_http_response_code')) {
	function fd3_http_response_code($code = NULL) {
		
		if ($code !== NULL) {
			
			switch ($code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
					exit('Unknown http status code "' . htmlentities($code) . '"');
					break;
			}
			
			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
			
			header($protocol . ' ' . $code . ' ' . $text);
			
			$GLOBALS['http_response_code'] = $code;
			
		} else {
			
			$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
			
		}
		
		return $code;
		
	}
}

class Webhook_action extends ResourceController
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
	
	public function webhook_callback( $id ) {
		
		// echo "<br>id: " . $id . "<br>";
		$webhook_id = $this->uri->segment(3, 0);
		// echo "<br>id: " . $id . "<br>";
		if( $webhook_id == 0 ) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode( [ "response" => [ "error" => "id is required." ] ] ));
			// exit;
		}
		else {
			// $this->output->enable_profiler(true);
			
			/* TODO: 1.) Store reaction in db as log. 2.) Store according to action in db */
			
			$this->load->library('webhooks/convertkit/ConvertkitWebhooksfacade', null, 'cwhf');
			
			$subscriber_id = ( ! empty( $_POST['subscriber_id'] ) ) ? $_POST['subscriber_id'] : '';
			
			// echo "<pre>" . print_r( $_POST, true );

			$HTTP_RAW_POST_DATA = file_get_contents('php://input');
			
			$data = json_decode( $HTTP_RAW_POST_DATA, true );
			
			if( ! empty($data) ) {
				
				$params = [
					"subscriber_id" => $data["subscriber"]["id"],
					"data"          => serialize( $HTTP_RAW_POST_DATA ),
					"registered_action_id" => intval( $webhook_id )
				];
				
				$this->cwhf->add_report( $params );
				
				$params2 = [
					"subscriber_id"        => $data["subscriber"]["id"],
					"first_name"           => $data["subscriber"]["first_name"],
					"email"                => $data["subscriber"]["email_address"],
					"state"                => $data["subscriber"]["state"],
					"phone"                => $data["subscriber"]["fields"]["phone"],
					"account_id"           => $data["subscriber"]["fields"]["agent_account_id"]
				];
				
				/*
				 * SELECT
				 *     [id]
				      ,[site_num]
				      ,[email]
				      ,[first_name]
				      ,[last_name]
				      ,[full_name]
				      ,[time_zone]
				      ,[tags]
				      ,[has_custom_fields]
				  FROM [aq2e_marketing_platforrm].[dbo].[aq2emp_subscribers]
				 */
				
				$this->cwhf->update_subscriber( $webhook_id, $params2["subscriber_id"], $params2 );
				
			}
			
			fd3_http_response_code(200);
			
			// echo "Good";
			
			aq2emm_convertkit_log(
				print_r(array("_POST" => $HTTP_RAW_POST_DATA, "webhook_callback" => $res), true)
			);
			
			// exit(0);
			
			// aq2emm_json_log2screen(array("_POST" => $HTTP_RAW_POST_DATA, "webhook_callback" => $res));
			
/*			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(["response" => ["webhook_reaction" => $res]]));*/
		}
		//  echo 'hi';
	}

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
/* Location: ./application/controllers/Webhook_action.php */
