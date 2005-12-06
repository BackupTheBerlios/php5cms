<?php
/**
 * This class is used to retries <code>WebPage</code>s from the database.
 * 
 * @package XpCms.Core.Persistence.Sql
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
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
		parent::__construct($conn);
		
		// Prepare the raw table names.
		$this->pageTableName = $this->prepareTableName($this->pageTableName);
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
				"SELECT * FROM %s WHERE collection_fid = ?",
				$this->pageTableName);
		
		// special language settings?
		$lang = $this->getProperty(self::LANGUAGE_FIELD);
		if (!is_null($lang)) {
			$sql .= sprintf(" AND language = ?");
		}
		
		// create and setup the statement
		$stmt = $this->conn->prepareStatement($sql);
		$stmt->setInt(1, $colId);
		$stmt->setString(2, $lang);
		$stmt->setLimit(1);
		
		// lets exec
		$result = $stmt->executeQuery();
		
		$webPage = null;
		
		// is there any match
		if ($result->getRecordCount() > 0 && $result->first()) {
			// Create an empty instance
			$webPage = new WebPage();
			// setup all values
			$webPage->setId($result->getInt('id'));
			$webPage->setStatus($result->getInt('status'));
			$webPage->setName($result->getString('name'));
			$webPage->setDescription($result->getString('description'));
			$webPage->setLanguage($result->getString('language'));
			$webPage->setCollectionId($result->getInt('collection_fid'));
		}
		
		$result->close();
		$stmt->close();
		
		return $webPage;
	}
	
}
?>
