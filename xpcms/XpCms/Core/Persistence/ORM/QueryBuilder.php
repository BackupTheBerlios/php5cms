<?php

require_once 'XpCms/Core/Persistence/ORM/TableClassMapping.php';
require_once 'XpCms/Core/Persistence/ORM/ColumnPropertyMapping.php';

/*
 * Created on 30.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class QueryBuilder implements IConfigurable {
    
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
     * This property holds the structs that descibe the relation between tables,
     * class, columns and properties. 
     * 
     * This is a temporary solution an must be implemented in a cleaner way.
     * 
     * @var array $mapping
     * @todo Implement this in a cleaner and better way!!!
     */
    private $mapping = array();
    
    private $baseMapping = array(
        array('column' => 'asset_id',       'property' => 'Id'),
        array('column' => 'asset_coll_fid', 'property' => 'CollectionId'),
        array('column' => 'asset_lang',     'property' => 'Language'),
        array('column' => 'asset_name',     'property' => 'Name'),
        array('column' => 'asset_desc',     'property' => 'Description'),
        array('column' => 'asset_status',   'property' => 'Status'),
        array('column' => 'asset_pos',      'property' => 'Position'),
        array('column' => 'asset_group',    'property' => 'GroupId'));
                                  
    private $baseSelectLangQuery = 'SELECT
                                  a1.id AS asset_id, 
                                  a1.collection_fid AS asset_coll_fid, 
                                  a1.language AS asset_lang,
                                  a1.name AS asset_name, 
                                  a1.description AS asset_desc,
                                  a1.state AS asset_status,
                                  wpa.position AS asset_pos,
                                  wpa.group_fid AS asset_group%s
                                FROM
                                  %s AS a1, 
                                  %s AS a2, 
                                  %s AS wpa
                                WHERE
                                  wpa.web_page_fid = ? AND
                                  a1.id = wpa.asset_fid AND
                                  a1.state IN (%s) AND
                                  a1.language = ? AND
                                  a2.asset_fid = a1.id';
                                  
    private $baseSelectQuery = 'SELECT
                                  a1.id AS asset_id, 
                                  a1.collection_fid AS asset_coll_fid, 
                                  a1.language AS asset_lang,
                                  a1.name AS asset_name, 
                                  a1.description AS asset_desc,
                                  a1.state AS asset_status,
                                  wpa.position AS asset_pos,
                                  wpa.group_fid AS asset_group%s
                                FROM
                                  %s AS a1, 
                                  %s AS a2, 
                                  %s AS wpa
                                WHERE
                                  wpa.web_page_fid = ? AND
                                  a1.id = wpa.asset_fid AND
                                  a1.state IN (%s) AND
                                  a2.asset_fid = a1.id';
                                  
    private $rawBaseTables = array();
    
    private $rawUnionTables = array();
                                  
    private $selectUnionNoLang;
    
    private $selectUnionLang;
                                  
    private $pageToAssetTableName = 'web_page_to_asset';
    
    private $assetTableName = 'asset';
    
    public function __construct(ArrayAccess $properties) {
        
        // Initialize the properties attribute
        $this->properties = $properties;
        
        $this->pageToAssetTableName = $this->prepareTableName(
                $this->pageToAssetTableName);
        $this->assetTableName = $this->prepareTableName($this->assetTableName);
        
        $this->rawBaseTables[] = new TableClassMapping(null, 'web_page_to_asset', array(
            new ColumnPropertyMapping('web_page_fid', null, 'integer'),
            new ColumnPropertyMapping('asset_fid', null, 'integer'),
            new ColumnPropertyMapping('group_fid', 'GroupId', 'integer'),
            new ColumnPropertyMapping('position', 'Position', 'float')));
            
        $this->rawBaseTables[] = new TableClassMapping(null, 'asset', array(
            new ColumnPropertyMapping('id', 'Id', 'integer', true),
            new ColumnPropertyMapping('collection_fid', 'CollectionId', 'integer'),
            new ColumnPropertyMapping('language', 'Language', 'string'),
            new ColumnPropertyMapping('name', 'Name', 'string',
            new ColumnPropertyMapping('description', 'Description', 'string'),
            new ColumnPropertyMapping('state', 'status', 'integer'))));
        
        $mapping   = array();
        $mapping[] = new TableClassMapping('AssetText', 'asset_text', array(
            new ColumnPropertyMapping('title', 'Title', 'string'),
            new ColumnPropertyMapping('content', 'Content', 'string')));
        $mapping[] = new TableClassMapping('AssetLink', 'asset_link', array(
            new ColumnPropertyMapping('url', 'Url', 'string'),
            new ColumnPropertyMapping('title', 'Title', 'string'),
            new ColumnPropertyMapping('description', 'Description', 'string'),
            new ColumnPropertyMapping('clicks', 'Clicks', 'integer')));
        $mapping[] = new TableClassMapping('AssetImage', 'asset_image', array(
            new ColumnPropertyMapping('url', 'Url', 'string'),
            new ColumnPropertyMapping('title', 'Title', 'string')));
            
        $this->parseRawTables();
        $this->parseMapping($mapping);
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
        $stat = $this->getProperty(IConfigurable::STATUS);
        
        // Any other status?
        if (is_numeric($stat)) {
            $status = $stat;
        } else if (is_array($stat)) {
            $status = implode(',', $stat);
        }
        
        return $status;
    }
    
    
    public function createUnionQuery() {
        $status = $this->getStatusSQL();
        $lang   = $this->getProperty(IConfigurable::LANGUAGE);
        if ($lang === null) {
            $sql = $this->selectUnionNoLang;
            $inc = 1;
        } else {
            $sql = $this->selectUnionLang;
            $inc = 2;
        }

        return preg_replace('#\{status\}#', $status, $sql);
    }
    
    
    public function createObjectFromRecord($record) {
        
        $type = $record['asset_type'];
        if (!isset($this->mapping[$type])) {
            throw new RuntimeException(
                'The ResultSet contain no information about the asset type.');
        }
        
        $mapping = $this->mapping[$type];
        
        $object = new $mapping['class']();
        
        foreach ($this->baseMapping as $map) {
            $object->{$map['property']} = $record[$map['column']];
        }
        
        foreach ($mapping['map'] as $map) {
            if (isset($map['property'])) {    
                $object->{$map['property']} = $record[$map['alias']];
            }
        }
        
        return $object;
    }
    
    public function getNumberOfMappings() {
        return sizeof($this->mapping);
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
    
    protected function parseRawTables() {
        
        $aliasName  = 'tbl';
        $aliasIndex = 1;
        
        foreach ($this->rawBaseTables as $table) {
            
            
        }
    }
    
    protected function parseMapping($rawMapping) {
                
        $tables     = array();
        $table2prop = array();
        $mappings   = array();
        
        // Make some initial settings
        foreach ($rawMapping as $mapping) {
            $columns = array();
            $column2prop = array();
            // Create maps that contain column name and php type
            // and column name and object property name
            foreach ($mapping->columns as $column) {
                $columns[$column->columnName]     = $column->propertyType;
                $column2prop[$column->columnName] = $column->propertyName;
            }
            // sort column <=> type map by the php type name
            // This is required to compare the needed column types 
            asort($columns);
            
            // store column info in table array
            $tables[$mapping->tableName]     = $columns;
            // store property <=> column mapping in array
            $table2prop[$mapping->tableName] = $column2prop;
            // Start creating the result map: Set class for table
            $mappings[$mapping->tableName] = array(
                    'class' => $mapping->className, 'map' => array());
                    
                    
            // Include class file for later
            include_once 'XpCms/Core/Domain/' . $mapping->className . '.php';
        }
        // Reset internal pointer 
        reset($tables);
        
        // Create two clones of the table array
        $tables1 = $tables;
        $tables2 = $tables;
        
        // Compare column info of the tables with each other 
        while (($table1 = current($tables1)) !== false) {
            $key1 = key($tables1);
            while (($table2 = current($tables2)) !== false) {
                // We cannot compare columns of one and the same table
                if (($key2 = key($tables2)) != $key1) {
                    // Temporary table copy. This is used to unset all found
                    // column types
                    $tmp = $table2;
                    // Compare fields in $table1 with the fields in $tmp 
                    foreach ($table1 as $field => $type) {
                        // Search for field type in tmp
                        $idx = array_search($type, $tmp);
                        // Not found!? Then create a dummy alias entry
                        if ($idx === false) {
                            $alias  = '#%' . $field;
                            $i = 0;
                            while (isset($table2[$alias . $i])) {
                                ++$i;
                            }
                            // add alias entry to current table 
                            $table2[$alias . $i] = $type;
                        // Found!? Then remove the index from $tmp so we cannot
                        // use it twice
                        } else {
                            unset($tmp[$idx]);
                        }
                    }
                    // Sort by field type so we have the correct order
                    asort($table2);
                    // Store back filled table
                    $tables2[$key2] = $table2;
                }
                // Move to next table info
                next($tables2);
            }
            reset($tables2);
            next($tables1);
        }
        
        // Set up result mapping info
        foreach ($tables2 as $tableName => $columns) {
            foreach (array_keys($columns) as $idx => $key) {
                // Base info a dummy column will look like NULL AS aliasName
                // a normal column will look like a2.columnName AS col_3
                $info = array(
                        'column'   => (strpos($key, '#%') === 0 ? 'NULL' : 'a2.'.$key),
                        'type'     => $columns[$key],
                        'alias'    => 'col_' . $idx);
                // If it is a physical column add property information
                if (isset($table2prop[$tableName][$key])) {
                    $info['property'] = $table2prop[$tableName][$key];
                }
                // Store the column info in the result mapping 
                $mappings[$tableName]['map'][] = $info;
            }
        }
        
        // Union select with no language attribute
        $unionNoLang = array();
        // Union select with language attribute
        $unionLang   = array();

        // loop thru all tables and create idividual select queries
        foreach ($mappings as $tableName => $mapping) {
            // Use table name as unique identifier, so the application knowns
            // what type of asset it is.
            $assetSelect = sprintf(', \'%s\' AS asset_type', $tableName);
            // Create specific sql part for this table.
            foreach ($mapping['map'] as $column) {
                $assetSelect .= sprintf(
                        ', %s AS %s', $column['column'], $column['alias']);
            }
            
            // Prepare current table name, so it matches the system settings
            $preparedTableName = $this->prepareTableName($tableName);
            
            // Select query without language setting
            $select1 = sprintf(
                    $this->baseSelectQuery, 
                    $assetSelect,
                    $this->assetTableName,
                    $preparedTableName,
                    $this->pageToAssetTableName,
                    '{status}');
            // Select query with language setting
            $select2 = sprintf(
                    $this->baseSelectLangQuery, 
                    $assetSelect,
                    $this->assetTableName,
                    $preparedTableName,
                    $this->pageToAssetTableName,
                    '{status}');
            
            // Finally store queries for each asset type
            $mappings[$tableName]['sql'] = array(
                'select' => $select1, 'select_lang' => $select2);
            
            // Keep selects for the big union queries
            $unionNoLang[] = $select1;
            $unionLang[]   = $select2;
        }
        #print_r($unionNoLang);
        // Create both union queries
        $this->selectUnionNoLang = sprintf(
                '(%s) ORDER BY asset_group, asset_pos', 
                implode(")\nUNION\n(", $unionNoLang));
        $this->selectUnionLang = sprintf(
                '(%s) ORDER BY asset_group, asset_pos', 
                implode(")\nUNION\n(", $unionLang));
        
        $this->mapping = $mappings;
    } 
}

class TableClassMap {
    
    public $tableName;
    public $className;
    public $map = array();
    
    public function __construct($tableName, $className) {
        $this->tableName = $tableName;
        $this->className = $className;
    }
}

class TableClassSql {
    
    public $tableClassMap;
    
    public $selectSelect;
    public $selectFrom;
    public $selectWhere;
    public $selectGroup;
    public $selectOrder;
    
    public function __construct(TableClassMap $tableClassMap) {
        $this->tableClassMap = $tableClassMap;
    }
}

class ColumnPropertyMap {
    
    public $column;
    public $alias;
    public $type;
    public $property;
    
    public function __construct($column, $alias, $type, $property) {
        $this->column   = $column;
        $this->alias    = $alias;
        $this->type     = $type;
        $this->property = $property;
    }
}
?>
