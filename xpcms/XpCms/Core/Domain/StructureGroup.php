<?php
/**
 * This class represents some kind of marker that says these objects belong to
 * same part/hierarchie in the application.
 *
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class StructureGroup extends DynamicPropertyObject {

    /**
     * Simple constructor that set's up the dynamic properties.
     */
    public function __construct() {
        parent::__construct(array(
                'Id' => array(
                        'name' => 'id', 'type' => 'integer', 'readonly' => true)
                 ));
    }
}
?>
