<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * BannerFacade.php - Main Application
 *
 */

interface Command
{
	function execute();
	function build();
}
?>