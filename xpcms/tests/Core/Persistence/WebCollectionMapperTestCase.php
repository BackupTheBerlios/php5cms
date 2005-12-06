<?php
require_once 'Core/Persistence/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Domain/IGroupable.php';
require_once 'XpCms/Core/Domain/StructureGroup.php';
require_once 'XpCms/Core/Domain/WebCollection.php';
require_once 'XpCms/Core/Domain/WebPage.php';

require_once 'XpCms/Core/Persistence/IConfigurable.php';
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
    }
}
?>
