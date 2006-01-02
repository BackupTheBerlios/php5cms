<?php
/**
 * TStatements class file
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
 * @version $Revision: 1.2 $  $Date: 2006/01/02 17:47:54 $
 * @package System.Web.UI.WebControls
 */

/**
 * TStatements class
 *
 * TStatements executes a set of PHP statements and renders the display
 * generated by the statements. The execution happens during rendering stage.
 * You can set the statements via the property <b>Statements</b>. 
 * You should also specify the context object by <b>Context</b> property 
 * which is used as the object in which the statements is evaluated. 
 * If the <b>Context</b> property is not set, the TStatements component 
 * itself will be assumed as the context.
 *
 * Namespace: System.Web.UI.WebControls
 *
 * Properties
 * - <b>Statements</b>, string
 *   <br>Gets or sets the PHP statements to be executed.
 *   Any display generated by the statements will be inserted at the place of the component.
 * - <b>Context</b>, TComponent, default=$this
 *   <br>Gets or sets the context object used for evaluating the expression.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version v1.0, last update on 2004/08/13 21:44:52
 * @package System.Web.UI.WebControls
 */
class TStatements extends TControl
{
	private $context=null;
	private $statements='';

	/**
	 * Overrides parent implementation to disable body addition.
	 * @param mixed the object to be added
	 * @return boolean
	 */
	public function allowBody($object)
	{
		return false;
	}

	/**
	 * @return string the statements to be executed
	 */
	public function getStatements()
	{
		return $this->statements;
	}

	/**
	 * Sets the statements of the TStatements
	 * @param string the statements to be set
	 */
	public function setStatements($value)
	{
		$this->statements=$value;
	}

	/**
	 * @return TComponent the context object of the TStatements
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * Sets the context object of the TStatements
	 * @param TComponent the context object
	 */
	public function setContext(TComponent $value)
	{
		$this->context=$value;
	}

	/**
	 * Renders the evaluation result of the expression.
	 * @return string the rendering result
	 */
	public function render()
	{
		$statements=$this->getStatements();
		$context=$this->getContext();
		if(is_null($context))
			$context=$this;
		if(strlen($statements))
			return $context->evaluateStatements($statements);
		else
			return '';
	}
}

?>
