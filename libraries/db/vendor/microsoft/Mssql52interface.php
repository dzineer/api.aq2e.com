<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Mssql52interface
{
	var $Debug;
	private $CI;

	function __construct() {
		$this->Debug = 2;
		$this->CI =& get_instance();
		$this->CI->load->library('db/vendor/microsoft/mssql52', null, 'mssql');
	}

	function init($serverName, $dbUser, $dbPassword, $returnDatesAsString) {
		$this->CI->mssql->init($serverName, $dbUser, $dbPassword, $returnDatesAsString );
	}

	function isEnabled() {
		return $this->CI->mssql->isEnabled();
	}

	function query($s) {
		return $this->CI->mssql->query($s);
	}

	function begin_transaction() {
		return $this->CI->mssql->begin_transaction();
	}

	function commit() {
		return $this->CI->mssql->commit();
	}

	function rollback() {
		return $this->CI->mssql->rollback();
	}

	function fetch_array() {
		return $this->CI->mssql->fetch_array();
	}

	function next_result() {
		return $this->CI->mssql->next_result();
	}

	function call_sp($proc, $params) {
		return $this->CI->mssql->call_sp($proc, $params);
	}

	function rows_affected() {
		return $this->CI->mssql->rows_affected();
	}

	function errors() {
		return $this->CI->mssql->errors();
	}

	function fetch_assoc() {
		return $this->CI->mssql->fetch_assoc();
	}

	function free_stmt() {
		return $this->CI->mssql->free_stmt();
	}

	function close() {
		return $this->CI->mssql->close();
	}

	function connect($dbName) {
		return $this->CI->mssql->connect($dbName);
	}
}