<?php
require_once dirname(__FILE__) . '/BasePersistenceTestCase.php';

/*
 * Created on 23.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class MapperFactoryTestCase extends BasePersistenceTestCase {
	
	/**
	 * Checks that we can create an instance of IWebCollectionMapper
	 */
	public function testCreateWebCollectionMapper() {
		
		$mapper = $this->factory->createWebCollectionMapper();
		$this->assertNotNull($mapper);
		$this->assertTrue(
			($mapper instanceof IWebCollectionMapper),
			"Expected IWebCollectionMapper but  recieved " . get_class($mapper));
	}
}
?>
