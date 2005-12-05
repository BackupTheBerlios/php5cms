<?php
/**
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
abstract class DynamicPropertyObject {
	
	/**
	 * This array contains the valid dynPropNames for the concrete 
	 * implementation.
	 * 
	 * @var array $dynPropNames
	 */
	private $dynPropNames;

	/**
	 * This constructor takes an array as parameter. This array contains all
	 * dynamic property names for the concrete implementation.
	 * 
	 * @param array $dynPropNames
	 */
	public function __construct($dynPropNames) {
		$this->dynPropNames = $dynPropNames;
	}
	
	
	public function __call($method, $args) {
		if (preg_match('/^(get|set)(\w+)/', $method, $match)
			&& isset($this->dynPropNames[$match[2]])) {
			
			$name = $this->dynPropNames[$match[2]]['name'];
			if ($match[1] == 'get') {
				return $this->$match[2];
			} else {
				$this->$match[2] = $args[0];
			}
		} else {
			throw new Exception(sprintf(
				"Invalid method call %s::%s()", get_class($this), $method));
		}
	}
	
	public function __get($name) {
		// Does this property exist?
		if (!isset($this->dynPropNames[$name])) {
			throw new Exception("Undefined property $name.");
		}
		// Get the real name
		$property = $this->dynPropNames[$name]['name'];
		
		return $this->$property;
	}
	
	public function __set($name, $value) {
		// Does this property exist?
		if (!isset($this->dynPropNames[$name])) {
			throw new Exception("Undefined property $name.");
		}
		
		// Get the real name
		$property = $this->dynPropNames[$name]['name'];
		
		// Is it not set or not readonly
		if (!isset($this->dynPropNames[$name]['readonly'])
			|| !isset($this->$property) || is_null($this->$property)) {
			
			// If it is a simple type cast it
			switch ($this->dynPropNames[$name]['type']) {
				case 'bool':
				case 'boolean':
				case 'integer':
				case 'int':
				case 'float':
				case 'real':
				case 'double':
				case 'string':
					settype($value, $this->dynPropNames[$name]['type']);
					break; 
			}
				
			$this->$property = $value;
		}
	}
	
}
?>
