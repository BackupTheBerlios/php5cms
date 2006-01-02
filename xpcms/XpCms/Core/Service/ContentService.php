<?php
/**
 * This service is an abstraction layer between the <code>TModule</code>-objects
 * in the view layer and the underlying mapper infrastructure.
 * 
 * @package XpCms.Core.Service
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
class ContentService {
	
    /**
     * GoF Singleton instance of this class.
     * 
     * @var ContentService $instance
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
     * This is the default locale setting. If no <code>$locale</code> parameter
     * is passed to a method the value of this property will be used.
     * 
     * @var string $locale
     */
    private $locale = null;
	
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
        // TODO : Static language setting de_DE must be replaced by request based setting     
        $this->contentFactory->setProperty(
                IConfigurable::LANGUAGE, 'de_DE');
                
        $this->locale = 'de_DE';
	}
	
    /**
     * This method returns an <code>ArrayAccess</code> instance that holds all
     * top level <code>WebCollection</code> that belong to the given alias.
     * 
     * @param string $alias The frontent alias name for this collection group
     * @param string $locale The language that should be used for the request.
     */
	public function getWebCollectionsByAlias($alias, $locale = null) {
        if ($locale === null) {
            $locale = $this->locale;
        }
        // Retrieve the IWebCollectionMapper object
		$wcm = $this->contentFactory->createWebCollectionMapper();
        // Translate frontend name to backend name an find it 
        return $wcm->findByGroupAlias(
                            $this->config->getGroupAlias($alias), $locale);
	}
    
    /**
     * This method returns all sub <code>StructureGroup</code>s for the group
     * with the given <code>$alias</code>.
     * 
     * @param string $alias The alias name of a <code>StructureGroup</code> that
     *                      contains other <code>StructureGroup</code>s.
     * @param string $locale The language that should be used for the request.
     * @return ArrayAccess An <code>ArrayAccess</code>-object that holds all
     *                     sub <code>StructureGroup</code>-objects for the given
     *                     parent <code>$alias</code>.
     * @todo It may be better to implement a <code>IWebCollectionMapper</code>
     *       method that implements this task in a single sql query!? 
     */
    public function getWebCollectionGroupsByAlias($alias, $locale = null) {
        
        if ($locale === null) {
            $locale = $this->locale;
        }
        
        // Create an instance of IStructureGroupMapper
        $sgm = $this->contentFactory->createStructureGroupMapper();
        // Retrieve the IWebCollectionMapper object
        $wcm = $this->contentFactory->createWebCollectionMapper();
        
        $groups = $sgm->findSubGroupsByAlias(
                            $this->config->getGroupAlias($alias), $locale);
        // Load WebCollection-objects for each group
        foreach ($groups as $group) {
            $group->Groupables = $wcm->findByGroupId($group->Id, $locale);
        }
        
        return $groups;
    }
    
    /**
     * This method returns a single <code>WebCollection</code>-object for the
     * given <code>$aliasPath</code> or if no collection for the given path
     * exists it returns <code>null</code>.
     * 
     * @param string $aliasPath The alias path for a <code>WebCollection</code>
     *                          which looks like the folder info in a file-
     *                          explorer.
     * @param string $locale The language that should be used for the request.
     * @return mixed The <code>WebCollection</code>-instance or if it doesn't 
     *               exist <code>null</code>.
     * 
     * @throws InvalidArgumentException If the given <code>$aliasPath</code> is
     *                                  <code>null</code>.
     */
    public function getWebCollectionByAliasPath($aliasPath, $locale = null) {
        // Check for an invalid input value.
        if (is_null($aliasPath)) {
            throw new InvalidArgumentException('The aliasPath cannot be null.');
        }
        if ($locale === null) {
            $locale = $this->locale;
        }
        
        // Create an alias array form the string
        $aliasArray = explode('/', $aliasPath);
        // Trim all values
        $aliasArray = array_map('trim', $aliasArray);
        // Remove a trailing and empty slash entries
        $aliasArray = array_filter($aliasArray);
        
        // Create an instance of IWebCollectionMapper
        $wcm = $this->contentFactory->createWebCollectionMapper();
        // Query collection
        return $wcm->findByAliasPath($aliasArray, $locale); 
    }
    
    /**
     * This method returns all asset groups that belong to the given 
     * <code>WebPage</code>. It returns all <code>StructureGroup</code>s in an
     * <code>ArrayAccess</code>-object.
     * 
     * @param WebPage $webPage The context web page object.
     * @return ArrayAccess An array object with all <code>StructureGroup</code>
     *                     objects.
     */
    public function getAssetGroups(WebPage $webPage) {
        // Create the asset mapper instance
        $asf = $this->contentFactory->createAssetMapper();
        // Query asset groups.
        $assetGroups = $asf->findByWebPage(
                                $webPage->getId(), $webPage->getLanguage());
        return $assetGroups;
    }
    
    /**
     * Helper method that allows you to the the requested language for a 
     * query. This method just changes the value if the given <code>$lang</code>
     * is not <code>null</code>. If it is not <code>null</code> it returns the 
     * previous language setting. This value could be used to reset to the 
     * default value after a query.
     * 
     * @param IConfigurable $mapper Any mapper that implements this interface.
     * @param string $lang The language that should be used.
     * @return string The old language setting.
     */
    private function setQueryLanguage(IConfigurable $mapper, $lang) {
        // Temp variable for the current language settings.
        $tmpLang = null;
        // Is the given parameter not null?
        if ($lang != null) {
            // Store current language settings in the temporary variable
            $tmpLang = $mapper->getProperty(IConfigurable::LANGUAGE);
            // Set new value
            $mapper->setProperty(IConfigurable::LANGUAGE, $lang);
        }
        // Return null or old value
        return $tmpLang;
    }
}
?>
