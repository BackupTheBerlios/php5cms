<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class BaseXpCmsModule extends TModule {
	
	const PERSISTENCE_TYPE = 'PersistenceType';
	
	const PERSISTENCE_PARAM = 'PersistenceParam';

	protected $persistenceType = '';
	
	protected $persistenceParam = '';	

	public function onLoad($param) {
		parent::onLoad($param);
        
        $lang = $this->Request->getParameter('lang');
		
		$this->persistenceType  = $this->Application->getUserParameter(
													   self::PERSISTENCE_TYPE);
		$this->persistenceParam = $this->Application->getUserParameter(
													   self::PERSISTENCE_PARAM);
	}	
}
?>
