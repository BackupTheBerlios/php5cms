<?php
require_once 'BaseTestCase.php';

require_once 'XpCms/Core/Domain/IGroupable.php';
require_once 'XpCms/Core/Domain/DynamicPropertyObject.php';
require_once 'XpCms/Core/Domain/WebCollection.php';

/*
 * Created on 04.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class WebCollectionTestCase extends BaseTestCase {

	/*
	 * Tries to set a readonly property more than once.
	 */
	public function testSetReadonlyPropertyTwiceFails() {

		$webCollection = new WebCollection();

		$this->assertNull($webCollection->getId());

		$webCollection->setId(1);

		$this->assertEquals(1, $webCollection->getId());

		// This call does nothing because id is readonly
		$webCollection->setId(2);

		$this->assertEquals(1, $webCollection->getId());
	}

}
?>
