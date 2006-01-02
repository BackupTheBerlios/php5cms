<?php
/**
 * TWizard example's Car and Truck rentals.
 * @author $Author: nexd $
 * @version $Id: IndexPage.php,v 1.2 2006/01/02 17:06:35 nexd Exp $
 * @package prado.examples
 */

/**
 * The TWizard example page.
 * 
 * This demonstrates a complex TWizard. The scenario is a car and trucks
 * rental quotation and booking form.
 *
 * This example contains only very basic transistion logic, 
 * e.g. see beforeNextStep(). Most of the logic are to populate the 
 * form data and they can be found in the respective step classes.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Sat Jan 29 21:55:13 EST 2005
 * @package prado.examples
 */
class IndexPage extends TPage
{

	/**
	 * Get the selected vehicle details.
	 * @param string which specification detials
	 * @return string the specs. 
	 */
	public function VehicleDetails($spec)
	{
		$vehicle = $this->RentalWizard->Step2->VehicleList->SelectedItem->Text;		
		return $vehicle[$spec];
	}

	/**
	 * Get the current rental quote details.
	 * @param string which details.
	 * @return string quote detail 
	 */
	public function RentalQuote($spec)
	{		
		$quote = $this->getViewState('RentalQuote','');
		return $quote[$spec];
	}
	
	/**
	 * Get the invoice details.
	 */
	public function RentalInvoice($spec)
	{
		$invoice = $this->getViewState('RentalInvoice','');
		return $invoice[$spec];
	}
	
	/**
	 * Wizard page transition logic, here we can determine where the 
	 * previous page was, and also change where the page should transit to.
	 *
	 * Capture the step change commands. Cancel the step if validators fails.
	 * If the next step is "quote", step 2, calculate the quote.	 
	 */
	public function beforeNextStep($sender, $param)
	{
		if(!$this->IsValid)
		{
			$param->cancel = true;	
			return;
		}
		
		if($param->nextStepIndex == 2)
		{
			//calculate the quote, cancel the page transitition on error
			if($this->RentalWizard->Step3->calculateQuote())
			{
				//save the quote details to viewstate
				$this->setViewState('RentalQuote', $this->Module->getQuote());
				$this->setViewState('RentalInvoice', $this->Module->getInvoice());
			}
			else
				$param->cancel = true;
		}
	}

	/**
	 * When a transition is successfull, we need a dataBind to update
	 * all the data bindings in the template.
	 */
	public function stepChanged($sender, $param)
	{		
		$this->dataBind();		
	}
}
?>