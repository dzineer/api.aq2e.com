<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class ResourceController extends CI_Controller {

	/**
	 * Constructor
	 */
	/**
	 * Constructor
	 */
	private $http_method;
	private $attributes;
	private $path;
	private $path_length;
	const MINIMUM_SEGMENTS = 1;
	public function __construct()
	{
		parent::__construct();	
		// $this->check_session();	
		$this->parse_url();
		$this->getMethod();
		$this->validateOAuth2();
	}

	protected function validateOAuth2() {
		require_once 'OAuth2\secure_resource.php';
	}

	private function parse_url() {
		$this->load->helper('url');
		$this->path_length = $this->uri->total_segments();

/*		if( $this->path_length < MY_ResourceController::MINIMUM_SEGMENTS ) {
			die("invalid request");
		}*/

		// echo "<pre>path_length: ".$this->path_length; exit;

	}

	private function saveGet( $vars=[] ) {
		$getArr = [];
		$varIndex = 0;

		// echo "<pre>".print_r( $_GET,true );
		// echo "<pre>".print_r( $vars,true );

		if( ! empty( $vars )) {
			foreach( $_GET as $get_key => $get_value ) {
				if( $get_key == $vars[ $varIndex ] ) // did we find the key? 
					$getArr[ $get_key ] = $get_value;

				$varIndex = $varIndex + 1;	
			}
		} else {
			foreach( $_GET as $get_key => $get_value ) {
				$getArr[ $get_key ] = $get_value;
			}
		}

		// echo "<pre>".print_r( $getArr,true ); exit;
		return $getArr;
	}

	private function savePut() {

	}

	private function savePost() {

	}

	private function saveDelete() {

	}

	private function saveOptions() {

	}

	private function getVars( $vars = [] ) {
		// echo "<pre>".print_r( $vars,true ); exit;
		// echo "<pre>". $this->http_method; exit;
		if( !empty( $this->http_method) ) {
			switch( $this->http_method ) {
				case 'GET':
					return $this->saveGet( $vars );
			}
		}
	}
	/**
	 * get
	 * params: calback, get_vars - if provided get the vars and only the vars provided
	 */
	protected function get( $callback, $get_vars=[] ) {
		if(!empty($get_vars)) { // let's define our expected attributes
			$this->attributes( $get_vars );
		}

		$vars = $this->getVars( $get_vars );
		$callback( $vars );
	}

	protected function attributes( $params=[] ) {
		$this->attributes = $params;

		// echo print_r( $this->attributes, true );
	}

	private function getMethod() {
		$this->http_method = $_SERVER['REQUEST_METHOD'];

	}

	protected function post( $callback, $post_vars=[] ) {
		if(!empty($post_vars)) { // let's define our expected attributes
			$this->attributes( $post_vars );
		}

		$vars = $this->getVars( $post_vars );
		$callback( $vars );
	}

	protected function put( $callback, $put_vars=[] ) {
		if(!empty($put_vars)) { // let's define our expected attributes
			$this->attributes( $put_vars );
		}

		$vars = $this->getVars( $put_vars );
		$callback( $vars );
	}

	protected function delete( $callback, $delete_vars=[] ) {
		if(!empty($delete_vars)) { // let's define our expected attributes
			$this->attributes( $delete_vars );
		}

		$vars = $this->getVars( $delete_vars );
		$callback( $vars );
	}

	protected function options( $callback, $options_vars=[] ) {
		if(!empty($options_vars)) { // let's define our expected attributes
			$this->attributes( $options_vars );
		}

		$vars = $this->getVars( $options_vars );
		$callback( $vars );
	}

	protected function check_session()
	{
		if(session_id() == '') {
			session_start();
			
			if($_SERVER['REMOTE_ADDR'] == '64.239.131.130') {
				// printf("%s", print_r($_SESSION,true));
			}
		}	   
	
		if(isset($_SESSION['LOGGED_IN'])) {
			if(!$_SESSION['LOGGED_IN'] == '1') {
				if(isset($_SESSION['LOGIN_URI'])) {
					header(sprintf("Location: %s", $_SESSION['LOGIN_URI']));
					exit(0);			   
				}
			}
		}
		else {
			if(isset($_SESSION['LOGIN_URI'])) {
				header(sprintf("Location: %s", $_SESSION['LOGIN_URI']));
				exit(0);			   
			}
			else {
				header(sprintf("Location: %s", "/login"));
				exit(0);				
			}
		}
	}
		
	protected function check_access_level() {
		if(isset($_SESSION['SITE_LEVEL']) && !$_SESSION['SITE_LEVEL'] == '200') {
			if(isset($_SESSION['LOGIN_URI'])) {
				header(sprintf("Location: %s", $_SESSION['LOGIN_URI']));
				exit(0);			   
			}		   
		}		
	}
		
	protected function check_required_access_level($access_level) {
		if(isset($_SESSION['SITE_LEVEL']) && !$_SESSION['SITE_LEVEL'] == $access_level) {
			if(isset($_SESSION['LOGIN_URI'])) {
				header(sprintf("Location: %s", $_SESSION['LOGIN_URI']));
				exit(0);			   
			}		   
		}		
	}	
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/MY_ResourceController.php */