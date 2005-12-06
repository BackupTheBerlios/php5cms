<?php
require_once 'Core/Persistence/BasePersistenceTestCase.php';

/*
 * Created on 05.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class WebPageMapperTestCase extends BasePersistenceTestCase {
	
	/*
	 * Tries to retrieve a web page from a collection
	 */
	public function testGetCollectionWebPageThruMapper() {
		
		$this->factory->setProperty(WebPageMapper::LANGUAGE_FIELD, 'de_DE');
		
		$mapper1 = $this->factory->createWebCollectionMapper();
		
		// Get Collection with no web page
		$collection = $mapper1->findById(1, false);
		
		$this->assertNotNull($collection);
		
		$webPage = $collection->getWebPage();
		
		$this->assertNotNull($webPage);
		$this->assertTrue($webPage instanceof WebPage);
		$this->assertEquals($collection->getId(), $webPage->getCollectionId());
		
		$this->assertSame($collection, $webPage->getCollection());
	}
	
	/*
	 * Finds a web page by the collection foreign id. 
	 */
	public function testFindWebPageByItsCollectionForeignId() {
		
		$mapper1 = $this->factory->createWebPageMapper();
		
		$webPage = $mapper1->findByCollectionId(5);
		
		$this->assertNotNull($webPage);
		
		$collection = $webPage->getCollection();
		
		$this->assertNotNull($collection);
		$this->assertEquals($collection, $this->factory->createWebCollectionMapper()->findById(5));
	}
}
?>
