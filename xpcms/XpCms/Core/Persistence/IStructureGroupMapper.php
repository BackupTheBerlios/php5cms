<?php
/**
 * This is the base interface for all mappers that handle the persistence for 
 * <code>StructureGroup</code>-objects.
 * 
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
interface IStructureGroupMapper extends IConfigurable {
	
	/**
	 * This method returns the <code>StructureGroup</code>-object for the given
	 * <code>$id</code>. If this id doesn't exist it returns <code>null</code>
	 * 
	 * @param integer $id The id of the <code>StructureGroup</code>.
     * @param string $locale The language of the requested assets.
	 * @return mixed The <code>StructureGroup</code>-object or <code>null</code>
	 */
	public function findById($id, $locale);	
    
    /**
     * This method returns a <code>ArrayAccess</code>-object that contains all
     * sub <code>StructureGroup</code>s that are under the group for the given
     * <code>$alias</code>.
     * 
     * @param string $alias The alias name for the parent 
     *                      <code>StructureGroup</code>.
     * @param string $locale The language of the requested assets.
     * @return ArrayAccess An <code>ArrayAccess</code>-object with all sub
     *                     <code>StructureGroup</code>s.
     */
    public function findSubGroupsByAlias($alias, $locale);
	
}
?>
