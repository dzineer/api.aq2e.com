<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Sqlsvr53ts
{
	var $Debug;
//	var $functions = array('sqlsrv_errors', 'sqlsrv_fetch_array','sqlsrv_free_stmt','sqlsrv_next_result','sqlsrv_close' );
	var $functions = array('sqlsrv_fetch_array','sqlsrv_free_stmt','sqlsrv_next_result','sqlsrv_close' );
	var $connectionInfo;
	var $serverName;
	var $dbName;
	var $dbUser;
	var $dbPassword;
	var $dbConn;
	var $sql;
	var $rs;
	var $arr;
	var $stmt;
	var $params;
	var $returnDatesAsString;
	var $noArraySP;
	var $status;

	function __construct() {
		$this->Debug = 2;
	}

	function init($serverName, $dbUser, $dbPassword, $returnDatesAsString=true) {
		$this->Debug = 2;
		$this->serverName = $serverName;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->returnDatesAsString = $returnDatesAsString;
	}

	function isEnabled() {
		foreach($this->functions as $funct) {
			if(!function_exists($funct)) {
			//	print "!!!Not Using SQLSVR53TS!!!"; exit(0);
				return false;
			}
		}

		//print "!!! Using SQLSVR53TS!!!"; exit(0);

		return true;
	}

	function call_sp($proc, $params) {
		$cmd = new SQLSVR53DBCommandDB($this);
		$cmd->procedure($proc);
		$cmd->prepare($params);
		$this->stmt = $cmd->execute();
	}

	function rows_affected(){
		return sqlsrv_rows_affected($this->stmt);
	}

	function query($s, $params=array()) {

		$starttime = microtime(true);//XXX-debug

		$this->sql = $s;

		//print '<br/><pre>'.$s.'<br/>';

		$this->params = $params;
		$this->stmt = sqlsrv_query($this->dbConn, $this->sql, $this->params);

		if($_SERVER['REMOTE_ADDR'] == '183.89.189.188') {
			$stoptime = microtime(true);
			$time = $stoptime - $starttime; 
			echo("\n<pre>");
			echo("start: $starttime\n");
			echo("stop: $stoptime\n");
			echo("<b>Execution Time</b>: ".round($time, 4)." seconds\n");
			echo("<b>Memory Usage</b>: ".memory_get_usage()." bytes");
			echo("</pre>");
		}

		return $this->stmt;
	}

	function fetch_array() {
		
		// printf("<pre><br>fetch_array results: %s", print_r($this->stmt,true));		
		
		$this->arr = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC);
		return $this->arr;
	}

	function next_result() {
		return sqlsrv_next_result($this->stmt);
	}

	function fetch_assoc() {
		$this->arr = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC);
		return $this->arr;
	}

	function free_stmt() {
		return sqlsrv_free_stmt( $this->stmt );
	}

	function close() {
	//	sqlsrv_close($this->dbConn);
	}

	function begin_transaction() {
		return sqlsrv_begin_transaction($this->dbConn);
	}

	function commit() {
		return sqlsrv_commit($this->dbConn);
	}

	function rollback() {
		return sqlsrv_rollback($this->dbConn);
	}

	function execute() {
		$this->call_sp($this->stmt);
	}
	
	function execute_prepared() {
		$this->status = sqlsrv_execute( $this->stmt );
		return $this->status;
	}	
	
	function prepare( $tsql, $params ) {
		$this->stmt = sqlsrv_prepare( $this->dbConn, $tsql, $params );

		return $this->stmt;
	}	

	function errors() {
		return sqlsrv_errors();
	}
	
	function connect($dbName) {
		$this->dbName = $dbName;

	//	print '<pre>'.print_r($this,true);

		$starttime = microtime(true);//XXX-debug

		$this->connectionInfo = array( "Database"=>$this->dbName, "UID"=>$this->dbUser, "PWD"=>$this->dbPassword, "ReturnDatesAsStrings" => '"'+$this->returnDatesAsString+'"');

		//printf("<pre>");
		//echo $this->get_caller_info();

		//print '<pre>: serverName: '.$this->serverName;
		//print '<pre>: connectionInfo: '.print_r($this->connectionInfo,true);

		//exit(0);
		//phpinfo();
		//exit(0);


		$this->dbConn = sqlsrv_connect( $this->serverName, $this->connectionInfo);

		if($_SERVER['REMOTE_ADDR'] == '183.89.189.188') {
			$stoptime = microtime(true);
			$time = $stoptime - $starttime; 
			echo("\n<pre>");
			echo("start: $starttime\n");
			echo("stop: $stoptime\n");
			echo("<b>Execution Time</b>: ".round($time, 4)." seconds\n");
			echo("<b>Memory Usage</b>: ".memory_get_usage()." bytes");
			echo("</pre>");
		}

		if( $this->dbConn )
		{
		   //  echo "Connection established.\n";
		}
		else
		{
			 print '<pre>'.print_r($this->connectionInfo,true);
		     echo "Unable to connect to the sqlsvr53ts database\n";
			 print '<pre>'.print_r($this,true);
		     die( print '<pre><br>'. sqlsrv_errors().' '.phpinfo());
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