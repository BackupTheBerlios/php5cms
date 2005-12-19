<?php
/**
 * This class is used to retries <code>WebPage</code>s from the database.
 *
 * @package XpCms.Core.Persistence.Sql
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.5 $
 */
class WebPageMapper extends AbstractBaseMapper implements IWebPageMapper {

	/**
	 * The raw name of the table with the web page information.
	 *
	 * @var string $pageTableName
	 */
	private $pageTableName = 'web_page';

	/**
	 * The constructor for this mapper. It takes a creole
	 * <code>Connection</code>-instance as argument.
	 *
	 * @param Connection $conn The creole <code>Connection</code>-object.
	 */
	public function __construct(Connection $conn) {
		parent :: __construct($conn);

		// Prepare the raw table names.
		$this->pageTableName = $this->prepareTableName($this->pageTableName);
	}
	
	/**
	 * This method returns a <code>WebPage</code>-object for the given id. If
	 * there is no record for <code>$id</code> it will return <code>null</code>.
	 * 
	 * @param integer $id The <code>WebPage</code> identifier.
	 * @return mixed A <code>WebPage</code>-instance or <code>null</code>. 
	 */
	public function findById($id) {
		
		// Get the sql fragment for the web page status
		$status = $this->getStatusSQL();
		
		$sql = sprintf(
					'SELECT
					   id, collection_fid,name,description,language,status
					   FROM %s 
					  WHERE
					   id = ? AND status IN (%s)',
					$this->pageTableName, $status);
		
		// Create a prepared sql statement
		$stmt = $this->conn->prepareStatement($sql);
		// Set params
		$stmt->setInt(1, $id);
		$stmt->setLimit(1);
		
		// Execute the query
		$rs = $stmt->executeQuery();

		$webPage = null;
		// is there any match?
		if ($rs->getRecordCount() > 0 && $rs->first()) {
			$webPage = $this->createWebPageFromRecord($rs);
		}
		// Free resources.
		$rs->close();
		$stmt->close();
		
		return $webPage;
	}

	/**
	 * This method returns a <code>WebPage</code>-object for the given
	 * <code>$collection</code> or <code>null</code> if it doesn't exist.
	 *
	 * @param WebCollection $collection The web collection instance
	 * @return mixed A WebCollection object or null.
	 * @see WebPageMapper::findByCollectionId();
	 */
	public function findByCollection(WebCollection $collection) {
		return $this->findByCollectionId($collection->getId());
	}

	/**
	 * This method returns a <code>WebPage</code>-objecz for the given
	 * collection <code>$colId</code> or <code>null</code> if it doesn't exist.
	 *
	 * @param integer $colId The id of the parent collection.
	 * @return mixed The WebCollection object or null.
	 */
	public function findByCollectionId($colId) {

		// get the allowed status values
		$status = $this->getStatusSQL();

		$sql = sprintf(
                     'SELECT * FROM %s WHERE 
                        collection_fid = ? AND status IN (%s)',
                     $this->pageTableName, $status);

		// special language settings?
		$lang = $this->getProperty(self :: LANGUAGE_FIELD);
		if (!is_null($lang)) {
			$sql .= sprintf(" AND language = ?");
		}

		// create and setup the statement
		$stmt = $this->conn->prepareStatement($sql);
		$stmt->setInt(1, $colId);
		$stmt->setString(2, $lang);
		$stmt->setLimit(1);

		// let's exec
		$rs = $stmt->executeQuery();

		$webPage = null;

		// is there any match
		if ($rs->getRecordCount() > 0 && $rs->first()) {
			$webPage = $this->createWebPageFromRecord($rs);
		}

		$rs->close();
		$stmt->close();

		return $webPage;
	}

	/**
	 * This method inserts or updates the given <code>WebPage</code>-object in
	 * the storage. Before a <code>WebPage</code> could be saved it must be
	 * assigned to a <code>WebCollection</code>.
	 *
	 * @param WebPage $webPage The <code>WebPage</code>-object to store.
	 * @see WebPageMapper::insert()
	 * @see WebPageMapper::update()
	 * 
	 * @throws Exception If the given <code>WebPage</code> doesn't belong to a
	 *                   <code>WebCollection</code>.
	 */
	public function save(WebPage $webPage) {

		if ($webPage->getCollection() === null) {
			throw new Exception(
              'You cannot save a WebPage that doesn\'t belong to a collection');
		}
		
		// This is a new empty web page
		if ($webPage->getId() <= 0) {
			$this->insert($webPage);
	    // This is just a change of an existing web page.	
		} else {
			$this->update($webPage);
		}
	}
    
    /**
     * This method removes the given <code>WebPage</code>-object from the 
     * storage. 
     * 
     * @param WebPage $webPage The <code>WebPage</code> that should be removed.
     * 
     * @throws Exception If the given <code>WebPage</code> doesn't exist.
     * 					 If the given <code>WebPage</code> is the last one that
     *                   belongs to a <code>WebCollection</code>.
     */
    public function delete(WebPage $webPage) {
    	
    		// Has this web page an id?	
    		if ($webPage->getId() <= 0) {
    			throw new Exception('The given WebPage doesn\'t exist.');
    		}
    		
    		if ($this->isLastWebPage($webPage)) {
    			throw new Exception(
					'The given WebPage is the last one in the WebCollection.');
    		}
    		
    		$sql = sprintf('DELETE FROM %s WHERE id = ?', $this->pageTableName);
    		
    		// Create an sql statement
    		$stmt = $this->conn->prepareStatement($sql);
    		// Set params
    		$stmt->setInt(1, $webPage->getId());
    		
    		if ($stmt->executeUpdate() != 1) {
    			$stmt->close();
    			throw new Exception('The given WebPage doesn\'t exist.');
    		}
    		$stmt->close();
    }
    
