<?php
/**
 * Base interface for classes that allow runtime configurations.
 * 
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
interface IConfigurable {
    
    /**
     * This constant is used to set the language property for a query.
     */
    const LANGUAGE = 'language';
    
    /**
     * This constant is used to the object status for a query
     */
    const STATUS = 'status';
	
	/**
	 * Returns a property value for the given <code>$name</code> or a 
	 * <code>null</code> value if it doesn't exist.
	 * 
	 * @param string $name The property name
	 * @return mixed The value or <code>null</code>
	 */
	public function getProperty($name);
	
	/**
	 * Sets a property <code>$value</code> under the given <code>$name</code>.
	 * 
	 * @param string $name The property name.
	 * @param mixed $value The property value. 
	 */
	public function setProperty($name, $value);
		
}
?>
