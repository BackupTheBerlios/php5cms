<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class BackendModule extends BaseXpCmsModule {
    
    
    const BACKEND_MENU_ALIAS = 'BEMenuAlias';


	public function onLoad($param) {
		parent::onLoad($param);
	}
	
	
	public function getBackendMenu() {
		$menuAlias = $this->Application->getUserParameter(self::BACKEND_MENU_ALIAS);
        
        $service = ContentService::getInstance(
                            $this->persistenceType, $this->persistenceParam);
        return $service->getWebCollectionsByAlias($menuAlias);        
	}	
}
?>
