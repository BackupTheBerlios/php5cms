<?php
/**
 * A <code>WebCollection</code>-object is a navigation entry of the complete
 * website.
 *
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.8 $
 */
class WebCollection extends DynamicPropertyObject implements IGroupable {

	/**
	 * The id of this web collection.
	 *
	 * @var integer $id
	 */
	protected $id;
    
    /**
     * The alias name of this collection. This name could be used to create a 
     * human readable url. In combination with the page<code>$language</code> it
     * is possible to create a language specific link like the following one.
     * 
     * <code>
     * collection.de_DE.html
     * </code>
     * 
     * @var string $alias
     */
    protected $alias;

	/**
	 * The status of this web collection.
	 *
	 * @var integer $status
	 */
	protected $status = 0;

	/**
	 * The foreign id of the structure group.
	 *
	 * @var integer $groupId
	 */
	protected $groupId;
    
    /**
     * The page class used to display this collection branch or 
     * <code>null</code>.
     * 
     * @var string $pageClass
     */
    protected $pageClass;

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
	private $parentCollection = null;

	/**
	 * The child <code>WebCollection</code>-instances.
	 *
	 * @var ArrayObject $webCollections
	 */
	private $webCollections;

	/**
	 * The <code>StructureGroup</code>-object that describes the relationship
	 * between this and other objects.
	 *
	 * @var StructureGroup $structureGroup
	 */
	private $structureGroup = null;

	/**
	 * Simple constructor with no arguments.
	 */
	public function __construct() {
		parent::__construct(array(
			'Id'        => array(
					'name' => 'id',   'type' => 'integer', 'readonly' => true),
            'Alias'     => array('name' => 'alias', 'type' => 'string'),
			'Status'    => array('name' => 'status', 'type' => 'integer'),
			'GroupId'   => array('name' => 'groupId', 'type' => 'integer'),
            'PageClass' => array('name' => 'pageClass', 'type' => 'string')
		));
		// Init the collection container
		$this->webCollections = new ArrayObject();
	}
    
    public function getURL() {
        $parts = array($this->getAlias());
        
        $collection       = $this;
        $parentCollection = $collection->getParentCollection();
        while ($parentCollection !== null) {
            
            $collection       = $parentCollection;
            $parentCollection = $parentCollection->getParentCollection();
            
            $parts[] = $collection->getAlias();
        }
        
        #$parts[] = $collection->getStructureGroup()->getAlias();
        
        return sprintf(
            '/%s.%s.htm', implode('/', array_reverse($parts)), $this->getWebPage()->getLanguage());
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
	 * 
	 * @param WebCollection $parentCollection The parent collection.
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
		if ($this->webPage === null && $this->id !== null) {
            // Get lazy load service
            $lls = LazyLoadService::getInstance();
			// Find the web page by this collection
			$this->webPage = $lls->getPageByCollection($this);
			// Set this as parent
			if ($this->webPage !== null) {
				$this->webPage->setCollection($this);
			}
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
        if ($this->webPage->getCollection() !== $this) {
            $this->webPage->setCollection($this);
        }
	}

	/**
	 * Returns the <code>StructureGroup</code>-object for this web collection.
	 *
	 * @return StructureGroup The structure group instance.
	 */
	public function getStructureGroup() {
		// If it doesn't exists we have to load it
		if ($this->structureGroup === null && $this->groupId !== null) {
            $service = LazyLoadService::getInstance();
			// Try to find it
			$this->structureGroup = $service->getStructureGroupByCollection($this);
		}
		return $this->structureGroup;
	}

	/**
	 * Sets the <code>StructureGroup</code>-object for this web collection.
	 *
	 * @param StructureGroup $structureGroup The structure group instance.
	 */
	public function setStructureGroup(StructureGroup $structureGroup) {
		$this->structureGroup = $structureGroup;
	}
}
?>
