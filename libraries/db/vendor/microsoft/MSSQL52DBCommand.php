<?php

class MSSQL52DBCommand implements IDBCommand
{
	var $sp;
	var $cmd;
	var $params;
	var $DBObj;
	var $anotherWay;
	var $i;

	function __construct($DBObj) {
		$this->DBObj = $DBObj;
		$this->anotherWay = '';
		$this->params = array();
	}

	function procedure($sp) {
		$this->params = array();
		$this->sp = $sp;
		$this->DBObj->stmt = mssql_init($this->sp);
	}

	function prepare($params) {
		$len = count($params);
		$i = 0;
		$this->anotherWay = '';
		$this->params = $params;
		foreach($this->params as $param) {

			//printf("\n param: %s",print_r($param, true));

			mssql_bind($this->DBObj->stmt, '@'.$param->name, $param->val, $param->type, $param->outputFlag, $param->isNull, $param->maxLength);


			if($i == 0) {
				$this->anotherWay = sprintf("@%s=%s", $param->name, $this->fixParamType($param->type, $param->val));
				if($len > 1) {
					$this->anotherWay .= ',';
				}
			}
			else if($len != $i) {
				$this->anotherWay .= sprintf("@%s=%s", $param->name, $this->fixParamType($param->type, $param->val));

				if($i+1 != $len) {
					$this->anotherWay .= ',';
				}
			}
			else {
				$this->anotherWay .= sprintf("@%s=%s", $param->name, $this->fixParamType($param->type, $param->val));
			}

			$i++;
		}
	}

	function fixParamType($type, $param) {
		switch($type) {
			case 'SQLINT1':
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
//		mssql_execute($this->DBObj->stmt);
		//printf("<br>mssql_query: %s %s<br>", $this->sp, $this->anotherWay);
		$s = sprintf("%s %s", $this->sp, $this->anotherWay);
		$this->DBObj->stmt = mssql_query($s, $this->DBObj->dbConn) || die ("Can't take it anymore!");
		$this->sp = '';
		$this->anotherWay = '';
	}
}