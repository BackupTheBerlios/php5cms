<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class ModuleMenu extends TPanel {
	
	public function onInit($param) {
		parent::onInit($param);
		
		$collections = $this->Module->getBackendMenu();		

	}	
}
?>
