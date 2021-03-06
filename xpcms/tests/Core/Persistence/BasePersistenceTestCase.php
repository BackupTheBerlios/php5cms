<?php
require_once 'BaseTestCase.php';

require_once 'creole/Statement.php';

require_once 'XpCms/Core/Persistence/IConfigurable.php';
require_once 'XpCms/Core/Persistence/IWebPageMapper.php';

require_once 'XpCms/Core/Persistence/AbstractMapperFactory.php';
require_once 'XpCms/Core/Persistence/Creole/CreoleMapperFactory.php';


/*
 * Created on 23.11.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
abstract class BasePersistenceTestCase extends BaseTestCase {
    
    const DEFAULT_LOCALE = 'de_DE';

	protected $validType = 'Creole';
	protected $validDSN  = 'mysql://xpcms:xpcms@localhost/xpcms';

	protected $factory = null;

	public function setUp() {
		parent::setUp();

		$this->factory = AbstractMapperFactory::getInstance(
			$this->validType, $this->validDSN);
	}
}
?>
