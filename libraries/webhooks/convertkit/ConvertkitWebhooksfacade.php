<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * convertkitWebhooksfacade.php -
 *
 */


if (!function_exists('json_log2screen')) {
	
	function json_log2screen( $obj )
	{
		header("Content-type: application/json");
		$s = json_encode( $obj, true );
		echo $s;
		exit;
	}
	
}

if (!class_exists('FD3DebugLogger')) {
	
	class FD3DebugLogger
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

if (!function_exists('convertkit_log')) {
	
	function convertkit_log($msgs, $logFile = 'api_aq2e_com_actions.log')
	{
		
		$logFile = '..\logs\api_aq2e_com_actions_subscriber.log';
		FD3DebugLogger::start( $logFile );
		
		if( is_array( $msgs ) ) {
			foreach ($msgs as $s) {
				FD3DebugLogger::log( $s );
			}
		}
		else {
			FD3DebugLogger::log( $msgs );
		}
		FD3DebugLogger::end();
		
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

class ConvertkitWebhooksfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();
		
		$this->CI->load->model('WebhookActionsReport_model', 'WebhookActionsReport');
		$this->CI->load->model('Subscriber_model', 'Subscriber');
		
		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function add_subscriber( $id, $params ) {
		
		if( ! $this->CI->Subscriber->get_subscriber_by_subscriber_id( $id ) ) {
			return $this->CI->Subscriber->add_subscriber( $params );
		}
		else {
			return $this->CI->Subscriber->update_subscriber( $id, $params );
		}
		
	}

/*SELECT [id]
,[campaign_id]
,[subscriber_id]
,[tag]
,[created_at]
FROM [aq2e_marketing_platforrm].[dbo].[aq2emp_campaign_subscriber_tags]*/
	
	function update_subscriber( $webhook_id, $subscriber_id, $params ) {
		
		//TODO: we do our subscriber actions here
		
		$this->CI->load->library('Registeredactionfacade', null, 'registered_action');
		$this->CI->load->model('CampaignSubscriberTag_model', 'subscriber_tag');
		
		convertkit_log(
			print_r(array( "webhook_id" => $webhook_id ), true)
		);
		
		$action = $this->CI->registered_action->search( $webhook_id );
		
		// fd3_http_response_code(200);
		
		// echo "Good";
		
		convertkit_log(
			print_r(array( "Action" => $action ), true)
		);
		
		
		convertkit_log(
			print_r(array( "info" => 'after action' ), true)
		);
		
		if( ! $this->CI->Subscriber->get_subscriber_by_subscriber_id( $subscriber_id ) ) {
			$this->CI->Subscriber->add_subscriber( $params );
			
		}
		else {
			$this->CI->Subscriber->update_subscriber( $subscriber_id, $params );
			
		}
		
		convertkit_log(
			print_r(array( "info" => 'after add,update subscriber' ), true)
		);
		
		if( ! empty( $action ) ) {
			// execute the action
			
			convertkit_log(
				print_r(array( "info" => 'action not empty' ), true)
			);
			
			convertkit_log(
				print_r(array( "action" => $action ), true)
			);
			
			convertkit_log(
				print_r(array( "subscriber info" => $subscriber_id ), true)
			);
			
			$cmd = $action['action'];
			$entity = $action['entity'];
			$tag = $action['name'];
			
			$this->CI->subscriber_tag->add_campaign_subscriber_tag( array( "subscriber_id" => strval( $subscriber_id ) , "tag" => $tag ) );
		}
		
	}
	
	function get_all_reports() {
		$actions = $this->CI->WebhookActionsReport->get_all_reports();
		foreach( $actions as $key => $rec ) {
			// echo "<pre>" . $key;
			// echo "<pre>" . print_r( $rec,true );
			$actions[ $key ]['data'] = json_decode( unserialize( $rec['data'] ), true );
			
		}
	    return $actions;
    }
	
	function add_report( $params ) {
		$action = $this->CI->WebhookActionsReport->add_report( $params );
		return $action;
	}
    
    function search( $id ) {
        $action = $this->CI->WebhookActionsReport->get_report( $id );
        return $action;
    }

}
?>