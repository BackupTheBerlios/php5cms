<?php
require_once dirname(__FILE__) . '/BasePersistenceTestCase.php';

require_once 'XpCms/Core/Persistence/AbstractMapperFactory.php';
require_once 'XpCms/Core/Persistence/Sql/SqlMapperFactory.php';

/*
 * Created on 22.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AbstractMapperFactoryTestCase extends BasePersistenceTestCase {
	
	/*
	 * 
	 */
	public function testGetInstance() {
		$this->assertEquals('SqlMapperFactory', get_class($this->factory));
		$this->assertEquals('AbstractMapperFactory', get_parent_class($this->factory));
	}
	
	/*
	 * Tries to set a property to to the factory an looks for it in the mapper
	 */
	public function testSetStatusToFactoryAndFindInMapper() {
		
		$this->factory->setProperty('status', 1);
		
		$mapper = $this->factory->createWebCollectionMapper();
		
		$this->assertNotNull($mapper->getProperty('status'));
		$this->assertEquals(1, $mapper->getProperty('status'));
	}
	
	/*
	 * 
	 */
	public function testGetInstanceFailsWithWrongType() {
		try {
			$mapper = AbstractMapperFactory::getInstance(
					"FooBarStorageType", $this->validDSN);
			$this->assertTrue(false, "An Exception was expected");
		} catch (Exception $e) {
			$this->assertTrue(true, "An Exception was expected");
		}	
	}
	
	/*
	 * 
	 */
	public function testGetInstanceFailsWithWrongDSN() {
		try {
			$mapper = AbstractMapperFactory::getInstance(
					$this->validType, "But://this:is@an/invalid/dsn");
			$this->assertTrue(false, "An Exception was expected");
		} catch (Exception $e) {
			$this->assertTrue(true, "An Exception was expected");
		}	
	}
	
	/*
	 * Sets a property value and tries to get it back. 
	 */
	public function testSetAPropertyValue() {
		$this->assertNull($this->factory->getProperty('foo'));
		
		$this->factory->setProperty('foo', 'bar');
		
		$this->assertNotNull($this->factory->getProperty('foo'));
		$this->assertEquals('bar', $this->factory->getProperty('foo'));
		
		// Reset
		$this->factory->setProperty('foo', null);
	}
		
}
?>