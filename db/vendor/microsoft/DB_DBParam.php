<?php
class DBParam
{
	var $name;
	var $val;
	var $type;
	var $outputFlag;
	var $isNull;
	var $maxLength;

/*
 *
Use:
SQLVARCHAR for binary
SQLINT4 for datetime
SQLFLT8 for decimal
SQLVARCHAR for image
SQLFLT8 for money
SQLCHAR for nchar
SQLTEXT for ntext
SQLFLT8 for numeric
SQLVARCHAR for nvarchar
SQLFLT8 for real
SQLINT4 for smalldatetime
SQLFLT8 for smallmoney
SQLVARCHAR for sql_variant
SQLINT4 for timestamp
SQLVARCHAR for varbinary
 *
 */

	function __construct($name,$val,$type,$outputFlag,$isNull,$maxLength) {
		$this->name = $name;
		$this->val = $val;
		$this->type = $type;
		$this->outputFlag = $outputFlag;
		$this->maxLength = $maxLength;

	//	printf("<br/> strlen(val): %s", strlen($this->val));

		if(strlen($this->val)== 0) {
			$this->isNull = 1;
		}
		else {
			$this->isNull = 0;
		}
	}
}

