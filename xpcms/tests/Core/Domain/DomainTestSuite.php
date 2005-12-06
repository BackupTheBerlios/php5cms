<?php
require_once 'BaseTestSuite.php';

/*
 * Created on 04.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class DomainTestSuite extends BaseTestSuite {

	public function __construct() {
		$this->loadTestCases(dirname(__FILE__));
	}
}
?>
