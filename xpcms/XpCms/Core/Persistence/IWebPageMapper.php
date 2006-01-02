<?php
/**
 * An implementation of this interface is used to retrieve <code>WebPage</code>s
 * form the database.
 *
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.4 $
 */
interface IWebPageMapper extends IConfigurable {
	
	/**
	 * This method returns a <code>WebPage</code>-object for the given id. If
	 * there is no record for <code>$id</code> it will return <code>null</code>.
	 * 
	 * @param integer $id The <code>WebPage</code> identifier.
     * @param mixed $status The status of the <code>WebPage</code>-object
     *                      This is an optional parameter.
	 * @return mixed A <code>WebPage</code>-instance or <code>null</code>. 
	 */
	public function findById($id, $status = 1);

	/**
	 * This method returns a <code>WebPage</code>-object for the given
	 * collection <code>$colId</code> or <code>null</code> if it doesn't exist.
	 *
	 * @param integer $colId The id of the parent collection.
     * @param string $locale The language of the requested assets.
     * @param mixed $status The status of the <code>AbstractAsset</code>-objects
     *                      This is an optional parameter.
	 * @return mixed The WebCollection object or null.
	 */
	public function findByCollectionId($colId, $locale, $status = 1);

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
     * that belong to the given <code>WebCollection</code> identifier.
     * 
     * @param integer $colId The id of the parent collection.
     * 
     * @throws Exception If the given <code>WebCollection</code> doesn't exist.
     */
    public function deleteByCollectionId($colId);
}
?>
