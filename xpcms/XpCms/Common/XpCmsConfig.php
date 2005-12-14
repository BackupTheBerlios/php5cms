<?php
/*
 * Created on 14.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class XpCmsConfig implements IXpCmsConstants {
    
    
    private static $instance = null;
    
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new XpCmsConfig();
        }   
        return self::$instance;
    }
    
    private $beMenuAlias;
    
    private $persistenceType;
    
    private $persistenceParam;
    
    private function __construct() {
        $app = pradoGetApplication();
        
        print_r($app->getUserParameter('aliases')->dummy['name']);
        
        print '<pre>'; print_r($app); print '</pre>';
        
        $this->beMenuAlias = $app->getUserParameter(self::BACKEND_MENU_ALIAS);
        $this->persistenceType = $app->getUserParameter(self::PERSISTENCE_TYPE);
        $this->persistenceParam = $app->getUserParameter(self::PERSISTENCE_PARAM);
    }
    
    
    public function getGroupAlias($name) {
    }
}
?>
