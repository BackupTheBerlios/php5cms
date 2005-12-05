<?php
/**
 * This interface marks a domain object as an object that belongs to a special
 * group.
 * 
 * @package XpCms.Core
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
interface IGroupable {
	
	/**
	 * 
	 */
	function getGroup();
}
?>
