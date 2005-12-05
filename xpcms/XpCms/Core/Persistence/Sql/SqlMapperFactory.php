<?php

require_once 'creole/Creole.php';

/**
 * @package XpCms.Core.Persistence.Sql
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class SqlMapperFactory extends AbstractMapperFactory {
	
	/**
	 * This is an instance of <code>WebCollectionMapper</code>. By default this
	 * property contains <code>null</code> as value, but after a call of
	 * <code>createWebCollectionMapper()</code> it holds the instance for later 
	 * reuse.
	 * 
	 * @var WebCollectionMapper
	 */
	private $webCollectionMapper = null;
	
	/**
	 * The creole database collection
	 * 
	 * @var Connection
	 */
	private $conn = null;
	
	protected function __construct($dsn) {
		parent::__construct();
		
		$this->conn = Creole::getConnection($dsn);
	}
	
	/**
	 * This factory method creates an instance of <code>WebCollectionMapper</code>
	 * if it doesn't exist in the object property <code>$webCollectionMapper</code>.
	 * So this method implements the lazy load and the singleton pattern.
	 * 
	 * @return WebCollectionMapper The mapper instance.
	 */
	public function createWebCollectionMapper() {
		// Does an instance exist?
		if ($this->webCollectionMapper === null) {
			// Ok we have no instance, include and create it
			include_once dirname(__FILE__) . '/WebCollectionMapper.php';
			
			$this->webCollectionMapper = new WebCollectionMapper($this->conn);
			
			// Is any config param set?
			$this->initMapperProperties(
					$this->webCollectionMapper, array(
							WebCollectionMapper::STATUS_FIELD,
							WebCollectionMapper::LANGUAGE_FIELD));
		}
		return $this->webCollectionMapper;
	}
	
	/**
	 * Adds allowed property values to the given <code>$mapper</code> object.
	 * 
	 * @param AbstractBaseMapper $mapper Any instance of AbstractBaseMapper.
	 * @param array $names The names of the defined properties.
	 */
	protected function initMapperProperties($mapper, $names) {
		foreach ($names as $name) {
			if ($this->properties->offsetExists($name)) {
				$mapper->setProperty(
						$name, $this->properties->offsetGet($name));
			}	
		}	
	}
}
?>
