<?php
/**
 * A <code>WebCollection</code>-object is a navigation entry of the complete
 * website.
 * 
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
class WebCollection extends DynamicPropertyObject implements IGroupable {
	
	/**
	 * The id of this web collection.
	 * 
	 * @var integer $id
	 */
	protected $id;
	
	/**
	 * The status of this web collection.
	 * 
	 * @var integer $status
	 */
	protected $status;
	
	/**
	 * The associated <code>WebPage</code>-instance for the current language
	 * context.
	 * 
	 * @var WebPage $webPage
	 */
	private $webPage = null;
	
	/**
	 * Simple constructor with no arguments.
	 */
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
		// We have no web page, so load it.
		if ($this->webPage === null) {
			// Create the mapper
			$wpm = AbstractMapperFactory::getInstance()->createWebPageMapper();
			// Find the web page by this collection
			$this->webPage = $wpm->findByCollection($this);
			// Set this a parent
			$this->webPage->setCollection($this);
		}
		return $this->webPage;
	}
	
	/**
	 * Sets the index <code>WebPage</code> for this collection. It should be in
	 * current language context.
	 * 
	 * @param WebPage $webPage The web page instance.
	 */
	public function setWebPage(WebPage $webPage) {
		$this->webPage = $webPage;
	}
	
}
?>
