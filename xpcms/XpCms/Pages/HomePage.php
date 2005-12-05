<?php
/**
 * 
 */
class HomePage extends TPage {
	
	
	public function onInit($param) {
		parent::onInit($param);
		
		$type   = $this->Application->getUserParameter("PersistanceType");
		$pparam = $this->Application->getUserParameter("PersistanceParam");
		
		
		$mapper = AbstractMapperFactory::getInstance($type, $pparam);
		
		
	}
}
?>
