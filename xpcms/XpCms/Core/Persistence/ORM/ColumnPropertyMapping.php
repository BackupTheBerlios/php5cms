<?php
/**
 * Mapping between object property and database column.
 * 
 * @package XpCms.Core.Persistence.ORM
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class ColumnPropertyMapping {
    
    /**
     * The name of the database column.
     * 
     * @var string $columnName
     */
    public $columnName;
    
    /**
     * The name of the object property.
     * 
     * @var string $propertyName
     */
    public $propertyName;
    
    /**
     * The php type of the object property.
     * 
     * @var string $propertyType
     */
    public $propertyType;
    
    /**
     * 
     */
    public $isPrimaryKey;
    
    /**
     * 
     */
    public $isOrderColumn;
    
    /**
     * 
     */
    public $isGroupColumn;
    
    /**
     * Simple constructor that takes all mapping params as argument.
     * 
     * @param string $columnName Name of the database column.
     * @param string $propertyName Name of the object property.
     * @param string $propertyType PHP type of the object property.
     */
    public function __construct($columnName, 
                                $propertyName, 
                                $propertyType,
                                $isPrimaryKey = false,
                                $isOrderColumn = false,
                                $isGroupColumn = false) {
        $this->columnName   = $columnName;
        $this->propertyName = $propertyName;
        $this->propertyType = $propertyType;
    }
}
?>
