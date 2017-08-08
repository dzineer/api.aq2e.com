<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Dbi
{
	var $Debug;
	var $connectedFlag;
	var $databaseType;
	var $noArraySP;

	private $CI;

	function __construct() {
		$this->Debug = 2;
		$this->connectedFlag = false;
		$this->CI =& get_instance();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');

	//	print '<br />';
		//print '<pre>'.print print_r($this->CI,true);
		$this->CI->load->library('db/vendor/microsoft/sqlsvr53tsinterface',null,'sqlsvr');
		//print '<pre>'.print print_r($this->CI->sqlsvr,true);
		if($this->CI->sqlsvr)
		if(!$this->CI->sqlsvr->isEnabled()) {
			$this->CI->load->library('db/vendor/microsoft/mssql52interface',null,'sqlsvr');
			if($this->CI->sqlsvr)
			if(!$this->CI->sqlsvr->isEnabled()) {
				print('Unable to connect to the database');
			} else {
				$databaseType = 'mssql52';
			}
		} else {
			$databaseType = 'sqlsvr53ts';
		}
		
		//printf("database type: %s", $databaseType); 
		//exit(0);
		
		$this->connectedFlag = true;
	}

	function isConnected() {
		return $this->connectedFlag;
	}

	function init($serverName, $dbUser, $dbPassword, $returnDatesAsString) {
		if($this->connectedFlag)
			$this->CI->sqlsvr->init($serverName, $dbUser, $dbPassword, $returnDatesAsString );
	}

	function begin_transaction() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->begin_transaction();
	}

	function commit() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->commit();
	}

	function rollback() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->rollback();
	}

	function query($s) {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->query($s);
	}
	
	function execute_prepared() {
		return $this->CI->sqlsvr->execute_prepared();
	}		

	function prepare( $tsql, $params ) {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->prepare( $tsql, $params );
	}	

	function fetch_array() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->fetch_array();
	}

	function next_result() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->next_result();
	}

	function call_sp($proc, $params) {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->call_sp($proc, $params);
	}

	function rows_affected() {
		return $this->CI->sqlsvr->rows_affected();
	}

	function fetch_assoc() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->fetch_assoc();
	}

	function free_stmt() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->free_stmt();
	}

	function close() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->close();
	}

	function errors() {
		if($this->connectedFlag)
			return $this->CI->sqlsvr->errors();
	}
	
	function connect($dbName) {

		//printf("<pre>");
		//echo $this->get_caller_info();

		if($this->connectedFlag) {
	//		print "Connectiong using: ".$this->databaseType;
			return $this->CI->sqlsvr->connect($dbName);
		}
	}


	function get_caller_info() {
	    $c = '';
	    $file = '';
	    $func = '';
	    $class = '';
	    $trace = debug_backtrace();
	    if (isset($trace[2])) {
	        $file = $trace[1]['file'];
	        $func = $trace[2]['function'];
	        if ((substr($func, 0, 7) == 'include') || (substr($func, 0, 7) == 'require')) {
	            $func = '';
	        }
	    } else if (isset($trace[1])) {
	        $file = $trace[1]['file'];
	        $func = '';
	    }
	    if (isset($trace[3]['class'])) {
	        $class = $trace[3]['class'];
	        $func = $trace[3]['function'];
	        $file = $trace[2]['file'];
	    } else if (isset($trace[2]['class'])) {
	        $class = $trace[2]['class'];
	        $func = $trace[2]['function'];
	        $file = $trace[1]['file'];
	    }
	    if ($file != '') $file = basename($file);
	    $c = $file . ": ";
	    $c .= ($class != '') ? ":" . $class . "->" : "";
	    $c .= ($func != '') ? $func . "(): " : "";
	    return($c);
	}

}