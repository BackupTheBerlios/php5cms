<?php
/**
 * TWizard example's Car and Truck rentals.
 * @author $Author: nexd $
 * @version $Id: RentalStep3.php,v 1.1 2006/01/02 19:01:43 nexd Exp $
 * @package prado.examples
 */

/**
 * Step 3, show the quote.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Sat Jan 29 21:55:13 EST 2005
 * @package prado.examples
 */
class RentalStep3 extends TControl
{

	public function calculateQuote()
	{
		$step1 = $this->Page->RentalWizard->Step1;
		$step2 = $this->Page->RentalWizard->Step2;

		$vehicle = $step2->VehicleList->SelectedItem->Text;		
		$data['PickUpDate'] = $step1->PickUpDate->Text;
		$data['PickUpTime'] = $step1->PickUpTime->SelectedValue;
		$data['ReturnDate'] = $step1->ReturnDate->Text;
		$data['ReturnTime'] = $step1->ReturnTime->SelectedValue;
		$data['PremiumProtect'] = $step2->PremiumProtect->Checked;	
		$data['BabySeat'] = $step2->BabySeat->Checked;
		$data['BabySeatQty'] = $step2->BabySeatQty->Text;

		return $this->Module->calculateQuote($vehicle, $data);	
	}

}

?>