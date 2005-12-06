<?php
require_once 'BaseTestSuite.php';
require_once 'Core/Persistence/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Domain/DynamicPropertyObject.php';

/*
 * Created on 22.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class PersistenceTestSuite extends BaseTestSuite {

	public function __construct() {
		$this->loadTestCases(dirname(__FILE__));
	}

}
?>
