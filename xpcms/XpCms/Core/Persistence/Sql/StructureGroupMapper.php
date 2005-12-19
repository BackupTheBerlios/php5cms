<?php

/*
 * Created on 10.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class StructureGroupMapper extends AbstractBaseMapper implements IStructureGroupMapper {

	private $groupTableName = 'structure_group';

	private $nestedSetTableName = 'structure_group_nested_set';

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

	public function findById($id) {

		if (!isset ($this->objectToIdMap[$id])) {

			$sql = sprintf(
                     'SELECT 
			                 sg1.id, sgd1.language, sgd1.name,
                             sgd1.text, sg1.alias
			            FROM
							 %s AS sg1, 
							 %s AS sgd1 
					   WHERE
						     sg1.id = ? AND sgd1.group_fid = sg1.id', 
                      $this->groupTableName, $this->detailTableName);

			$lang = $this->getProperty(self :: LANGUAGE_FIELD);
			if ($lang !== null) {
				$sql .= ' AND sgd1.language = ?';
			}

			// Create a prepared statement
			$stmt = $this->conn->prepareStatement($sql);
			// Set some basic params
			$stmt->setInt(1, $id);
			$stmt->setString(2, $lang);
			$stmt->setOffset(0);
			$stmt->setLimit(1);

			// Lets execute
			$rs = $stmt->executeQuery();

			// Empty StructureGroup variable
			$structureGroup = null;
			// Do we have any record?
			if ($rs->getRecordCount() > 0 && $rs->first()) {
                
                $id    = $rs->getInt('id');
                $alias = $rs->getString('alias');
                
				$structureGroup = new StructureGroup();
				$structureGroup->setId($id);
				$structureGroup->setAlias($alias);
				$structureGroup->setLanguage($rs->getString('language'));
				$structureGroup->setName($rs->getString('name'));
				$structureGroup->setDescription($rs->getString('text'));
                
                $this->objectToIdMap[$id]       = $structureGroup;
                $this->objectToAliasMap[$alias] = $structureGroup;
			}

			$rs->close();
			$stmt->close();
		} else {
            $structureGroup = $this->objectToIdMap[$id];
        }
        
        return $structureGroup;
	}
}
?>

