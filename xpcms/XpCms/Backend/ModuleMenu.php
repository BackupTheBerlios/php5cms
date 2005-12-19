<?php

/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class ModuleMenu extends TPanel {

	public function onLoad($param) {
		parent :: onLoad($param);
        
        $module = pradoGetApplication()->loadModule('Backend');

        $this->BackendMenu->setDataSource($module->getBackendMenu());
        $this->BackendMenu->dataBind();
	}
}
?>

