<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Mssql52
{
	var $Debug;
	var $functions = array('mssql_fetch_array','mssql_next_result','mssql_close' );
	var $serverName;
	var $dbName;
	var $dbUser;
	var $dbPassword;
	var $dbConn;
	var $sql;
	var $rs;
	var $arr;
	var $stmt;
	var $returnDatesAsString;

	function __construct() {
		$this->Debug = 2;
	}

	function init($serverName, $dbUser, $dbPassword, $returnDatesAsString=false) {
		$this->Debug = 2;
		$this->serverName = $serverName;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->returnDatesAsString = $returnDatesAsString;
	}

	function isEnabled() {
		foreach($this->functions as $funct) {
			if(!function_exists($funct)) {
				return false;
			}
		}
		return true;
	}

	function query($s) {
		$this->sql = $s;
	//	print 'SQL: '.print_r($this->sql, true);
		$this->stmt = mssql_query($s, $this->dbConn);
		return $this->stmt;
	}

	function fetch_array() {
		$this->arr = mssql_fetch_array($this->stmt);
		return $this->arr;
	}

	function next_result() {
		return mssql_next_result($this->stmt);
	}

	function call_sp($proc, $params) {
		$cmd = new MSSQL52DBCommand($this);
		$cmd->procedure($proc);
		$cmd->prepare($params);
		return $cmd->execute();
	}

	function rows_affected() {
		return mssql_rows_affected($this->stmt);
	}

	function fetch_assoc() {
		$this->arr = mssql_fetch_assoc($this->stmt);
		return $this->arr;
	}

	function begin_transaction() {
		return $this->query('BEGIN TRANS');
	}

	function commit() {
		return $this->query('COMMIT');
	}

	function rollback() {
		return $this->query('ROLLBACK');
	}

	function errors() {
		//return mssql_errors();
	}

	function free_stmt() {
		// free $this->stmt
		// mssql_free_result($this->stmt);
	}

	function execute() {
		mssql_execute($this->stmt);
	}

	function close() {
		return mssql_close($this->dbConn);
	}

	function connect($dbName) {
		$this->dbConn = mssql_connect($this->serverName, $this->dbUser, $this->dbPassword);
		$this->dbName = $dbName;
		if(!$this->dbConn || !mssql_select_db($this->dbName, $this->dbConn))
		{
			throw new ConnectException('Unable to connect to the mssql52 database');
		}
	}
}