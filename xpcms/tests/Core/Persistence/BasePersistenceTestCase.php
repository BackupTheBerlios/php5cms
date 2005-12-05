<?php
require_once dirname(__FILE__) . '/../../BaseTestCase.php';

require_once 'XpCms/Core/Persistence/IConfigurable.php';

require_once 'XpCms/Core/Persistence/AbstractMapperFactory.php';
require_once 'XpCms/Core/Persistence/Sql/SqlMapperFactory.php';

/*
 * Created on 23.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
abstract class BasePersistenceTestCase extends BaseTestCase {
		
	protected $validType = 'Sql';
	protected $validDSN  = 'mysql://xpcms:xpcms@localhost/xpcms';
	
	protected $factory = null;
	
	public function setUp() {
		parent::setUp();
		
		// TODO: Import a clean database on each setup.
		
		$this->factory = AbstractMapperFactory::getInstance(
			$this->validType, $this->validDSN);	
	}
}
?>