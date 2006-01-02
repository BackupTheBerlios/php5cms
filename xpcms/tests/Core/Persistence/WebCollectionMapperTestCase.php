<?php
require_once 'Core/Persistence/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Service/LazyLoadService.php';

require_once 'XpCms/Core/Domain/IGroupable.php';
require_once 'XpCms/Core/Domain/StructureGroup.php';
require_once 'XpCms/Core/Domain/WebCollection.php';
require_once 'XpCms/Core/Domain/WebPage.php';

require_once 'XpCms/Core/Persistence/IConfigurable.php';
require_once 'XpCms/Core/Persistence/IStructureGroupMapper.php';
require_once 'XpCms/Core/Persistence/IWebCollectionMapper.php';
require_once 'XpCms/Core/Persistence/Creole/AbstractBaseMapper.php';
/*
 * Created on 24.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class WebCollectionMapperTestCase extends BasePersistenceTestCase {

	/*
	 * Tries to get a single IWebCollection by its id.
	 */
	public function testFindByIdSuccess() {

		$mapper = $this->factory->createWebCollectionMapper();
		$collection = $mapper->findById(1, 'de_DE');

		$this->assertNotNull($collection);
		$this->assertEquals('WebCollection', get_class($collection));
	}

	/*
	 * Tries to find a single WebCollection with invalid ids.
	 */
	public function testDoNotFindWithInvalidId() {

		$mapper = $this->factory->createWebCollectionMapper();

		$collection = $mapper->findById(-1, 'de_DE');
		$this->assertNull($collection);

		$collection = $mapper->findById('foo', 'de_DE');
		$this->assertNull($collection);

		$collection = $mapper->findById('; DELETE FROM xpcms_web_collection WHERE 1', 'de_DE');
		$this->assertNull($collection);
	}

	/*
	 * Tries to find a collection by its id but with an invalid status
	 */
	public function testDoNotFindACollectionWithIdOneAndStatusZero() {

		$mapper = $this->factory->createWebCollectionMapper();
		$result = $mapper->findById(1, 'de_DE', 0);

		$this->assertNull($result);
	}

	/*
	 * Tries to find a web page with status 1
	 */
	public function testFindCollectionWithIdFiveAndStatusOne() {

		$mapper = $this->factory->createWebCollectionMapper();
        
		$result = $mapper->findById(5, 'de_DE', 1);

		$this->assertNotNull($result);
		$this->assertEquals('WebCollection', get_class($result));
	}

	/*
	 * Tries to find a WebCollection that contains a german web page.
	 */
	public function testFindCollectionWithGermanWebPage() {

		$mapper = $this->factory->createWebCollectionMapper();

		$collection = $mapper->findById(1, 'de_DE');

		$this->assertNotNull($collection);

		$webPage = $collection->getWebPage();

		$this->assertNotNull($webPage);
		$this->assertTrue($webPage instanceof WebPage);
	}

	/*
	 * Tries to find an set of WebCollections by their structure group.
	 */
	public function testFindCollectionsByStructureGroup() {
		$mapper = $this->factory->createWebCollectionMapper();

		$collections = $mapper->findByGroupId(2, 'de_DE');

		$this->assertNotNull($collections);
		$this->assertTrue($collections instanceof ArrayObject);
        /*
		print "\n\n";
		foreach ($collections as $coll) {
			print $coll->getWebPage()->getName()."\n";
			foreach ($coll->getWebCollections() as $c1) {
				print "  ".$c1->getWebPage()->getName()."\n";
				foreach ($c1->getWebCollections() as $c2) {
					print "    ".$c2->getWebPage()->getName()."\n";
				}
			}
		}
		print "\n\n";
        */
		$this->assertEquals(5, $collections->count());
	}

	/*
	 * Saves an allready existing WebCollection.
	 */
	public function testSaveANewRootCollectionAtTheEndOfTheLevel() {
		$mapper = $this->factory->createWebCollectionMapper();

		$collection = $mapper->findById(2, 'de_DE');
		$this->assertNotNull($collection);
		$structGroup = $collection->getStructureGroup();

		$this->assertNotNull($structGroup);

		$webPage = new WebPage();
		$webPage->setName("Foo");
		$webPage->setDescription("BAR");
		$webPage->setStatus(1);
		$webPage->setLanguage('de_DE');

		$newColl = new WebCollection();
		$newColl->setStatus(1);
		$newColl->setWebPage($webPage);
		$newColl->setStructureGroup($structGroup);

		$this->assertSame($structGroup, $newColl->getStructureGroup());
		$this->assertNull($newColl->getId());
		$this->assertNotNull($newColl->getWebPage());

		$mapper->save($newColl);

		$this->assertNotNull($newColl->getId());

		$mapper->delete($newColl);

	}

	/*
	 * Saves a new collection in Unternehmen, after Jobs
	 */
	public function testSaveANewChildCollectionAtTheEndOfTheLevel() {
        
        $mapper = $this->factory->createWebCollectionMapper();

		$collection = $mapper->findById(3, 'de_DE');
        
		$structGroup = $collection->getStructureGroup();

		$this->assertNotNull($structGroup);

		$webPage = new WebPage();
		$webPage->setName("Foo");
		$webPage->setDescription("BAR");
		$webPage->setStatus(1);
		$webPage->setLanguage('de_DE');

		$count = $collection->getWebCollections()->count();

		$newColl = new WebCollection();
		$newColl->setStatus(1);
		$newColl->setWebPage($webPage);
		$newColl->setStructureGroup($structGroup);
		$collection->addWebCollection($newColl);

		$this->assertSame($structGroup, $newColl->getStructureGroup());
		$this->assertNull($newColl->getId());
		$this->assertNotNull($newColl->getWebPage());

		$mapper->save($newColl);

		$this->assertNotNull($newColl->getId());

		$this->assertEquals($count +1, $collection->getWebCollections()->count());

		$mapper->delete($newColl);

		$this->assertEquals($count, $collection->getWebCollections()->count());
	}
    
    /*
     * This method tries to find a WebCollection group by its alias name with
     * success.
     */
    public function testFindAWebCollectionGroupByItsAliasName() {
        
        $mapper = $this->factory->createWebCollectionMapper();

        $collections = $mapper->findByGroupAlias('backend', 'de_DE');
        $this->assertNotNull($collections);
        $this->assertTrue($collections->count() > 0);
        
        $this->assertNotNull($structureGroup = $collections->offsetGet(0)->getStructureGroup());
        $this->assertEquals('backend', $structureGroup->getAlias());
    }
    
    /*
     * Tries to find a not existing collection group. the expected return value
     * is null.
     */
    public function testDoNotFindAWebCollectionByANotExistingAlias() {
        $mapper = $this->factory->createWebCollectionMapper();

        $collections = $mapper->findByGroupAlias('not_existing_group', 'de_DE');
        
        $this->assertNull($collections);        
    }
    
    /*
     * This method tries to find the WebCollection for the alias path
     * /project/nexd/umdoc and /project/nexd/umdoc/diagrams
     */
    public function testFindAWebCollectionByItsAliasPath() {
        
        $mapper = $this->factory->createWebCollectionMapper();
        
        
        $aliasPath  = array('project', 'nexd', 'umldoc');
        $collection = $mapper->findByAliasPath($aliasPath, 'de_DE');
        $this->assertNotNull($collection);
        $this->assertEquals('umldoc', $collection->getAlias());
        
        
        $aliasPath  = array('project', 'nexd', 'umldoc', 'diagrams');
        $collection = $mapper->findByAliasPath($aliasPath, 'de_DE');
        $this->assertNotNull($collection);
        $this->assertEquals('diagrams', $collection->getAlias());
    }
    
    /*
     * Tries to produce an exception with invalid arguments
     */
    public function testGetExceptionFromCallFindWebCollectionWithNullOrEmptyArray() {
        
        $mapper = $this->factory->createWebCollectionMapper();
        try {
            $mapper->findByAliasPath(null, 'de_DE');
            $this->fail('Expected an InvalidArgumentException');
        } catch (InvalidArgumentException $e) {}
        
        try {
            $mapper->findByAliasPath(array(), 'de_DE');
            $this->fail('Expected an InvalidArgumentException');
        } catch (InvalidArgumentException $e) {}
        
    }
}
?>

