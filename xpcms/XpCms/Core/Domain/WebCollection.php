<?php
/**
 * A <code>WebCollection</code>-object is a navigation entry of the complete
 * website.
 * 
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class WebCollection extends DynamicPropertyObject implements IGroupable {
	
	protected $id;
	
	protected $status;
	
	public function __construct() {
		parent::__construct(array(
			'Id'     => array(
					'name' => 'id',   'type' => 'integer', 'readonly' => true),
			'Status' => array('name' => 'status', 'type' => 'integer')
		));
	}
	
	/**
	 * Returns the index page for this collection. This page will be shown up in
	 * the web browser if the user enters this collection.
	 * 
	 * @access public
	 * @return WebPage The web page instance.
	 */
	public function getWebPage() {
		
	}
	
}
?>
