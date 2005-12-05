<?php
/**
 * TApplicationInheritanceException class file.
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
 * TApplicationInheritanceException class
 *
 * TApplicationInheritanceException is raised when an application
 * instance is created but it is not a TApplication descendant.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.1 $  $Date: 2005/12/05 17:24:38 $
 * @package System.Exception
 */
class TApplicationInheritanceException extends TException
{
	/**
	 * Constructor.
	 * @param string the class name
	 */
	function __construct($className)
	{
		parent::__construct("Application class '$className' must be TApplication or its descendant class.");
	}
}

?>