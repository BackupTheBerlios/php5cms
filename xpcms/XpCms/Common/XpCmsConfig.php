<?php
/**
 * Global application configuration class. This class abstracts the parameters
 * from the prado framework and makes them available thru a more comfortable
 * interface.
 * 
 * @package XpCms.Common
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
class XpCmsConfig implements IXpCmsConstants {
    
    /**
     * Unique GoF Singleton instance of the <code>XpCmsConfig</code> class.
     * 
     * @var XpCmsConfig $instance
     */
    private static $instance = null;
    
    /**
     * This method returns a unique instance of this class.
     * 
     * @return XpCmsConfig GoF Singleton instance.
     * @see XpCms::$instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new XpCmsConfig();
        }   
        return self::$instance;
    }
    
    /**
     * This property holds a list with the mapping of application layer aliases
     * to database aliases.
     * 
     * @var array $alias
     */
    private $alias = array();
    
    /**
     * This property holds an array with all defined persistence params
     * 
     * @var array $persistence
     */
    private $persistence = array();
    
    /**
     * This is the default language for the content management system.
     * 
     * @var string $stdLanguage
     */
    private $stdLanguage;
    
    /**
     * This is an array with all available languages,
     * 
     * @var array $languages
     */
    private $languages = array();
    
    /**
     * Constructor of the config class which loads all user parameters from 
     * the <code>application.spec</code>-file into object properties.
     */
    private function __construct() {
        $app = pradoGetApplication();
        
        // Read all defined aliases from the config
        foreach ($app->getUserParameter('alias') as $alias) {
            $this->alias[(string) $alias['name']] =  (string) $alias['value'];
        }

        // Read all persistence settings from the settings
        foreach ($app->getUserParameter('persistence') as $persistence) {
            
            $name = (string) $persistence['name'];
            $this->persistence[$name] = array();
            
            foreach ($persistence->attributes() as $a => $b) {
                if ($a !== 'name') {
                    $this->persistence[$name][(string) $a] = (string) $b;
                }
            }
        }
        
        // Read the language settings.
        $language = $app->getUserParameter('language');
        $this->stdLanguage = (string) $language->standard['lang'];
        $this->languages   = explode(',', (string) $language->available['lang']);
    }
    
    public function getStandardLanguage() {
        return $this->stdLanguage;
    }
    
    public function getPersistenceParams($name) {
        return $this->persistence[$name];
    }
    
    
    public function getGroupAlias($name) {
        return $this->alias[$name];
    }
}
?>
