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
 * @version $Revision: 1.3 $
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
						"   wp1.language AS wp_language " .
						"FROM" .
						"   %s AS col1, %s AS wp1 " .
						"WHERE " .
						"   col1.id = ? AND col1.status IN (%s) AND" .
						"   wp1.collection_fid = col1.id AND " .
						"   wp1.status IN (%s)",
						$this->collTableName, $this->pageTableName,
						$status, $status);
		} else {
			$sql = sprintf(
						"SELECT col1.id, col1.status FROM " .
						"  %s AS col1, %s AS wp1 " .
						"WHERE col1.id = ? AND col1.status IN (%s)",
						$this->collTableName, $this->pageTableName, $status);
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
	 *
	 */
	public function findByGroup($group, $loadPage = true) {

        // get the allowed status values.
        $status = $this->getStatusSQL();

        if ($loadPage) {
            $sql = sprintf(
                    "SELECT
                       sgns2.lft, sgns2.rgt, wc1.status, wc1.id,
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
                       sgns2.lft, sgns2.rgt, wc1.status, wc1.id,
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

        $collections = new ArrayObject();

        while ($rs->next()) {
            // TODO: LEFT RIGHT
            // Hierarchie
            $collections[] = $this->createCollectionFromRecord($rs);
        }
	}


    private function createCollectionFromRecord(ResultSet $rs) {
        $collection = new WebCollection();
        $collection->setId($rs->getInt('id'));
        $collection->setStatus($rs->getInt('status'));

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
