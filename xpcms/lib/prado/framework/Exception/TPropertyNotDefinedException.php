<?php
/**
 * TPropertyNotDefinedException class file.
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
 * TPropertyNotDefinedException class
 *
 * TPropertyNotDefinedException is raised when the framework
 * detects the usage of some undefined component property.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:31:36 $
 * @package System.Exception
 */
class TPropertyNotDefinedException extends TException
{
	/**
	 * Constructor.
	 * @param string the component type
	 * @param string the undefined property name
	 */
	function __construct($comType,$propName)
	{
		parent::__construct("Property '$comType.$propName' is not defined.");
	}
}
?>