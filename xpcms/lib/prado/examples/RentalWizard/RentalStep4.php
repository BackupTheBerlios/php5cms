<?php
/**
 * TWizard example's Car and Truck rentals.
 * @author $Author: nexd $
 * @version $Id: RentalStep4.php,v 1.1 2006/01/02 19:01:43 nexd Exp $
 * @package prado.examples
 */

/**
 * Step 4, contact details.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Sat Jan 29 21:55:13 EST 2005
 * @package prado.examples
 */
class RentalStep4 extends TControl
{

	function onLoad($param)
	{
		parent::onLoad($param);

		if(!$this->Page->IsPostBack)
		{
			$year = intval(@date('Y')); $years = array();
			for($i=0; $i<6; $i++) $years[] = $year+$i;			
			$this->ExpiryYear->setDataSource($years);
			$this->ExpiryYear->dataBind();
		}
	}
}

?>