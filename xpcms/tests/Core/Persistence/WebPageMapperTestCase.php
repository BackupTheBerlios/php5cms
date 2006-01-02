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

		$mapper1 = $this->factory->createWebCollectionMapper();

		// Get Collection with no web page
		$collection = $mapper1->findById(1, 'de_DE', 1, false);

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

		$webPage = $mapper1->findByCollectionId(5, 'de_DE');

		$this->assertNotNull($webPage);

		$collection = $webPage->getCollection();

		$this->assertNotNull($collection);
		$this->assertEquals($collection, $this->factory->createWebCollectionMapper()->findById(5, 'de_DE'));
	}
	
	/*
	 * This test tries to add a 'en_GB' web page to an existing collection. 
	 */
	public function testInsertANewCleanWebPageToAnExistingCollection() {
		
		$wpm     = $this->factory->createWebPageMapper();
		$wpm->setProperty(IConfigurable::LANGUAGE, 'de_DE');
		$company = $wpm->findById(3);
		
		$engCompany = new WebPage();
		$engCompany->setName('Company');
		$engCompany->setDescription('About the company');
		$engCompany->setStatus(1);
		$engCompany->setLanguage('en_GB');
		$engCompany->setCollection($company->getCollection());
		
		$this->assertNull($engCompany->getId());
		
		$wpm->save($engCompany);
		
		$this->assertNotNull($engCompany->getId());
		
		$queryPage = $wpm->findByCollectionId($engCompany->getCollection()->getId(), 'en_GB');
		$this->assertEquals($engCompany->getId(), $queryPage->getId());
		$wpm->setProperty(IConfigurable::LANGUAGE, 'de_DE');
		
		$wpm->delete($engCompany);
	}
	
	/*
	 * This method changes an existing web page
	 */
	public function testUpdateAnExistingWebPage() {
		$wpm     = $this->factory->createWebPageMapper();
		$wpm->setProperty(IConfigurable::LANGUAGE, 'de_DE');
		$company = $wpm->findById(3);
		
		$orgDesc = $company->getDescription();
		
		$company->setDescription('Eine kleine Geschichte');
		
		$wpm->save($company);
		
		$company2 = $wpm->findById(3);
		
		$this->assertEquals('Eine kleine Geschichte', $company2->getDescription());
		
		$company2->setDescription($orgDesc);
		
		$wpm->save($company2);
		
		$company3 = $wpm->findById(3);
		
		$this->assertEquals($orgDesc, $company3->getDescription());
		
		$this->assertEquals($company->getId(), $company2->getId());
		$this->assertEquals($company2->getId(), $company3->getId());
	}
	
	/*
	 * This test tries to delete the last web page of a collection, this test
	 * must fail.
	 */
	public function testDeleteLastWebPageOfACollectionFails() {
		
		$wpm = $this->factory->createWebPageMapper();
		$wpm->setProperty(IConfigurable::LANGUAGE, 'de_DE');
		
		$webPage = $wpm->findById(3);
		try {
			$wpm->delete($webPage);
			$this->fail('You cannot delete the last web page.');
		} catch (Exception $e) {	}
	}
	
}
?>
