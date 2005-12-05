<?php

/**
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
interface IWebCollectionMapper extends IConfigurable {
	
	/**
	 * This method returns a single <code>IWebCollection</code> instance for
	 * the given <code>$id</code>. If no entry for the <code>$id</code> exists
	 * it returns <code>null</code>
	 * 
	 * @param integer $id The IWebCollection identifier.
	 * @param boolean $loadPage Load the associated web page.
	 * @return mixed An instance of <code>IWebCollection</code> or 
	 *               <code>null</code>.  
	 */
	function findById($id, $loadAll = false);
}
?>