    /**
     * This method removes all <code>WebPage</code>-objects from the storage 
     * that belong to the given <code>WebCollection</code>.
     * 
     * @param WebCollection $collection The context <code>WebCollection</code>.
     * 
     * @throws Exception If the given <code>WebCollection</code> doesn't exist.
     */
    public function deleteByCollection(WebCollection $collection) {
    		
    		// Has this collection an id?
    		if (($collId = $collection->getId()) <= 0) {
    			throw new Exception('The given WebCollection doesn\'t exist.');	
    		}	
    		
    		$sql = sprintf(
					'DELETE FROM %s WHERE collection_fid = ?',
					$this->pageTableName);
		// Create a sql statement
		$stmt = $this->conn->prepareStatement($sql);
		// Set params
		$stmt->setInt(1, $collId);
		
		$stmt->executeUpdate();
		$stmt->close();
    }
    
    /**
     * This method creates a <code>WebPage</code>-instance for the given 
     * <code>ResultSet</code>.
     * 
     * @param ResultSet $rs The database <code>ResultSet</code>
     * @return WebPage The created <code>WebPage</code>-instance.
     */
    private function createWebPageFromRecord(ResultSet $rs) {
    		// Create an empty instance
		$webPage = new WebPage();
		// setup all values
		$webPage->setId($rs->getInt('id'));
		$webPage->setStatus($rs->getInt('status'));
		$webPage->setName($rs->getString('name'));
		$webPage->setDescription($rs->getString('description'));
		$webPage->setLanguage($rs->getString('language'));
		$webPage->setCollectionId($rs->getInt('collection_fid'));
		
		return $webPage;	
    }
    
    /**
     * This method checks if the given <code>WebPage</code> is the last instance
     * that belongs to a <code>WebCollection</code>.
     * 
     * @param WebPage $webPage The context <code>WebPage</code>-object.
     * @return boolean Is it the last one or not 
     */
    private function isLastWebPage(WebPage $webPage) {
    		
    		$sql = sprintf(
					'SELECT id FROM %s WHERE collection_fid = ?',
					$this->pageTableName);
					
		// Create an sql statement
		$stmt = $this->conn->prepareStatement($sql);
		// Set params
		$stmt->setInt(1, $webPage->getCollectionId());
		// Let's execute
		$rs    = $stmt->executeQuery();
		// Get number of web pages
		$count = $rs->getRecordCount();
		
		// Free resources
		$rs->close();
		$stmt->close();
		
		// Is it the one and only
		return ($count == 1);
    }
    
    /**
     * This method inserts a new clean <code>WebPage</code> into the database.
     * 
     * @param WebPage $webPage The new <code>WebPage</code>-object.
     * 
     * @throws Exception If some unknown sql error occures.
     */
    private function insert(WebPage $webPage) {

		$sql = sprintf(
                    'INSERT INTO %s
		               (id, collection_fid, name, description, language, status)
		             VALUES
		               (?, ?, ?, ?, ?, ?)', $this->pageTableName);

		try {
			// begin a the transaction
			$this->conn->begin();
			// Create a new clean primary key
			$id = $this->getNewPrimaryKey($this->pageTableName, 'id');
			// Create a prepared sql statement
			$stmt = $this->conn->prepareStatement($sql);
			// Set params for this insert
			$stmt->setInt(1, $id);
			$stmt->setInt(2, $webPage->getCollection()->getId());
			$stmt->setString(3, $webPage->getName());
			$stmt->setString(4, $webPage->getDescription());
			$stmt->setString(5, $webPage->getLanguage());
			$stmt->setInt(6, $webPage->getStatus());
			
			// Write web page data to the database
			$stmt->executeUpdate();
			// Close open resource
			$stmt->close();
			// Commit the transaction
			$this->conn->commit();
			
			// Set the new primary key of this object.
			$webPage->setId($id);
		} catch (Exception $e) {
			// something goes wrong, so rollback
			$this->conn->rollback();
			throw $e;
		}	
    }
    
    /**
     * This method updates the data of an existing <code>WebPage</code>.
     * 
     * @param WebPage $webPage The changed <code>WebPage</code>-object.
     * 
     * @throws Exception If the given <code>WebPage</code> doesn't exist or some
     *                   unknown error occures. 
     */
    private function update(WebPage $webPage) {
    		
    		$id = $webPage->getId();
    		
    		// Simple update query
    		$sql = sprintf(
    					'UPDATE %s SET 
    					   name = ?, description = ?,
    					   language = ?, status = ?
    					 WHERE id = ?',
    					$this->pageTableName);
    					
    		// Create a prepared sql statement
    		$stmt =	$this->conn->prepareStatement($sql);
    		// Set params
    		$stmt->setString(1, $webPage->getName());
    		$stmt->setString(2, $webPage->getDescription());
    		$stmt->setString(3, $webPage->getLanguage());
    		$stmt->setInt(4,    $webPage->getStatus());
    		$stmt->setInt(5,    $webPage->getId());
    		
    		// Execute the query.
    		$affected = $stmt->executeUpdate();
    		
    		if ($affected != 1) {
    			$stmt->close();
    			throw new Exception('Some unknown error occured.');
    		}
    }
}
?>