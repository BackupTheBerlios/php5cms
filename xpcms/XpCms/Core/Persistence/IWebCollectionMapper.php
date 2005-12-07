<?php

/**
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
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
	public function findById($id, $loadPage = true);

	/**
	 * This method finds all <code>WebCollection</code>s that belong to the
	 * given <code>StructureGroup</code>. It also loads the associated 
	 * <code>WebPage</code>s by default. You can remove this feature if you set
	 * the second parameter <code>$loadPage</code> to <code>false</code>
	 * 
	 * @param StructureGroup $group The group to search for.
	 * @param boolean $loadPage Should this method load the associated web pages
	 *                          also? By default this is <code>true</code>.
	 * @return ArrayObject This container holds all top level collections. 
	 */
	public function findByGroup(StructureGroup $group, $loadPage = true);
	
	/**
	 * This method inserts or updates the given <code>WebCollection</code> with
	 * all its dependencies in the storage. If the <code>WebCollection</code>
	 * doesn't contain a <code>WebPage</code> an empty dummy will be created 
	 * also.
	 * 
	 * @param WebCollection $collection The new or changed WebCollection.
	 * @see WebPageMapper::save() 
	 */
	public function save(WebCollection $collection);
}
?>