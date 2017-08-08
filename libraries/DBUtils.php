<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class DBUtils
{
	var $Debug;
	var $connectedFlag;
	var $databaseType;
	var $noArraySP;

	private $CI;

	function __construct() {
		$this->Debug = 2;
	}

	function escape_data($inp) { 
		if(is_array($inp)) 
			return array_map(__METHOD__, $inp); 
	
		if(!empty($inp) && is_string($inp)) { 
			return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
		} 
	
		return $inp; 
	} 
	
	function sanatize_data($d) {
		return $this->escape_data($d);
	}
	
	function sanatize_args() {
		$numargs = func_num_args();
		
		$arg_list = func_get_args();
		
		for ($i = 0; $i < $numargs; $i++) {
			$arg_list[$i] = $this->sanatize_data($arg_list[$i]);
		}			
		
		return $arg_list;
	}	
}