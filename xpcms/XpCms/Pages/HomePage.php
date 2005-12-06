<?php
/**
 *
 */
class HomePage extends TPage {


	public function onInit($param) {
		parent::onInit($param);

		$type   = $this->Application->getUserParameter("PersistenceType");
		$pparam = $this->Application->getUserParameter("PersistenceParam");


		$mapper = AbstractMapperFactory::getInstance($type, $pparam);


	}
}
?>
