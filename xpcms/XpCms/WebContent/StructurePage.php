<?php
/*
 * Created on 18.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class StructurePage extends TPage {
    
    
    public function onInit($param) {
        parent::onInit($param);
        
        if (!$this->IsPostBack) {
            
            $service = ContentService::getInstance();
            $colls = $service->getWebCollectionsByAlias(IXpCmsConstants::WEBSITE_STRUCTURE_ALIAS);
            
            $this->MainBodyContent->CollectionList->setDataSource($colls);
            $this->MainBodyContent->CollectionList->dataBind();
            
        }
    }
    
}
?>
