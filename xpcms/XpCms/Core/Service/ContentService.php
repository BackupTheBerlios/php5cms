<?php
/**
 * This service is an abstraction layer between the <code>TModule</code>-objects
 * in the view layer and the underlying mapper infrastructure.
 * 
 * @package XpCms.Core.Service
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
class ContentService {
	
    /**
     * GoF Singleton instance of this class.
     * 
     * @var ContentServer $instance
     */
	private static $instance = null;
	
    /**
     * GoF Singleton method that creates an unique instance of 
     * <code>ContentService</code>.
     * 
     * @return ContentServer The unique instance of this class.
     * @see ContentService::$instance.
     */
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new ContentService();
		}
		return self::$instance;
	}
    
    /**
     * The global application configuration that holds all instance specific
     * settings.
     * 
     * @var XpCmsConfig $config
     */
    private $config = null;
	
    /**
     * This property holds an instance of <code>AbstractMapperFactory</code> 
     * that is responsible for all io-operations that have to do with the 
     * XpCms content. The type of this object depends on the configuration
     * setting in the <code>application.spec</code>-file.
     * 
     * @var AbstractMapperFactory $contentFactory
     */
    private $contentFactory = null;
	
    /**
     * Simple constructor that takes no arguments. It creates an instance of 
     * <code>AbstractMapperFactory</code> for all content io-operations.
     */
	protected function __construct() {
        // Get a unique instance of config
        $this->config = XpCmsConfig::getInstance();
        
        // Get the configuration params for the content mappers
        $cfg = $this->config->getPersistenceParams('content');
        // Create an instance depending on the configuration settings.
        $this->contentFactory = AbstractMapperFactory::getInstance(
                $cfg['type'], $cfg['dsn']);
	}
	
    /**
     * This method returns an <code>ArrayAccess</code> instance that holds all
     * top level <code>WebCollection</code> that belong to the given alias.
     * 
     * @param string $alias The frontent alias name for this collection group
     */
	public function getWebCollectionsByAlias($alias) {
        // Retrieve the IWebCollectionMapper object
		$wcm = $this->contentFactory->createWebCollectionMapper();
        // Translate frontend name to backend name an find it 
        return $wcm->findByGroupAlias($this->config->getGroupAlias($alias));
	}
}
?>
