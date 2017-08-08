<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Sqlsvr53tsinterface
{
	var $Debug;
	private $CI;

	function __construct() {
		$this->Debug = 2;
		$this->CI =& get_instance();
		$this->CI->load->library('sqlsvr53ts',null,'frank');
	}

	function init($serverName, $dbUser, $dbPassword, $returnDatesAsString) {
		//print "<br />serverName: ".$serverName.", dbUser: ".$dbUser.", dbPassword: ".$dbPassword.", returnDatesAsString: ".$returnDatesAsString;
		$this->CI->frank->init($serverName, $dbUser, $dbPassword, true );
	}

	function isEnabled() {
		return $this->CI->frank->isEnabled();
	}

	function query($s) {
		return $this->CI->frank->query($s);
	}

	function begin_transaction() {
		return $this->CI->frank->begin_transaction();
	}

	function commit() {
		return $this->CI->frank->commit();
	}

	function rollback() {
		return $this->CI->frank->rollback();
	}

	function fetch_array() {
		return $this->CI->frank->fetch_array();
	}

	function next_result() {
		return $this->CI->frank->next_result();
	}

	function call_sp($proc, $params) {
		return $this->CI->frank->call_sp($proc, $params);
	}

	function rows_affected() {
		return $this->CI->frank->rows_affected();
	}

	function fetch_assoc() {
		return $this->CI->frank->fetch_assoc();
	}

	function errors() {
		return $this->CI->frank->errors();
	}
	
	function execute_prepared() {
		return $this->CI->frank->execute_prepared();
	}		
	
	function prepare( $tsql, $params ) {
		return $this->CI->frank->prepare( $tsql, $params );
	}
	
	function free_stmt() {
		return $this->CI->frank->free_stmt();
	}

	function close() {
		return $this->CI->frank->close();
	}

	function connect($dbName) {
		return $this->CI->frank->connect($dbName);
	}
}