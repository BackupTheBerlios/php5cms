<?php
/**
 * A <code>WebCollection</code>-object is a navigation entry of the complete
 * website.
 * 
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
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
	 * The parent <code>WebCollection</code>-instance.
	 * 
	 * @var WebCollection $parentCollection
	 */
	private $parentCollection;
	
	/**
	 * The child <code>WebCollection</code>-instances.
	 * 
	 * @var ArrayObject $webCollections
	 */
	private $webCollections;
		
	/**
	 * Simple constructor with no arguments.
	 */
	public function __construct() {
		parent::__construct(array(
			'Id'     => array(
					'name' => 'id',   'type' => 'integer', 'readonly' => true),
			'Status' => array('name' => 'status', 'type' => 'integer')
		));
		// Init the collection container
		$this->webCollections = new ArrayObject();
	}
	
	/**
	 * Returns the parent <code>WebCollection</code>-instance or a simple
	 * <code>null</code> value if it doesn't exist.
	 * 
	 * @return mixed A WebCollection or null.
	 */
	public function getParentCollection() {
		return $this->parentCollection;
	}
	
	/**
	 * Sets the parent <code>WebCollection</code> for this instance.
	 */
	public function setParentCollection(WebCollection $parentCollection) {
		$this->parentCollection = $parentCollection;
	}
	
	/**
	 * This method returns all child collections for this one as an 
	 * <code>ArrayObject</code>-object.
	 * 
	 * @return ArrayObject An ArrayObject with all child collections.
	 */
	public function getWebCollections() {
		return $this->webCollections;
	}
	
	/**
	 * Adds a single <code>WebCollection</code> to this one. And removes it from
	 * a parent if it is not <code>null</code>.
	 * 
	 * @param WebCollection $collection The new WebCollection.
	 */
	public function addWebCollection(WebCollection $collection) {
		// Was a parent allready set?
		if (($parent = $collection->getParentCollection()) != null) {
			$parent->removeWebCollection($collection);
		}
		// Set this as parent
		$collection->setParentCollection($this);
		// Add object to list
		$this->webCollections->append($collection);
	}
	
	/**
	 * Removes the given <code>$collection</code> from this instance.
	 * 
	 * @param WebCollection $collection The collection to remove.
	 */
	public function removeWebCollection(WebCollection $collection) {
		foreach ($this->webCollections as $idx => $coll) {
			if ($coll === $collection) {
				$this->webCollections->offsetUnset($idx);
				break;
			}
		}
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
