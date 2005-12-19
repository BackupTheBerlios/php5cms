<?php
/**
 * This class is a layer between the user view an the buisness logic of XpCms.
 * 
 * @package XpCms.Backend
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
class BackendModule extends XpCmsBaseModule {


	public function onLoad($param) {
		parent::onLoad($param);
        
	}
	
	
	public function getBackendMenu() {
        $service = ContentService::getInstance();
        return $service->getWebCollectionsByAlias(
                    IXpCmsConstants::BACKEND_MENU_ALIAS);        
	}	
}
?>
