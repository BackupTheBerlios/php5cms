<?php
/**
 * TPropertySetterInvalidException class file.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the BSD License.
 *
 * Copyright(c) 2004 by Qiang Xue. All rights reserved.
 *
 * To contact the author write to {@link mailto:qiang.xue@gmail.com Qiang Xue}
 * The latest version of PRADO can be obtained from:
 * {@link http://prado.sourceforge.net/}
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:31:36 $
 * @package System.Exception
 */
 
/**
 * TPropertySetterInvalidException class
 *
 * TPropertySetterInvalidException is raised when the framework
 * detects that a property is defined with an invalid setter method.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:31:36 $
 * @package System.Exception
 */
class TPropertySetterInvalidException extends TException
{
	/**
	 * Constructor.
	 * @param string the component type
	 * @param string the property name
	 * @param string the setter method
	 */
	function __construct($comType,$propName,$setter)
	{
		parent::__construct("Property '$comType.$propName' is defined with an invalid setter method '$setter'.");
	}
}

?>