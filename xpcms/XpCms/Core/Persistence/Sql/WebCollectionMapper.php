<?php
/**
 *

SELECT sgns2.lft, sgns2.rgt, wc1.*,wp1.name, wp1.description FROM
  xpcms_structure_group AS sg1,
  xpcms_structure_group_nested_set AS sgns1,
  xpcms_structure_group_nested_set AS sgns2,
  xpcms_web_collection AS wc1,
  xpcms_web_page AS wp1
WHERE
  sg1.id = 2 AND
  sgns1.group_fid=sg1.id AND sgns1.collection_fid=-1 AND
  sgns2.group_fid=sg1.id AND
  sgns2.lft > sgns1.lft AND sgns2.rgt < sgns1.rgt AND
  wc1.id=sgns2.collection_fid AND wc1.status=1 AND
  wp1.status=1 AND wp1.collection_fid = wc1.id AND
  wp1.language='de_DE'
GROUP BY
  sgns2.lft ASC

 * @package XpCms.Core.Persistence.Sql
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.8 $
 */
class WebCollectionMapper
    extends AbstractBaseMapper
    implements IWebCollectionMapper {

    /**
     * The raw table name for <code>WebCollection</code>s.
     *
     * @var string $collTableName
     */
    	private $collTableName = 'web_collection';

    /**
     * The raw table name for <code>WebPage</code>s.
     *
     * @var string $pageTableName
     */
    	private $pageTableName = 'web_page';

    /**
     * The raw table name for <code>StructureGroup</code>s.
     *
     * @var string $groupTableName
     */
    	private $groupTableName = 'structure_group';

    /**
     * The raw table name for the nested set informations of a group
     *
     * @var string $nestedSetTableName
     */
    	private $nestedSetTableName = 'structure_group_nested_set';

	/**
	 * The constructor for this mapper. It takes a creole
	 * <code>Connection</code>-instance as argument.
	 *
	 * @param Connection $conn The creole <code>Connection</code>-object.
	 */
	public function __construct(Connection $conn) {
		parent::__construct($conn);

		// Prepare the raw table names.
		$this->collTableName  = $this->prepareTableName($this->collTableName);
		$this->pageTableName  = $this->prepareTableName($this->pageTableName);
		$this->groupTableName = $this->prepareTableName($this->groupTableName);

		$this->nestedSetTableName = $this->prepareTableName(
				$this->nestedSetTableName);
	}


	/**
	 * This method finds a single <code>WebCollection</code>-object by its id.
	 * If no <code>WebCollection</code> for the given id exists, it returns
	 * <code>null</code>.
	 *
	 * @param integer $id The <code>$id</code> for the
	 *                    <code>WebCollection</code>.
	 * @param boolean $loadPage Load the associated web page and group.
	 * @return mixed The <code>WebCollection</code> object or <code>null</code>.
	 */
	public function findById($id, $loadPage = true) {

		// get the allowed status values.
		$status = $this->getStatusSQL();

		// raw sql query string
		if ($loadPage) {
			$sql = sprintf(
						"SELECT " .
						"	col1.id, col1.status, " .
						"   wp1.id AS wp_id," .
						"   wp1.status AS wp_status," .
						"   wp1.name AS wp_name," .
						"   wp1.description AS wp_description," .
						"   wp1.language AS wp_language," .
						"   sgns1.group_fid " .
						"FROM" .
						"   %s AS col1, %s AS wp1, %s AS sgns1 " .
						"WHERE " .
						"   col1.id = ? AND col1.status IN (%s) AND" .
						"   wp1.collection_fid = col1.id AND" .
						"   sgns1.collection_fid = col1.id AND" .
						"   wp1.status IN (%s)",
						$this->collTableName,
						$this->pageTableName,
						$this->nestedSetTableName,
						$status, $status);
		} else {
			$sql = sprintf(
						"SELECT" .
						"  col1.id, col1.status, sgns1.group_fid " .
						"FROM " .
						"  %s AS col1, %s AS wp1, %s AS sgns1 " .
						"WHERE" .
						"  col1.id = ? AND col1.status IN (%s) AND" .
						"  sgns1.collection_fid = col1.id",
						$this->collTableName,
						$this->pageTableName,
						$this->nestedSetTableName,
						$status);
		}

		// is a language available?
		$lang = $this->getProperty(self::LANGUAGE_FIELD);

		// if it is append language part
		if (!is_null($lang)) {
			$sql .= sprintf("  AND wp1.language = ?");
		}

		// create a prepared statement
		$stmt = $this->conn->prepareStatement($sql);

		// set required parameters
		$stmt->setInt(1, $id);
		$stmt->setString(2, $lang);
		$stmt->setOffset(0);
		$stmt->setLimit(1);

		// lets execute
		$result = $stmt->executeQuery();

		// declare the collection variable
		$collection = null;

		// Is there a collection for the given id?
		if ($result->getRecordCount() > 0 && $result->first()) {

			$collection = $this->createCollectionFromRecord($result);
		}

		$stmt->close();
		$result->close();

		return $collection;
	}

	/**
	 * This method finds all <code>WebCollection</code>s that belong to the
	 * given <code>StructureGroup</code>. It also loads the associated
	 * <code>WebPage</code>s by default. You can remove this feature if you set
	 * the second parameter <code>$loadPage</code> to <code>false</code>
	 *
	 * @param StructureGroup $group The group to search for.
	 * @param boolean $loadPage Should this method load the associated web pages
	 *                          also? By default this is <code>true</code>.
	 * @return ArrayObject This container holds all top level collections.
	 */
	public function findByGroup(StructureGroup $group, $loadPage = true) {

        // get the allowed status values.
        $status = $this->getStatusSQL();

        if ($loadPage) {
            $sql = sprintf(
                    "SELECT
                       sgns2.lft, sgns2.rgt, sgns2.group_fid,
                       wc1.status, wc1.id,
                       wp1.id AS wp_id,
                       wp1.status AS wp_status,
                       wp1.name AS wp_name,
                       wp1.description AS wp_description,
                       wp1.language AS wp_language
                     FROM
                       %s AS sg1,
                       %s AS sgns1,
                       %s AS sgns2,
                       %s AS wc1,
                       %s AS wp1
                     WHERE
                       sg1.id = ? AND
                       sgns1.group_fid=sg1.id AND sgns1.collection_fid=-1 AND
                       sgns2.group_fid=sg1.id AND
                       sgns2.lft > sgns1.lft AND sgns2.rgt < sgns1.rgt AND
                       wc1.id=sgns2.collection_fid AND wc1.status IN(%s) AND
                       wp1.status IN(%s) AND wp1.collection_fid = wc1.id",
                    $this->groupTableName,
                    $this->nestedSetTableName,
                    $this->nestedSetTableName,
                    $this->collTableName,
                    $this->pageTableName,
                    $status, $status);
        } else {
            $sql = sprintf(
                    "SELECT
                       sgns2.lft, sgns2.rgt, sgns2.group_fid,
                       wc1.status, wc1.id,
                     FROM
                       %s AS sg1,
                       %s AS sgns1,
                       %s AS sgns2,
                       %s AS wc1,
                       %s AS wp1
                     WHERE
                       sg1.id = ? AND
                       sgns1.group_fid=sg1.id AND sgns1.collection_fid=-1 AND
                       sgns2.group_fid=sg1.id AND
                       sgns2.lft > sgns1.lft AND sgns2.rgt < sgns1.rgt AND
                       wc1.id=sgns2.collection_fid AND wc1.status IN(%s)",
                    $this->groupTableName,
                    $this->nestedSetTableName,
                    $this->nestedSetTableName,
                    $this->collTableName,
                    $this->pageTableName,
                    $status);
        }
		// language specific settings?
        $lang = $this->getProperty(self::LANGUAGE_FIELD);
        if ($lang !== null) {
            $sql .= " AND wp1.language = ?";
        }

        $sql .= " GROUP BY sgns2.lft ASC";

        // Create a prepared statement
        $stmt = $this->conn->prepareStatement($sql);
        $stmt->setInt(1, $group->getId());
        $stmt->setString(2, $lang);

        // lets execute
        $rs = $stmt->executeQuery();

       // last right value of the nested set
        $lrgt = -1;
        // array with tree path of right nested set values
        $rgts = array();

        // ArrayObject with all top level collections
        $collections = new ArrayObject();
        // last parent collection
        $parentColl  = null;

        while ($rs->next()) {
            // create collection from record
            $collection = $this->createCollectionFromRecord($rs);
            $collection->setStructureGroup($group);

            $lft = $rs->getInt('lft');
            $rgt = $rs->getInt('rgt');
            
            // Do we need to move up the tree?
            if ($lrgt != -1 && $lft - 1 > $lrgt) {
                    // find number of move up levels
                    $moveUp = array_search($lft - 1, $rgts);

                    // move up the object tree
                    for ($i = sizeof($rgts) - 1; $i >= $moveUp; $i--) {
                    if (is_object($parentColl)) {
                             $parentColl = $parentColl->getParentCollection();
                    }
                    }
                    // remove invalid right values.
                    $rgts = array_slice($rgts, 0, $moveUp);

                    if ($parentColl === null) {
                        $lrgt = -1;
                    }
            }

            // Add to top level container or a nested parent?
            if ($parentColl == null) {
                    $collections->append($collection);
            } else {
                    $parentColl->addWebCollection($collection);
            }
            // keep current rgt in mind
            $lrgt = $rgt;
            // is this a not leaf of composite collection?
            if ($rgt - $lft > 1) {
                    $rgts[]      = $rgt;
                    $parentColl = $collection;
            }
        }
        
        $rs->close();
        $stmt->close();

        return $collections;
	}
    
    /**
     * This method finds all <code>WebCollection</code>s that belong to the 
     * <code>StructureGroup</code> for the given <code>$groupAlias</code>. If 
     * the second parameter is <code>true</code> it will also load the 
     * associated <code>WebPage</code>-objects.
     * 
     * @param string $groupAlias The alias for the group.
     * @param boolean $loadPage Should this method load the associated web pages
     *                          also? By default this is <code>true</code>.
     * @return ArrayObject This container holds all top level collections.
     */
    public function findByGroupAlias($groupAlias, $loadPage = true) {
        
        
    }

	/**
	 * This method inserts or updates the given <code>WebCollection</code> with
	 * all its dependencies in the storage. If the <code>WebCollection</code>
	 * doesn't contain a <code>WebPage</code> an empty dummy will be created
	 * also.
	 *
	 * @param WebCollection $collection The new or changed WebCollection.
	 * @see WebPageMapper::save()
	 *
	 * @throws Exception If the given <code>WebCollection</code> doesn't belong
	 *                   to a <code>StructureGroup</code> or it doesn't exist.
	 *                   If the given <code>WebCollection</code> has a parent
	 *                   that doesn't exist.
     *                   If the given <code>WebCollection</code> doesn't contain
     *                   an instance of <code>WebPage</code>.
	 */
	public function save(WebCollection $collection) {

		// Get the StructureGroup and is it set?
		$structureGroup = $collection->getStructureGroup();
		if ($structureGroup === null) {
			throw new Exception(
                    'The given WebCollection has no StructureGroup');
		}

        // Get the default WebPage
        $webPage = $collection->getWebPage();
        if ($webPage === null) {
            throw new Exception(
                    'The given WebCollection has no WebPage.');
        }

		$parentId = -1;
		// Get the parent id. If it is a new root collection this id is -1.
		if (($parentCollection = $collection->getParentCollection()) !== null) {
			$parentId = $parentCollection->getId();
		}
		// Select the parent and the last child if it exists.
		$sql = sprintf(
               		'SELECT sgns1.lft, sgns1.rgt, sgns1.collection_fid FROM
			      	   %s AS sgns1, %s AS sgns2
			         WHERE
			           (sgns1.group_fid = ? AND sgns1.collection_fid = ?)
			           OR
			           (sgns2.group_fid = ? AND sgns2.collection_fid = ? AND
			           sgns2.lft != sgns2.rgt - 1 AND sgns1.rgt = sgns2.rgt - 1)
			         GROUP BY sgns1.collection_fid
                     ORDER BY sgns1.lft ASC',
			    		$this->nestedSetTableName, $this->nestedSetTableName);

	    // Prepare the sql query
	    $stmt = $this->conn->prepareStatement($sql);

	    // Set the params
	    $stmt->setInt(1, $structureGroup->getId());
	    $stmt->setInt(2, $parentId);
	    $stmt->setInt(3, $structureGroup->getId());
	    $stmt->setInt(4, $parentId);
	    $stmt->setOffset(0);
	    $stmt->setLimit(2);

	    // Let's execute
		$rs = $stmt->executeQuery();

		// If there is no result something was wrong
		if (($recCount = $rs->getRecordCount()) == 0 || !$rs->first()) {
			throw new Exception(
				'Something goes wrong. Either the StructureGroup or the ' .
				'parent WebCollection doesn\'t exist.');
		}

		$ctxEntry = array();

		// First child
		if ($recCount == 1) {

			$ctxEntry = array(
				'lft' => $rs->getInt('lft'),
				'rgt' => $rs->getInt('rgt'),
				'id'  => $rs->getInt('collection_fid'));

			$update1 = sprintf(
							'UPDATE %s
					       	    SET lft       = lft + 2
					          WHERE group_fid = ?
					            AND lft       > ?',
					    		$this->nestedSetTableName);
		    $update2 = sprintf(
		    					'UPDATE %s
		    					    SET rgt        = rgt + 2
		    					  WHERE group_fid  = ?
		    					    AND rgt       >= ?',
		    					$this->nestedSetTableName);
		    $insert1 = sprintf(
		    					'INSERT INTO %s
		    					   (group_fid, collection_fid, lft, rgt)
		    					 VALUES
		    					   (?, ?, ?, ? + 1)',
		    					$this->nestedSetTableName);
			$insert2 = sprintf(
							'INSERT INTO %s
							   (id, status) VALUES (?, ?)',
							$this->collTableName);
		// Has a previous brother
		} else {
			// Move to the second record
			$rs->next();

			$ctxEntry = array(
				'lft' => $rs->getInt('lft'),
				'rgt' => $rs->getInt('rgt'),
				'id'  => $rs->getInt('collection_fid'));

			$update1 = sprintf(
							'UPDATE %s
					       	    SET lft       = lft + 2
					          WHERE group_fid = ?
					            AND lft       > ?',
					    		$this->nestedSetTableName);
		    $update2 = sprintf(
		    					'UPDATE %s
		    					    SET rgt        = rgt + 2
		    					  WHERE group_fid  = ?
		    					    AND rgt        > ?',
		    					$this->nestedSetTableName);
		    $insert1 = sprintf(
		    					'INSERT INTO %s
		    					   (group_fid, collection_fid, lft, rgt)
		    					 VALUES
		    					   (?, ?, ? + 1, ? + 2)',
		    					$this->nestedSetTableName);
			$insert2 = sprintf(
							'INSERT INTO %s
							   (id, status) VALUES (?, ?)',
							$this->collTableName);
		}

		$rs->close();
		$stmt->close();

		try {

			$this->conn->begin();

			$id = $this->getNewPrimaryKey($this->collTableName, 'id');

			// Update left values
			$stmt = $this->conn->prepareStatement($update1);
			$stmt->setInt(1, $structureGroup->getId());
			$stmt->setInt(2, $ctxEntry['rgt']);
			$stmt->executeUpdate();
			$stmt->close();

			// Update right values
			$stmt = $this->conn->prepareStatement($update2);
			$stmt->setInt(1, $structureGroup->getId());
			$stmt->setInt(2, $ctxEntry['rgt']);
			$stmt->executeUpdate();
			$stmt->close();

			// Insert new nested set record
			$stmt = $this->conn->prepareStatement($insert1);
			$stmt->setInt(1, $structureGroup->getId());
			$stmt->setInt(2, $id);
			$stmt->setInt(3, $ctxEntry['rgt']);
			$stmt->setInt(4, $ctxEntry['rgt']);
			$stmt->executeUpdate();
			$stmt->close();

			// Insert new collection
			$stmt = $this->conn->prepareStatement($insert2);
			$stmt->setInt(1, $id);
			$stmt->setInt(2, $collection->getStatus());
			$stmt->executeUpdate();
			$stmt->close();

            // Set the id for this collection.
            $collection->setId($id);
            // Create a IWebPageMapper instance
            $wpm = AbstractMapperFactory::getInstance()->createWebPageMapper();
            // Save the associated WebPage
            $wpm->save($webPage);

			#$this->conn->rollback();
			$this->conn->commit();
		} catch (Exception $e) {
			$this->conn->rollback();

            throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	/**
	 *
	 */
	public function saveBefore(WebCollection $collection, WebCollection $ctx) {

	}

    /**
     * This method deletes a <code>WebCollection</code> from the underlying
     * storage. If the given <code>WebCollection</code>-object contains other
     * <code>WebCollection</code>s or <code>WebPage</code>s it will also delete
     * them.
     *
     * Additional it removes the reference from the collection to its
     * <code>StructureGroup</code>.
     *
     * @param WebCollection $collection The collection that will be removed.
     * @see IWebPageMapper::delete()
     *
     * @throws Exception If the given <code>WebCollection</code> doesn't exist.
     */
	public function delete(WebCollection $collection) {

        // Does the given collection contain an id?
        if ($collection->getId() <= 0) {
            throw new Exception('The given WebCollection doesn\'t exist.');
        }

        $sql = sprintf(
                    'SELECT lft, rgt FROM %s WHERE collection_fid = ?',
                    $this->nestedSetTableName);
        // Create sql statement
        $stmt = $this->conn->prepareStatement($sql);
        // Set params
        $stmt->setInt(1, $collection->getId());
        $stmt->setLimit(1);

        $rs = $stmt->executeQuery();
        if ($rs->getRecordCount() < 1 || !$rs->first()) {
            $rs->close();
            $stmt->close();

            throw new Exception('The given WebCollection doesn\'t exist.');
        }

        $lft = $rs->getInt('lft');
        $rgt = $rs->getInt('rgt');

        $move = floor(($rgt - $lft) / 2);
        $move = 2 * ($move + 1);

        $rs->close();
        $stmt->close();

        $groupId = $collection->getStructureGroup()->getId();

        $delete1 = sprintf('DELETE FROM %s WHERE id = ?', $this->collTableName);
        $delete2 = sprintf('DELETE FROM %s WHERE collection_fid = ?',
                        $this->nestedSetTableName);
        $update1 = sprintf(
                        'UPDATE %s SET lft = lft - ?
                         WHERE group_fid = ? AND lft > ?;',
                        $this->nestedSetTableName);
        $update2 = sprintf(
                        'UPDATE %s SET rgt = rgt - ?
                         WHERE group_fid = ? AND rgt > ?;',
                        $this->nestedSetTableName);

        try {
            $this->conn->begin();

            // Delete from collection table
            $stmt = $this->conn->prepareStatement($delete1);
            $stmt->setInt(1, $collection->getId());
            $stmt->executeUpdate();
            $stmt->close();

            // Delete from nested set table
            $stmt = $this->conn->prepareStatement($delete2);
            $stmt->setInt(1, $collection->getId());
            $stmt->executeUpdate();
            $stmt->close();

            // Update left values
            $stmt = $this->conn->prepareStatement($update1);
            $stmt->setInt(1, $move);
            $stmt->setInt(2, $groupId);
            $stmt->setInt(3, $rgt);
            $stmt->executeUpdate();
            $stmt->close();

            // Update right values
            $stmt = $this->conn->prepareStatement($update2);
            $stmt->setInt(1, $move);
            $stmt->setInt(2, $groupId);
            $stmt->setInt(3, $rgt);
            $stmt->executeUpdate();
            $stmt->close();

			
			$wpm = AbstractMapperFactory::getInstance()->createWebPageMapper();
			$wpm->deleteByCollection($collection);

            // Remove the collection from it's parent if it is set
            $parent = $collection->getParentCollection();
            if ($parent !== null) {
                $parent->removeWebCollection($collection);
            }

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
        }
	}

	/**
	 * This method creates an instance of <code>WebCollection</code> from the
	 * given <code>ResultSet</code>-instance. If a matching <code>WebPage</code>
	 * is also present in the given <code>RecordSet</code> it will be
	 * instantiated also.
	 *
	 * @param ResultSet $rs The result set with the selected record.
	 * @return WebCollection The object representation of the record.
	 */
    private function createCollectionFromRecord(ResultSet $rs) {
        $collection = new WebCollection();
        $collection->setId($rs->getInt('id'));
        $collection->setStatus($rs->getInt('status'));
        $collection->setGroupId($rs->getInt('group_fid'));

        // Do we have the matching web page?
        if (array_key_exists('wp_id', $rs->getRow())) {
            $webPage = new WebPage();
            $webPage->setId($rs->getInt('wp_id'));
            $webPage->setName($rs->getString('wp_name'));
            $webPage->setDescription($rs->getString('wp_description'));
            $webPage->setLanguage($rs->getString('wp_language'));
            $webPage->setStatus($rs->getInt('wp_status'));

            $collection->setWebPage($webPage);
        }

        return $collection;
    }
}
?>
