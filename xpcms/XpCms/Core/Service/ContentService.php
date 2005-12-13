<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class ContentService {
	
	private static $instance = null;
	
	public static function getInstance($type, $params) {
		if (self::$instance == null) {
			self::$instance = new ContentService($type, $params);
		}
		return self::$instance;
	}
	
	private $factory = null;
	
	protected function __construct($type, $params) {
		$this->factory = AbstractMapperFactory::getInstance($type, $params);
	}
	
	public function getWebCollectionsByAlias($alias) {
		$wcm = $this->factory->createWebCollectionMapper();
        
        return $wcm->findByGroupAlias($alias);
	}
}
?>
