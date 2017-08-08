<?php

class SQLSVR53DBCommand implements IDBCommand
{
	var $sp;
	var $params;
	var $internalParams;

	function __construct($DBObj) {
		$this->DBObj = $DBObj;
		$this->internalParams = array();
	}

	function procedure($sp) {
		$this->sp = $sp;
	}

	function prepare($params) {
		$this->params = $params;
		$inner = '';
		// "{call getSubscriberInformation(?,?)}"

		//print sprintf("\n<pre>params: %s", print_r($this->params,true));

		foreach($this->params as $param) {

			if(strlen($inner) != 0)
				$inner .= ",";

			$inner .= "?";

			if($param->outputFlag == true)
				$this->internalParams[] =  array($this->fixParamType($param->type, $param->val), SQLSRV_PARAM_OUT);
			else
				$this->internalParams[] =  array($this->fixParamType($param->type, $param->val), SQLSRV_PARAM_IN);
		}
		$this->sp = sprintf("{call %s (%s) }", $this->sp, $inner);
	}

	function fixParamType($type, $param) {

		return $param;

		switch($type) {
			case 'SQLINT1':
			 return $param;
			 break;

			case 'SQLFLT8':
			 return $param;
			 break;

			case 'SQLVARCHAR':
			 return sprintf("'%s'", $param);
			 break;

			default:
			 return $param;
		}
	}

	function execute() {
	//	print sprintf("\nexecute: %s", $this->sp);
	//	print sprintf("\ndbConn: %s", $this->DBObj->dbConn);
	//	print sprintf("\n<pre>internalParams: %s", print_r($this->internalParams,true));
		return sqlsrv_query($this->DBObj->dbConn, $this->sp, $this->internalParams);
	}
}