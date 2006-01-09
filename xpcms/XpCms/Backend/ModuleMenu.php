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
        
        $collectionInfo = CollectionUtil::getPageClassAndAliasPath(
                                                            $category->Data);
        
        $params['alias'] = $collectionInfo->aliasPath;
        
        $URL = $this->Request->constructUrl($collectionInfo->pageClass, $params);
        
        $page = $this->Request->getParameter(TRequest::PAGE_SERVICE);
        
        $link = $category->TabItem;
        
        #print_r($result);
        
        $webPage  = $category->Data->getWebPage();
        $helpText = '';
        
        if ($this->compare($page, $collectionInfo->pageClass)) {
            $link->CssClass = 'tabTopActive';
            $helpText       = $webPage->Description;
        } else {
            $link->CssClass = 'tabTopInActive';
        }
        
        $link->setEncodeText(false);
        $link->Text = $webPage->Name;
        $link->NavigateUrl = $URL;
        $link->setAttribute('title', $webPage->Description);
        
        if ($helpText != '') {
            $this->Parent->MainContentHelp->Text = $helpText;
        }
    }
    
    public function compare($name1, $name2) {
        if (preg_match('#\:([A-Z][a-z0-9_]+)#', $name1, $match)) {
            return strpos(substr($name2, strpos($name2, ':') + 1), $match[1]) === 0;
        }
        return false;
    }
}
?>

