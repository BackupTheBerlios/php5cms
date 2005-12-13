<?php
/**
 * An implementation of this interface is used to retrieve <code>WebPage</code>s
 * form the database.
 *
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
interface IWebPageMapper extends IConfigurable {
	
	/**
	 * This method returns a <code>WebPage</code>-object for the given id. If
	 * there is no record for <code>$id</code> it will return <code>null</code>.
	 * 
	 * @param integer $id The <code>WebPage</code> identifier.
	 * @return mixed A <code>WebPage</code>-instance or <code>null</code>. 
	 */
	public function findById($id);

	/**
	 * This method returns a <code>WebPage</code>-object for the given
	 * <code>$collection</code> or <code>null</code> if it doesn't exist.
	 *
	 * @param WebCollection $collection The web collection instance
	 * @return mixed A WebCollection object or null.
	 */
	public function findByCollection(WebCollection $collection);

	/**
	 * This method returns a <code>WebPage</code>-object for the given
	 * collection <code>$colId</code> or <code>null</code> if it doesn't exist.
	 *
	 * @param integer $colId The id of the parent collection.
	 * @return mixed The WebCollection object or null.
	 */
	public function findByCollectionId($colId);

    /**
     * This method inserts or updates the given <code>WebPage</code>-object in
     * the storage. Before a <code>WebPage</code> could be saved it must be
     * assigned to a <code>WebCollection</code>.
     *
     * @param WebPage $webPage The <code>WebPage</code>-object to store.
     *
     * @throws Exception If the given <code>WebPage</code> doesn't belong to a
     *                   <code>WebCollection</code>.
     */
    public function save(WebPage $webPage);
    
    /**
     * This method removes the given <code>WebPage</code>-object from the 
     * storage. 
     * 
     * @param WebPage $webPage The <code>WebPage</code> that should be removed.
     * 
     * @throws Exception If the given <code>WebPage</code> doesn't exist.
     * 					 If the given <code>WebPage</code> is the last one that
     *                   belongs to a <code>WebCollection</code>.
     */
    public function delete(WebPage $webPage);
    
    /**
     * This method removes all <code>WebPage</code>-objects from the storage 
     * that belong to the given <code>WebCollection</code>.
     * 
     * @param WebCollection $collection The context <code>WebCollection</code>.
     * 
     * @throws Exception If the given <code>WebCollection</code> doesn't exist.
     */
    public function deleteByCollection(WebCollection $collection);
}
?>
