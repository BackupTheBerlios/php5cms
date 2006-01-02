<?php

/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class ModuleMenu extends TControl {

	public function onLoad($param) {
		parent :: onLoad($param);
        
        $module = pradoGetApplication()->loadModule('Backend');

        $this->BackendMenu->setDataSource($module->getBackendMenu());
        $this->BackendMenu->dataBind();
	}
    
    
    public function ModuleMenu_OnItemCreated($sender, $param) {
        $category = $param->item;
        
        CollectionUtil::getPageClassAndAliasPath($category->Data, $pageClass, $aliasPath);
        
        $params['alias'] = $aliasPath;
        
        $URL = $this->Request->constructUrl($pageClass, $params);

        $link = $category->ProductLink;
        $link->setEncodeText(false);
        $link->Text = '<span>'.$category->Data->getWebPage()->Name.'</span>';       
        $link->NavigateUrl = $URL;
        $link->setAttribute('title',$category->Data->getWebPage()->Description);
    }
}
?>

