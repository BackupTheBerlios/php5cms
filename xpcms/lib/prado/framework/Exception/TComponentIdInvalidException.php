<?php
/**
 * TComponentIdInvalidException class file.
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
 * @version $Revision: 1.1 $  $Date: 2005/12/05 17:24:38 $
 * @package System.Exception
 */
 
/**
 * TComponentIdInvalidException class
 *
 * TComponentIdInvalidException is raised when the framework
 * detects acomponent has invalid ID.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.1 $  $Date: 2005/12/05 17:24:38 $
 * @package System.Exception
 */
class TComponentIdInvalidException extends TException
{
	/**
	 * Constructor.
	 * @param string the component type
	 * @param string the invalid ID
	 */
	function __construct($comType,$id)
	{
		parent::__construct("Component '$comType' is set with an invalid ID '$id'.");
	}
}
?>