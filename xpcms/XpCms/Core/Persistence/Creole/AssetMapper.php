<?php
require_once 'XpCms/Core/Domain/AbstractAsset.php';

require_once 'XpCms/Core/Persistence/Sql/TableClassMapping.php';
require_once 'XpCms/Core/Persistence/Sql/ColumnPropertyMapping.php';

/**
 * Creole based mapper for assets.
 * 
 * This mapper is used to retrieve an store <code>AbstractAsset</code>-objects
 * with the Creole database abstraction.
 *  
 * @package XpCms.Core.Persistence.Creole
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class AssetMapper extends AbstractBaseMapper implements IAssetMapper {
    
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
                                  
    private $selectUnionNoLang;
    
    private $selectUnionLang;
                                  
    private $pageToAssetTableName = 'web_page_to_asset';
    
    private $assetTableName = 'asset';
   
    /**
     * Constructor.
     * 
     * @param Connection $conn The creole database <code>Connection</code>
     *                         object.
     */
    public function __construct(Connection $conn) {
        parent::__construct($conn);
        
        $this->pageToAssetTableName = $this->prepareTableName(
                $this->pageToAssetTableName);
        $this->assetTableName = $this->prepareTableName($this->assetTableName);
        
        // TODO : Implement this in a cleaner and better way!!!
        // {{{
        
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
            
        $this->parseMapping($mapping);
        // }}}
    }
    
    /**
     * This method returns all <code>AbstractAsset</code>-objects for the given
     * <code>$webPage</code>. The different asset types are returned in their
     * <code>StructureGroup</code>-objects. So you have a structure like this:
     * 
     * <pre>
     *   ArrayAccess {
     *     StructureGroup {
     *       ImageAsset {}
     *       ImageAsset {}
     *     }
     *     StructureGroup {
     *       TextAsset {}
     *       TextAsset {}
     *     }
     *   }
     * </pre> 
     * 
     * If the given <code>WebPage</code> doesn't contain any assets an empty
     * <code>ArrayAccess</code>-object will be returned.
     * 
     * @param WebPage $webPage The context <code>WebPage</code>-object for the
     *                         asset query.
     * @return ArrayAccess An <code>ArrayAccess</code>-object that contains all
     *                     <code>AbstractAsset</code>s in their 
     *                     <code>StructureGroup</code>s.
     */
    public function findByWebPage(WebPage $webPage) {
        
        $status = $this->getStatusSQL();
        $lang   = $this->getProperty(IConfigurable::LANGUAGE);
        if ($lang === null) {
            $sql = $this->selectUnionNoLang;
            $inc = 1;
        } else {
            $sql = $this->selectUnionLang;
            $inc = 2;
        }

        $sql  = preg_replace('#\{status\}#', $status, $sql);
        $stmt = $this->conn->prepareStatement($sql);
        
        for ($i = 0, $j = (sizeof($this->mapping) * $inc); $i < $j; $i+=$inc) {
            $stmt->setInt($i + 1, $webPage->getId());
            $stmt->setString($i + 2, $lang);
        }
        
        $rs = $stmt->executeQuery();
        
        $groups = new ArrayObject();
        
        while ($rs->next()) {
            $asset = $this->createAssetFromRecord($rs);

            if (!$groups->offsetExists($asset->GroupId)) {
                
                $group = new StructureGroup();
                $group->Id = $asset->GroupId;
                $group->Groupables = new ArrayObject();
                
                $groups->offsetSet($asset->GroupId, $group);
                
            }
            
            $groups->offsetGet($asset->GroupId)->Groupables[] = $asset;
        }
        return $group;
    }
    
    
    protected function createAssetFromRecord(ResultSet $rs) {
        
        $type = $rs->getString('asset_type');
        if (!isset($this->mapping[$type])) {
            throw new RuntimeException(
                'The ResultSet contain no information about the asset type.');
        }
        
        $mapping = $this->mapping[$type];
        
        $asset = new $mapping['class']();
        
        foreach ($this->baseMapping as $map) {
            $asset->{$map['property']} = $rs->get($map['column']);
        }
        
        foreach ($mapping['map'] as $map) {
            if (isset($map['property'])) {    
                $asset->{$map['property']} = $rs->get($map['alias']);
            }
        }
        
        return $asset;
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
?>
