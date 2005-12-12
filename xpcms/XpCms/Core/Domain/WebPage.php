<?php
/**
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
class WebPage extends DynamicPropertyObject {

	protected $id;

	protected $collectionId;

	protected $name;

	protected $description;

	protected $status;

	protected $language;

	/**
	 * The parent <code>WebCollection</code>-object.
	 *
	 * @	var WebCollection $collection
	 */
	private $collection = null;

	/**
	 * Simple constructor that sets up the dynamic properties of this domain
	 * object.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'Id'       => array(
					'name' => 'id',   'type' => 'integer', 'readonly' => true),
				'Name'     => array('name' => 'name', 'type' => 'string'),
				'Description' => array(
					'name' => 'description', 'type' => 'string'),
				'Language' => array('name' => 'language', 'type' => 'string'),
				'Status'   => array('name' => 'status', 'type' => 'integer'),
				'CollectionId' => array(
					'name' => 'collectionId', 'type' => 'integer')
			)
		);
	}

	/**
	 * Returns the parent <code>WebCollection</code>-object or <code>null</code>
	 * if it doesn't exist.
	 *
	 * @return WebCollection The parent collection.
	 */
	public function getCollection() {
		// Do we have a collection instance or a collection foreign id?
		if ($this->collection === null && $this->collectionId >= 0) {
			// Create a mapper
			$wcm = AbstractMapperFactory::getInstance(
							)->createWebCollectionMapper();
			// Retrieve the collection by its id
			$this->collection = $wcm->findById($this->collectionId);
		}
		return $this->collection;
	}

	/**
	 * Sets the parent <code>WebCollection</code>-object for this web page.
	 *
	 * @param WebCollection $collection The parent collection.
	 */
	public function setCollection(WebCollection $collection) {
		$this->collection = $collection;
	}

}
?>
