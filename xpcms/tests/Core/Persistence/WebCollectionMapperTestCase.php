<?php
require_once 'Core/Persistence/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Domain/IGroupable.php';
require_once 'XpCms/Core/Domain/StructureGroup.php';
require_once 'XpCms/Core/Domain/WebCollection.php';
require_once 'XpCms/Core/Domain/WebPage.php';

require_once 'XpCms/Core/Persistence/IConfigurable.php';
require_once 'XpCms/Core/Persistence/IStructureGroupMapper.php';
require_once 'XpCms/Core/Persistence/IWebCollectionMapper.php';
require_once 'XpCms/Core/Persistence/Sql/AbstractBaseMapper.php';
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
		$collection = $mapper->findById(1);

		$this->assertNotNull($collection);
		$this->assertEquals('WebCollection', get_class($collection));
	}

	/*
	 * Tries to find a single WebCollection with invalid ids.
	 */
	public function testDoNotFindWithInvalidId() {

		$mapper = $this->factory->createWebCollectionMapper();

		$collection = $mapper->findById(-1);
		$this->assertNull($collection);

		$collection = $mapper->findById('foo');
		$this->assertNull($collection);

		$collection = $mapper->findById('; DELETE FROM xpcms_web_collection WHERE 1');
		$this->assertNull($collection);
	}

	/*
	 * Tries to find a collection by its id but with an invalid status
	 */
	public function testDoNotFindACollectionWithIdOneAndStatusZero() {

		$mapper = $this->factory->createWebCollectionMapper();

		// get current status
		$status = $mapper->getProperty(WebCollectionMapper::STATUS_FIELD);

		$mapper->setProperty(WebCollectionMapper::STATUS_FIELD, 0);

		$result = $mapper->findById(1);

		// restore status
		$mapper->setProperty(WebCollectionMapper::STATUS_FIELD, $status);

		$this->assertNull($result);
	}

	/*
	 * Tries to find a web page with status 1
	 */
	public function testFindCollectionWithIdFiveAndStatusOne() {

		$mapper = $this->factory->createWebCollectionMapper();

		// get current status
		$status = $mapper->getProperty(WebCollectionMapper::STATUS_FIELD);

		$mapper->setProperty(WebCollectionMapper::STATUS_FIELD, 1);

		$result = $mapper->findById(5);

		// restore status
		$mapper->setProperty(WebCollectionMapper::STATUS_FIELD, $status);

		$this->assertNotNull($result);
		$this->assertEquals('WebCollection', get_class($result));
	}

	/*
	 * Tries to find a WebCollection that contains a german web page.
	 */
	public function testFindCollectionWithGermanWebPage() {

		$mapper = $this->factory->createWebCollectionMapper();
		$mapper->setProperty(WebCollectionMapper::LANGUAGE_FIELD, 'de_DE');

		$collection = $mapper->findById(1);

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
        $mapper->setProperty(WebCollectionMapper::LANGUAGE_FIELD, 'de_DE');

        // Create the group instance.
        $group = new StructureGroup();
        $group->setId(2);

        $collections = $mapper->findByGroup($group);

        $this->assertNotNull($collections);
        $this->assertTrue($collections instanceof ArrayObject);
        print "\n\n";
        foreach ($collections as $coll) {
            print $coll->getWebPage()->getName() . "\n";
            foreach ($coll->getWebCollections() as $c1) {
                print "  " . $c1->getWebPage()->getName() . "\n";
                foreach ($c1->getWebCollections() as $c2) {
                    print "    " . $c2->getWebPage()->getName() . "\n";
                }
            }
        }
        print "\n\n";

        $this->assertEquals(5, $collections->count());
    }

    /*
     * Saves an allready existing WebCollection.
     */
    public function testSaveANewRootCollectionAtTheEndOfTheLevel() {
    		$mapper = $this->factory->createWebCollectionMapper();
    		$mapper->setProperty(WebCollectionMapper::LANGUAGE_FIELD, 'de_DE');

    		$collection  = $mapper->findById(2);
            $this->assertNotNull($collection);
    		$structGroup = $collection->getStructureGroup();

    		$this->assertNotNull($structGroup);

            $webPage = new WebPage();
            $webPage->setName("Foo");
            $webPage->setDescription("BAR");
            $webPage->setStatus(1);
            $webPage->setLanguage('de_DE');

    		$newColl = new WebCollection();
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
            $mapper->setProperty(WebCollectionMapper::LANGUAGE_FIELD, 'de_DE');

            $collection  = $mapper->findById(3);
            $structGroup = $collection->getStructureGroup();

            $this->assertNotNull($structGroup);

            $webPage = new WebPage();
            $webPage->setName("Foo");
            $webPage->setDescription("BAR");
            $webPage->setStatus(1);
            $webPage->setLanguage('de_DE');

            $count = $collection->getWebCollections()->count();

            $newColl = new WebCollection();
            $newColl->setWebPage($webPage);
            $newColl->setStructureGroup($structGroup);
            $collection->addWebCollection($newColl);

            $this->assertSame($structGroup, $newColl->getStructureGroup());
            $this->assertNull($newColl->getId());
            $this->assertNotNull($newColl->getWebPage());

            $mapper->save($newColl);

            $this->assertNotNull($newColl->getId());

            $this->assertEquals($count + 1, $collection->getWebCollections()->count());

            $mapper->delete($newColl);

            $this->assertEquals($count, $collection->getWebCollections()->count());
    }
}
?>
