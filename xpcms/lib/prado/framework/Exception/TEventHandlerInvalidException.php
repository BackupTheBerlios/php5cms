<?php
/**
 * TEventHandlerInvalidException class file.
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
 * TEventHandlerInvalidException class
 *
 * TEventHandlerInvalidException is raised when the framework
 * detects an event is attached by an undefined handler method.
 *
 * Namespace: Exception
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:31:36 $
 * @package System.Exception
 */
class TEventHandlerInvalidException extends TException
{
	/**
	 * Constructor.
	 * @param string the component type
	 * @param string the event name
	 * @param string the event handler
	 */
	function __construct($comType,$eventName,$handler)
	{
		parent::__construct("Event '$comType.$eventName' is attached with an undefined handler '$handler'.");
	}
}

?>