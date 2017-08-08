<?php
/**
 * Filename: Auth_token.php
 * Project: api.aq2e.local
 * Editor: PhpStorm
 * Namespace: ${NAMESPACE}
 * Class:
 * Type:
 *
 * @author: Frank Decker
 * @since : 5/24/2017 12:47 AM
 */

// http://api.aq2emarketing.com/v1/auth_token?user_id=fdecker&password=btenpEyZmYd2y5cp&api_key=bf32e9fa-73b9-ff00-a5ac-48537833ad3c

class Auth_token extends ResourceController {
	
	public $debug;
	
	public function __construct()
	{
		parent::__construct();
		$this->debug = $this->config->item('flags')['debug'];
	}
	
	public function index() {
		
		/*$this->attributes( ['id'] );*/
		
		$this->get( function( $g ) {
			echo 'a: ' . print_r( $g, true );
		},['id']);
		
	}
	
	public function authorize() {
		
		$user_id = ( ! empty( $_GET ) && ! empty( $_GET['user_id'] ) ) ? $_GET['user_id'] : '';
		$password = ( ! empty( $_GET ) && ! empty( $_GET['password'] ) ) ? $_GET['password'] : '';
		$api_key = ( ! empty( $_GET ) && ! empty( $_GET['api_key'] ) ) ? $_GET['api_key'] : '';
		
		if( ! empty( $_GET['user_id'] ) && ! empty( $_GET['password'] ) && ! empty( $_GET['api_key'] ) ) {
			echo "<pre>" . print_r( $_GET, true );
		}
		else {
			echo 'not authorized';
		}
		
	}
} // end of Auth