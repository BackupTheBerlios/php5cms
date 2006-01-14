<?php
/*
 * Created on 29.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
abstract class AbstractAsset extends DynamicPropertyObject {
    
    protected $id;
    
    protected $collectionId;
    
    protected $language;
    
    protected $alias;
    
    protected $description;
    
    protected $status;
    
    protected $groupId;
    
    protected $position;
    
    
    public function __construct($properties) {
        parent::__construct(array_merge($properties, array(
            'Id' => array(
                    'name' => 'id', 'type' => 'integer', 'readonly' => true),
            'CollectionId' => array(
                    'name' => 'collectionId', 'type' => 'integer'),
            'Language'    => array('name' => 'language', 'type' => 'string'),
            'Alias'       => array('name' => 'alias', 'type' => 'string'),
            'Description' => array('name' => 'description', 'type' => 'string'),
            'Status'      => array('name' => 'status', 'type' => 'integer'),
            'GroupId'     => array('name' => 'groupId', 'type' => 'integer'),
            'Position'    => array('name' => 'position', 'type' => 'float'))));
        
        
    } 
    
}
?>
