<?php
/**
 * This is the base interface for all mappers that handle the persistence for 
 * <code>StructureGroup</code>-objects.
 * 
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
interface IStructureGroupMapper extends IConfigurable {
	
	/**
	 * This method returns the <code>StructureGroup</code>-object for the given
	 * <code>$id</code>. If this id doesn't exist it returns <code>null</code>
	 * 
	 * @param integer $id The id of the <code>StructureGroup</code>.
	 * @return mixed The <code>StructureGroup</code>-object or <code>null</code>
	 */
	public function findById($id);	
	
}
?>
