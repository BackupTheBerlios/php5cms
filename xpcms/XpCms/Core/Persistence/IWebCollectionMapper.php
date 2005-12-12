<?php

/**
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
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
	 * Before a <code>WebCollection</code> could be saved it must be added to 
	 * <code>StructureGroup</code>. If the collection has a parent object it
	 * will become the last child of this. Otherwise it will become the last top
	 * level collection.
	 * 
	 * @param WebCollection $collection The new or changed WebCollection.
	 * @see IWebPageMapper::save()
	 * @see IWebCollectionMapper::saveBefore()
	 * 
	 * @throws Exception If the given <code>WebCollection</code> doesn't belong
	 *                   to a <code>StructureGroup</code> or it doesn't exist.
	 *                   If the given <code>WebCollection</code> has a parent
	 *                   that doesn't exist.
	 */
	public function save(WebCollection $collection);
	
	/**
	 * 
	 */
	public function saveBefore(WebCollection $collection, WebCollection $ctx);
	
	/**
	 * This method deletes a <code>WebCollection</code> from the underlying 
	 * storage. If the given <code>WebCollection</code>-object contains other 
	 * <code>WebCollection</code>s or <code>WebPage</code>s it will also delete 
	 * them. 
	 * 
	 * Additional it removes the reference from the collection to its
	 * <code>StructureGroup</code>.
	 * 
	 * @param WebCollection $collection The collection that will be removed.
	 * @see IWebPageMapper::delete()
	 * 
	 * @throws Exception If the given <code>WebCollection</code> doesn't exist.
	 */
	public function delete(WebCollection $collection);
}
?>