<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class XpCmsBaseModule extends TModule {

	public function onLoad($param) {
		parent::onLoad($param);
        
        $lang = $this->Request->getParameter('lang');
		
	}	
}
?>
