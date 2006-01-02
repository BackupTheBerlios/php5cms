<?php
/**
 * Mapping from a database table to a class.
 *
 * This structure is used to describe the relation between a database table and
 * the corresponding framework class.
 * 
 * @package XpCms.Core.Persistence.ORM
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $ 
 */
class TableClassMapping {
    
    /**
     * The name of the corresponding class.
     * 
     * @var string $className
     */
    public $className;
    
    /**
     * The name of the used database table.
     * 
     * @var string $tableName
     */
    public $tableName;
    
    /**
     * The columns in this table. This array holds 
     * <code>TableColumnPropertyObject</code>-objects.
     * 
     * @var array $columns.
     */
    public $columns = array();
    
    /**
     * Simple constructor that takes all mapping params.
     * 
     * @param string $className The class name.
     * @param string $tableName The database table name.
     * @param array $columns The database columns.
     */
    public function __construct($className, $tableName, $columns = array()) {
        $this->className = $className;
        $this->tableName = $tableName;
        $this->columns   = $columns;
    }
}
?>
