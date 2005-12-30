<?php

require_once 'creole/Creole.php';

/**
 * @package XpCms.Core.Persistence.Creole
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class CreoleMapperFactory extends AbstractMapperFactory {
	
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
	 * An instance of <code>WebPageMapper</code>. By default it is not 
	 * instanciated, but after a call of <code>createWebPageMapper()</code> it
	 * holds an unique instance for later reuse.
	 * 
	 * @var WebPageMapper $webPageMapper
	 */
	private $webPageMapper = null;
	
	/**
	 * An instance of <code>StructureGroupMapper</code>. By default it is not 
	 * instanciated, but after a call of 
	 * <code>createStructureGroupMapper()</code> it holds an unique instance for
	 * later reuse.
	 * 
	 * @var StructureGroupMapper $structureGroupMapper
	 */
	private $structureGroupMapper = null;
    
    /**
     * An instance of <code>AssetMapper</code>. By default this property is 
     * <code>null</code> but after calling <code>createAssetMapper</code> this
     * property holds the instance for later reuse.
     * 
     * @var AssetMapper $assetMapper
     */
    private $assetMapper = null;
	
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
							IConfigurable::STATUS, IConfigurable::LANGUAGE));
		}
		return $this->webCollectionMapper;
	}
	
	/**
	 * Creates an unique instance of <code>WebPageMapper</code>. This method 
	 * implements the GoF Singleton pattern and the lazy load pattern.
	 * 
	 * @return WebPageMapper The WebPageMapper instance.
	 */
	public function createWebPageMapper() {
		// Do we have an older instance?
		if ($this->webPageMapper === null) {
			// Include the class file.
			include_once dirname(__FILE__) . '/WebPageMapper.php';
			
			$this->webPageMapper = new WebPageMapper($this->conn);
			
			// set some common properties
			$this->initMapperProperties(
					$this->webPageMapper, array(
							IConfigurable::STATUS, IConfigurable::LANGUAGE));
		}
		return $this->webPageMapper;
	}
	
	/**
	 * Creates an instance of <code>IStructureGroupMapper</code>. This mapper is
	 * used to retrieve <code>StructureGroup</code>-objects from the underlying
	 * storage.
	 * 
	 * @return IStructureGroup The <code>IStructureGroupMapper</code>-instance.
	 */
	public function createStructureGroupMapper() {
		// Does an instance exist that we can reuse?
		if ($this->structureGroupMapper === null) {
			// Include the concrete php file
			include_once dirname(__FILE__) . '/StructureGroupMapper.php';
			// Create an instance
			$this->structureGroupMapper = new StructureGroupMapper($this->conn);
			// set some common properties
			$this->initMapperProperties(
					$this->structureGroupMapper, array(
							IConfigurable::STATUS, IConfigurable::LANGUAGE));
		}
		return $this->structureGroupMapper;
	}
    
    /**
     * Creates an instance of <code>IAssetMapper</code>. This mapper is
     * used to retrieve <code>AbstractAsset</code>-objects from the underlying
     * storage.
     * 
     * @return IAssetMapper The <code>IAssetMapper</code>-instance.
     * 
     */
    public function createAssetMapper() {
        // Does an instance allready exist?
        if ($this->assetMapper === null) {
            include_once dirname(__FILE__) . '/AssetMapper.php';
            // Create an instance
            $this->assetMapper = new AssetMapper($this->conn);
            // Set some common properties
            $this->initMapperProperties(
                    $this->assetMapper, array(
                            IConfigurable::STATUS, IConfigurable::LANGUAGE));
        }
        return $this->assetMapper;
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
