<?php
/**
 * An implementation of this interface is used to retrieve <code>WebPage</code>s
 * form the database.
 *
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
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
}
?>
