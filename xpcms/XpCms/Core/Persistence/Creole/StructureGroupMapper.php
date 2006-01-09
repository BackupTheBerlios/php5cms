<?php
/**
 * This mapper class is used to retrieve <code>StructureGroup</code>-objects 
 * from the underlying storage.
 * 
 * @package XpCms.Core.Persistence.Creole
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
class StructureGroupMapper 
    extends AbstractBaseMapper 
    implements IStructureGroupMapper {

    /**
     * Raw table name where structure groups are stored.
     * 
     * @var string $groupTableName
     */
	private $groupTableName = 'structure_group';

    /**
     * Raw table name with group to nested set mapping.
     * 
     * @var string $nestedSetTableName
     */
	private $nestedSetTableName = 'structure_group_nested_set';

    /**
     * Raw table name of the table with the language specific detals of a group.
     * 
     * @var string $detailTableName
     */
	private $detailTableName = 'structure_group_detail';

	/**
	 * This property is some kind of cache that holds all loaded instances of
	 * <code>StructureGroup</code> for its id. So it will be loaded only once.
	 * 
	 * @var array $objectToIdMap
	 */
	private $objectToIdMap = array ();

	/**
	 * This property is some kind of cache that holds all loaded instances of
	 * <code>StructureGroup</code> for its alias. So it will be loaded only once
	 * 
	 * @var array $objectToAliasMap
	 */
	private $objectToAliasMap = array ();

	public function __construct(Connection $conn) {
		parent :: __construct($conn);

		// Prepare the default table names
		$this->groupTableName = $this->prepareTableName(
                                            $this->groupTableName);
		$this->nestedSetTableName = $this->prepareTableName(
                                            $this->nestedSetTableName);
		$this->detailTableName = $this->prepareTableName(
                                            $this->detailTableName);
	}

    /**
     * This method returns a single <code>StructureGroup</code>-object for the
     * given <code>$id</code> or <code>null</code> if it doesn't exist.
     * 
     * @param integer $id The <code>StructureGroup</code> identifier.
     * @param string $locale The language of the requested assets.
     * @return mixed The <code>StructureGroup</code>-object or <code>null</code>
     */
	public function findById($id, $locale) {

		if (!isset ($this->objectToIdMap[$id])) {

			$sql = sprintf(
                     'SELECT 
			                 sg1.id, sgd1.language, sgd1.name,
                             sgd1.description, sg1.alias
			            FROM
							 %s AS sg1, 
							 %s AS sgd1 
					   WHERE
						     sg1.id = ? AND sgd1.group_fid = sg1.id AND
                             sgd1.language = ?', 
                      $this->groupTableName, $this->detailTableName);

			// Create a prepared statement
			$stmt = $this->conn->prepareStatement($sql);
			// Set some basic params
			$stmt->setInt(1, $id);
			$stmt->setString(2, $locale);
			$stmt->setOffset(0);
			$stmt->setLimit(1);

			// Lets execute
			$rs = $stmt->executeQuery();

			// Empty StructureGroup variable
			$structureGroup = null;
			// Do we have any record?
			if ($rs->getRecordCount() > 0 && $rs->first()) {
                $structureGroup = $this->populateStructureGroup($rs);
			}

			$rs->close();
			$stmt->close();
		} else {
            $structureGroup = $this->objectToIdMap[$id];
        }
        
        return $structureGroup;
	}
    
    /**
     * This method returns a <code>ArrayAccess</code>-object that contains all
     * sub <code>StructureGroup</code>s that are under the group for the given
     * <code>$alias</code>.
     * 
     * @param string $alias The alias name for the parent 
     *                      <code>StructureGroup</code>.
     * @param string $locale The language of the requested assets.
     * @return ArrayAccess An <code>ArrayAccess</code>-object with all sub
     *                     <code>StructureGroup</code>s.
     */
    public function findSubGroupsByAlias($alias, $locale) {

        $sql = sprintf(
                 'SELECT 
                         sg2.id, sgd1.language, sgd1.name,
                         sgd1.description, sg2.alias
                    FROM
                         %s AS sg1,
                         %s AS sg2,
                         %s AS sgd1 
                   WHERE
                         sg1.alias = ? AND
                         sg2.group_fid = sg1.id AND
                         sgd1.group_fid = sg2.id AND
                         sgd1.language = ?
                   ORDER BY
                         sg2.position ASC', 
                  $this->groupTableName, 
                  $this->groupTableName,
                  $this->detailTableName);

        // Create a prepared statement
        $stmt = $this->conn->prepareStatement($sql);
        // Set some basic params
        $stmt->setString(1, $alias);
        $stmt->setString(2, $locale);

        // Lets execute
        $rs = $stmt->executeQuery();

        // Empty StructureGroups variable
        $structureGroups = new ArrayObject();
        // Do we have any record?
        while ($rs->next()) {
            $structureGroups[] = $this->populateStructureGroup($rs);
        }

        $rs->close();
        $stmt->close();
        
        return $structureGroups;
    }
    
    
    private function populateStructureGroup(ResultSet $rs) {
        
        $id    = $rs->getInt('id');
        $alias = $rs->getString('alias');
        
        if (!isset($this->objectToIdMap[$id])) {
            
            $structureGroup = new StructureGroup();
            $structureGroup->setId($id);
            $structureGroup->setAlias($alias);
            $structureGroup->setLanguage($rs->getString('language'));
            $structureGroup->setName($rs->getString('name'));
            $structureGroup->setDescription($rs->getString('description'));
            
            $this->objectToIdMap[$id]       = $structureGroup;
            $this->objectToAliasMap[$alias] = $structureGroup;
        }
        return $this->objectToIdMap[$id]; 
    }
}
?>

