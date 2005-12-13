<?php
/**
 * @package XpCms.Core.Domain
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.3 $
 */
abstract class DynamicPropertyObject implements ArrayAccess {

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

    /**
     * This magic function is used to emulate bean like getter and setter
     * methods for the properties of this object.
     *
     * @param string $method The called method name.
     * @param array $args An array with all given arguments.
     * @return mixed The return value of a getter method.
     *
     * @throws Exception If the given property name doesn't exist.
     */
	public function __call($method, $args) {
		if (preg_match('/^(get|set)(\w+)/', $method, $match)
			&& isset($this->dynPropNames[$match[2]])) {

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

    /**
     * This magic function emulates Dot NET like access on properties.
     *
     * @param string $name The name of the property.
     * @return mixed The value of the property.
     *
     * @throws Exception If the given property name doesn't exist.
     */
	public function __get($name) {
		// Does this property exist?
		if (!isset($this->dynPropNames[$name])) {
			throw new Exception("Undefined property $name.");
		}
		// Get the real name
		$property = $this->dynPropNames[$name]['name'];

		return $this->$property;
	}

    /**
     * This magic function allows Dot NET like access on properties.
     *
     * @param string $name The property name.
     * @param mixed $value The new property value.
     *
     * @throws Exception If the given property name doesn't exist.
     */
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
	
	
	public function offsetGet($name) {
		return $this->$name;
	}
	
	public function offsetSet($name, $value) {
		$this->$name = $value;
	}
	
	public function offsetExists($name) {
		return isset($this->$name);
	}
	
	public function offsetUnset($name) {
		if ($this->offsetExists($name)) {
			$this->$name = null;
		}
	}

}
?>
