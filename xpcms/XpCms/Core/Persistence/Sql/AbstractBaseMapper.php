<?php
/**
 * This is the base class for all sql mapper implementations. It provides some
 * basic behaviour to all implementing classes.
 * 
 * @package XpCms.Core.Persistence.Sql
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
abstract class AbstractBaseMapper {
    
    /**
     * The status field.
     */	
    	const STATUS_FIELD = 'status';
    
    /**
     * The web page language.
     */	
    	const LANGUAGE_FIELD = 'language';
	
	/**
	 * The used creole <code>Connection</code>-object.
	 * 
	 * @var Connection $conn
	 */
	protected $conn;
	
	/**
	 * Configurable parameters for the <code>AbstractBaseMapper</code>.
	 * 
	 * @var ArrayObject $properties
	 */
	protected $properties;
	
	/**
	 * This property holds a prefix for table names. So you can install multiple
	 * instances of XpCms.
	 * 
	 * @var string $tableNamePrefix
	 */
	private $tableNamePrefix = 'xpcms';
	
	/**
	 * The base constructor for all mapper implementations. It takes a creole
	 * <code>Connection</code>-object as argument.
	 * 
	 * @param Connection $conn The <code>Connection</code>-instance.
	 */
	public function __construct(Connection $conn) {
		$this->conn = $conn;
		
		// Initialize the properties attribute
		$this->properties = new ArrayObject();
	}
	
	/**
	 * Returns a property value.
	 * 
	 * @see IConfigurable::getProperty()
	 */
	public function getProperty($name) {
		$value = null;
		if ($this->properties->offsetExists($name)) {
			$value = $this->properties->offsetGet($name);
		}
		return $value;
	}
	
	/**
	 * Sets a property value.
	 * 
	 * @see IConfigurable::setProperty()
	 */
	public function setProperty($name, $value) {
		$this->properties->offsetSet($name, $value);
	}
	
	/**
	 * Returns a sql/string fragment with the chooseable status falgs.
	 * 
	 * @return string The allowed status flags.  
	 */
	protected function getStatusSQL() {
		// By default just active items
		$status = '1';
		
		// Is a custom value set?
		$stat = $this->getProperty(self::STATUS_FIELD);
		
		// Any other status?
		if (is_numeric($stat)) {
			$status = $stat;
		} else if (is_array($stat)) {
			$status = implode(',', $stat);
		}
		
		return $status;
	}
	
	/**
	 * This method prepares the given <code>$tableName</code> so that it matches
	 * to the applications setting for a table prefix.
	 * 
	 * @param string $tableName The base table name.
	 * @return string The prepared table name.
	 * @see AbstractBaseMapper::$tableNamePrefix 
	 */
	protected function prepareTableName($tableName) {
		$preparedTableName = $tableName;
		if ($this->tableNamePrefix != '') {
			$preparedTableName = $this->tableNamePrefix . '_' . $tableName; 
		}
		return $preparedTableName;
	}
	
}
?>
