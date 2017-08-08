<?php
interface IDBCommand
{
	function __construct($DBConn);
	function procedure($sp);
	function prepare($params);
	function execute();
}