<?php
require_once 'PHPUnit2/Framework/TestCase.php';

if (!function_exists('using')) {
	// Setup include path
	set_include_path(get_include_path() . 
	PATH_SEPARATOR . dirname(__FILE__) . '/../lib/' . 
	PATH_SEPARATOR . dirname(__FILE__) . '/../' .
	PATH_SEPARATOR . dirname(__FILE__));
	
	// Just for prado compatibility
	function using() {}
}

/*
 * Created on 22.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
abstract class BaseTestCase extends PHPUnit2_Framework_TestCase {

	static $dataDir;	
}

BaseTestCase::$dataDir = dirname(__FILE__) . '/data/';
?>
