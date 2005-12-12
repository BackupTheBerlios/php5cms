<?php
/*
 * Created on 10.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class StructureGroupMapper 
    extends AbstractBaseMapper 
    implements IStructureGroupMapper {
    
    private $groupTableName = 'structure_group';
    
    private $nestedSetTableName = 'structure_group_nested_set';
    
    private $detailTableName = 'structure_group_detail';	
    	
    	public function __construct(Connection $conn) {
    		parent::__construct($conn);
    		
    		// Prepare the default table names
    		$this->groupTableName = $this->prepareTableName($this->groupTableName);
    		$this->nestedSetTableName = $this->prepareTableName(
    				$this->nestedSetTableName);
    		$this->detailTableName    = $this->prepareTableName(
    				$this->detailTableName);
    	}
	
	public function findById($id) {
		
		$sql = sprintf(
				'SELECT sg1.id, sgd1.language, sgd1.name, sgd1.text FROM
				   %s AS sg1, 
				   %s AS sgd1 
				 WHERE
				   sg1.id = ? AND sgd1.group_fid = sg1.id',
				$this->groupTableName, $this->detailTableName);
				
		$lang = $this->getProperty(self::LANGUAGE_FIELD);
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
			$structureGroup = new StructureGroup();
			$structureGroup->setId($rs->getInt('id'));
			$structureGroup->setLanguage($rs->getString('language'));
			$structureGroup->setName($rs->getString('name'));
			$structureGroup->setDescription($rs->getString('text'));
		}
		
		$rs->close();
		$stmt->close();
		
		return $structureGroup;
	}
	
}
?>
