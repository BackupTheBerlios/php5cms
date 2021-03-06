<?php
require_once 'PHPUnit2/Framework/TestSuite.php';
require_once 'PHPUnit2/Framework/Warning.php';

require_once 'Core/Domain/DomainTestSuite.php';
require_once 'Core/Persistence/PersistenceTestSuite.php';
require_once 'Core/Service/ServiceTestSuite.php';

/*
 * Created on 04.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AllTestSuites extends PHPUnit2_Framework_TestSuite {
    function __construct() {
        $this->addTest(new DomainTestSuite());
        $this->addTest(new PersistenceTestSuite());
        $this->addTest(new ServiceTestSuite());
    }
}
?>
