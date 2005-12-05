<?php
/**
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class WebPage extends DynamicPropertyObject {
	
	protected $id;
	
	protected $name;
	
	protected $description;
	
	protected $status;
	
	protected $language;
	
	public function __construct() {
		parent::__construct(
			array(
				'Id'       => array(
					'name' => 'id',   'type' => 'integer', 'readonly' => true),
				'Name'     => array('name' => 'name', 'type' => 'string'),
				'Description' => array(
					'name' => 'description', 'type' => 'string'),
				'Language' => array('name' => 'language', 'type' => 'string'),
				'Status'   => array('name' => 'status', 'type' => 'integer')
			)
		);
	}
		
}
?>
