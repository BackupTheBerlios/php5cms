<?php
/**
 * This service is used by the domain objects to load other objects on demand.
 * 
 * @package XpCms.Core.Service
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $ 
 */
class LazyLoadService {
    
    /**
     * GoF Singleton instance of this class.
     * 
     * @var LazyLoadService $instance
     */
    private static $instance;
    
    /**
     * GoF Singleton method that creates an unique instance of 
     * <code>LazyLoadService</code>.
     * 
     * @return LazyLoadService The unique instance of this class.
     * @see LazyLoadService::$instance.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new LazyLoadService();
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
     * This is the default locale setting. If no <code>$locale</code> parameter
     * is passed to a method the value of this property will be used.
     * 
     * @var string $locale
     */
    private $locale = null;
    
    protected function __construct() {
        // Get a unique instance of config
        $this->config = XpCmsConfig::getInstance();
        
        // Get the configuration params for the content mappers
        $cfg = $this->config->getPersistenceParams('content');
        // Create an instance depending on the configuration settings.
        $this->contentFactory = AbstractMapperFactory::getInstance(
                $cfg['type'], $cfg['dsn']);
        // TODO : Static language setting de_DE must be replaced by request based setting     
        $this->contentFactory->setProperty(
                IConfigurable::LANGUAGE, 'de_DE');
                
        $this->locale = 'de_DE';
    }
    
    public function getPageByCollection(WebCollection $collection, $locale = null) {
        if ($locale === null) {
            $locale = $this->locale;
        }
        
        $wpm = $this->contentFactory->createWebPageMapper();
        return $wpm->findByCollectionId($collection->getId(), $locale);
    }
    
    public function getCollectionByPage(WebPage $webPage, $locale = null) {
        if ($locale === null) {
            $locale = $this->locale;
        }
        
        $wcm = $this->contentFactory->createWebCollectionMapper();
        return $wcm->findById($webPage->CollectionId, $locale);        
    }
    
    public function getStructureGroupByCollection(WebCollection $collection, $locale = null) {
        if ($locale === null) {
            $locale = $this->locale;
        }
        $sgm = $this->contentFactory->createStructureGroupMapper();
        return $sgm->findById($collection->GroupId, $locale);
    }
    
}
?>
