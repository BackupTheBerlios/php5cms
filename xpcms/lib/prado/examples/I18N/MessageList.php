<?php
/**
 * MessageList file.
 * @author $Author: nexd $
 * @version $Id: MessageList.php,v 1.1 2005/12/05 17:24:38 nexd Exp $
 * @package prado.examples
 */


/**
 * MessageList class.
 * 
 * For a particular catalogue, display all the messages in the catalogue.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Tue Dec 28 17:56:02 EST 2004
 * @package prado.examples
 */
class MessageList extends TPage 
{
	/**
	 * Get the list of messages for a particular catalogue.
	 * @param TEventParameter event parameter.
	 */	
	function onLoad($param)
	{
		$settings = $this->Module->getSettings();

		$source = MessageSource::factory($settings['type'], 
										 $settings['source']);
		$source->setCulture($settings['culture']);
		$source->load($settings['catalogue']);
		$messages = $source->read();
		$messages = $messages[key($messages)];
		$this->MessageList->setDataSource($messages);
		$this->dataBind();		
		
		parent::onLoad($param);
	}
}
?>