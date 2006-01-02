<?php
require_once 'PHPUnit2/Framework/TestSuite.php';
require_once 'PHPUnit2/Framework/Warning.php';

if (!function_exists('using')) {
	// Setup include path
	set_include_path(get_include_path() . 
	PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../lib/') . 
	PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../') .
	PATH_SEPARATOR . realpath(dirname(__FILE__)));
	
	// Just for prado compatibility
	#function using() {}
}

require_once 'prado/framework/prado.php';
pradoGetApplication('../XpCms/application.spec');

/*
 * Created on 04.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
abstract class BaseTestSuite extends PHPUnit2_Framework_TestSuite {
	 
	protected function loadTestCases($dir) {
		$files = glob($dir . '/*TestCase.php');
		foreach ($files as $file) {
			include_once $file;
			$class = substr(basename($file), 0, strpos(basename($file), '.'));
			
			if (strpos($class, 'Base') === 0) {
				continue;
			}
			
			$this->addTestSuite($class);
		}
	}
	
}
?>
