<?php
/**
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.5 $
 */
abstract class AbstractMapperFactory implements IConfigurable {

	/**
	 * Initial type of mapper. Currently only sql mappers are available.
	 *
	 * @var string $initType
	 */
	private static $initType = null;

	/**
	 * GoF Singleton instances of <code>AbstractMapperFactory</code>.
	 *
	 * @var array $instances
	 */
	private static $instances = array();

	/**
	 * GoF Singleton method that returns unique instances of factories.
	 *
	 * @param string $type The concrete factory type.
	 * @param array The initital parameters.
	 * @return AbstractMapperFactory A unique instance of AbstractMapperFactory.
	 *
	 * @throws Exception If the requested type doesn't exist or you try to get
	 *                   an instance when no type is defined.
	 */
	public static function getInstance($type = null, $params = null) {

		if (is_null($type)) {
			if (is_null(self::$initType)) {
				throw new Exception(
					"An initial type for the data mapper is necessary.");
			}
			$type = self::$initType;
		}

		if (!isset(self::$instances[$type])) {

			$package = sprintf('XpCms.Core.Persistence.%s', $type);
			$class   = sprintf('%sMapperFactory', $type);

			// Include correct persistance package
			using($package);

			// Is the correct mapper class available???
			if (!class_exists($class)) {
				throw new Exception(sprintf(
					"Cannot find mapper factory class [%s]", $class));
			}

			self::$instances[$type] = new $class($params);

			if (is_null(self::$initType)) {
				self::$initType = $type;
			}
		}

		return self::$instances[$type];
	}

	/**
	 * The configurable properties.
	 *
	 * @var ArrayObject $properties
	 */
	protected $properties;

	/**
	 * Simple constructor.
	 */
	protected function __construct() {

		// Initialize the properties attribute
		$this->properties = new ArrayObject();
	}

	/**
	 * Returns a property value.
	 *
	 * @see IConfigurable::getProperty()
	 */
	public function getProperty($name) {
		$value = null;
		if ($this->properties->offsetExists($name)) {
			$value = $this->properties->offsetGet($name);
		}
		return $value;
	}

	/**
	 * Sets a property value.
	 *
	 * @see IConfigurable::setProperty()
	 */
	public function setProperty($name, $value) {
		$this->properties->offsetSet($name, $value);
	}

	/**
	 * Creates an instance of <code>IWebCollectionMapper</code>. This mapper is
	 * used to retrieve single <code>WebCollection</code>s or the complete
	 * object structure.
	 *
	 * @return IWebCollectionMapper The collection mapper instance
	 */
	public abstract function createWebCollectionMapper();

	/**
	 * Creates an instance of <code>IWebPageMapper</code>. This mapper is used
	 * to retries <code>WebPage</code>s from the database
	 *
	 * @return IWebPageMapper The web page mapper instance.
	 */
	public abstract function createWebPageMapper();
	
	/**
	 * Creates an instance of <code>IStructureGroupMapper</code>. This mapper is
	 * used to retrieve <code>StructureGroup</code>-objects from the underlying
	 * storage.
	 * 
	 * @return IStructureGroupMapper The <code>IStructureGroupMapper</code>
     *                               instance.
	 */
	public abstract function createStructureGroupMapper();
    
    /**
     * Creates an instance of <code>IAssetMapper</code>. This mapper is
     * used to retrieve <code>AbstractAsset</code>-objects from the underlying
     * storage.
     * 
     * @return IAssetMapper The <code>IAssetMapper</code>-instance.
     * 
     */
    public abstract function createAssetMapper();
}
?>
