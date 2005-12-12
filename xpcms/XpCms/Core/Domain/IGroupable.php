<?php
/**
 * This interface represents objects that belong to a structure group. This
 * means all objects in one group are viewable in the same context.
 * 
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
interface IGroupable {
	
	/**
	 * This method returns the <code>StructureGroup</code>-object that describes
	 * the relationship from this to other objects.
	 * 
	 * @return StructureGroup The meta structure group
	 */
	public function getStructureGroup();
}
?>
