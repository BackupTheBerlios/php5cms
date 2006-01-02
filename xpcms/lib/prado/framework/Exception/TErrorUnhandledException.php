<?php
/**
 * TErrorUnhandledException class file.
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
 * TErrorUnhandledException class
 *
 * TErrorUnhandledException is raised when an error is reported but no
 * suitable error page is responsible for that.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:31:36 $
 * @package System.Exception
 */
class TErrorUnhandledException extends TException
{
	/**
	 * Constructor.
	 * @param string the error code
	 * @param string the error message
	 */
	function __construct($code,$msg)
	{
		parent::__construct("Unhandled error: ($code) $msg.");
	}
}

?>