<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class BackendModule extends XpCmsBaseModule {
    
    
    const BACKEND_MENU_ALIAS = 'BEMenuAlias';
    
    
    private $config;


	public function onLoad($param) {
		parent::onLoad($param);
        
        $this->config = XpCmsConfig::getInstance();
	}
	
	
	public function getBackendMenu() {

        $service = ContentService::getInstance();
        return $service->getWebCollectionsByAlias($this->config->getMenuAlias());        
	}	
}
?>
