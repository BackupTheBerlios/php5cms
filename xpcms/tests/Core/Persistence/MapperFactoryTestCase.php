<?php
require_once 'Core/Persistence/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Persistence/IAssetMapper.php';

/*
 * Created on 23.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class MapperFactoryTestCase extends BasePersistenceTestCase {

	/*
	 * Checks that we can create an instance of IWebCollectionMapper
	 */
	public function testCreateWebCollectionMapper() {

		$mapper = $this->factory->createWebCollectionMapper();
		$this->assertNotNull($mapper);
		$this->assertTrue(
			($mapper instanceof IWebCollectionMapper),
			"Expected IWebCollectionMapper but  recieved " . get_class($mapper));
	}

	/*
	 * Creates an instance of IWebPageMapper
	 */
	public function testCreateWebPageMapper() {

		$mapper = $this->factory->createWebPageMapper();

		$this->assertNotNull($mapper);
		$this->assertTrue($mapper instanceof IWebPageMapper);
	}
    
    /*
     * Creates an instance of IAssetMapper
     */
    public function testCreateAnInstanceOfAssetMapper() {
        $mapper = $this->factory->createAssetMapper();
        
        $this->assertNotNull($mapper);
        $this->assertTrue($mapper instanceof IAssetMapper);
    }
}
?>
