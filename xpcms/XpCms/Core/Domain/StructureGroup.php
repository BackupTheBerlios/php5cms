<?php
/**
 * This class represents some kind of marker that says these objects belong to
 * same part/hierarchie in the application.
 *
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.4 $
 */
class StructureGroup extends DynamicPropertyObject {
	
	/**
	 * The unique identifier for this structure group.
	 * 
	 * @var integer $id
	 */
	protected $id;
    
    /**
     * The human readable alias name of this <code>StructureGroup</code> or
     * <code>null</code> if it is not set.
     * 
     * @var string $alias
     */
    protected $alias = null;
	
	/**
	 * The current language for the group description.
	 * 
	 * @var string $language
	 */
	protected $language;
	
	/**
	 * The human readable name of this group.
	 * 
	 * @var string $name
	 */
	protected $name;
	
	/**
	 * A small text that describes the reason of this group.
	 * 
	 * @var string $description
	 */
	protected $description;

    /**
     * Simple constructor that set's up the dynamic properties.
     */
    public function __construct() {
        parent::__construct(array(
             'Id' => array(
            	  		'name' => 'id', 'type' => 'integer', 'readonly' => true),
             'Alias'       => array('name' => 'alias', 'type' => 'string'),
             'Language'    => array('name' => 'language', 'type' => 'string'),
             'Name'        => array('name' => 'Name', 'type' => 'string'),
             'Description' => array('name' => 'description', 'type' => 'string')
             ));
    }
}
?>
