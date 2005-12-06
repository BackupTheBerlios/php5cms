<?php
/**
 * An implementation of this interface is used to retrieve <code>WebPage</code>s
 * form the database.
 * 
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
interface IWebPageMapper extends IConfigurable {
	
	/**
	 * This method returns a <code>WebPage</code>-object for the given
	 * <code>$collection</code> or <code>null</code> if it doesn't exist.
	 * 
	 * @param WebCollection $collection The web collection instance
	 * @return mixed A WebCollection object or null.
	 */
	public function findByCollection(WebCollection $collection);
	
	/**
	 * This method returns a <code>WebPage</code>-objecz for the given 
	 * collection <code>$colId</code> or <code>null</code> if it doesn't exist.
	 * 
	 * @param integer $colId The id of the parent collection.
	 * @return mixed The WebCollection object or null.
	 */
	public function findByCollectionId($colId);
}
?>
