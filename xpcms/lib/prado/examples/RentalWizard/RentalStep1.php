<?php
/**
 * TWizard example's Car and Truck rentals.
 * @author $Author: nexd $
 * @version $Id: RentalStep1.php,v 1.1 2006/01/02 19:01:43 nexd Exp $
 * @package prado.examples
 */

/**
 * Step 1, pickup and return details.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Sat Jan 29 21:55:13 EST 2005
 * @package prado.examples
 */
class RentalStep1 extends TControl
{
	/**
	 * Override the parent implementation. Load some default data.
	 */
	function onLoad($param)
	{
		parent::onLoad($param);

		$this->dataBind();

		//on loading the page for the first time, 
		//initialize the drop down lists
		if(!$this->Page->IsPostBack)
		{
			//echo 'init';
			
			//init the pickup date
			$date = @date('m/d/Y');
			$this->PickUpDate->setText($date);
			
			//init the return date
			$date = @date('m/d/Y',strtotime('+1 day'));
			$this->ReturnDate->setText($date);
			
			//init the pick up time
			$time = $this->Module->getTimeList();
			$this->PickUpTime->setDataSource($time);
			$this->PickUpTime->dataBind();
			$this->PickUpTime->setSelectedValue(36);

			//init return time
			$this->ReturnTime->setDataSource($time);
			$this->ReturnTime->dataBind();
			$this->ReturnTime->setSelectedValue(68);

			//init the pick up location
			$locations = $this->Module->getLocationList();
			array_unshift($locations, '---------------------------------');
			array_unshift($locations, 'Select a Pick Up Location');
			$this->PickUpLocation->setDataSource($locations);
			$this->PickUpLocation->dataBind();			
			
			//init the return location
			array_shift($locations); array_shift($locations);
			array_unshift($locations, '---------------------------------');
			array_unshift($locations, 'Same as Pick Up Location');
			$this->ReturnLocation->setDataSource($locations);
			$this->ReturnLocation->dataBind();
			
			//init the vehicle category
			$categories = $this->Module->getVehicleList()->getCategories();
			$this->VehicleCat->setDataSource($categories);
			$this->VehicleCat->dataBind();

		}

	}

	/**
	 * Change the vehicle category. PostBack from ID="VehicleCat".
	 */
	function changeVehicleCat($sender, $param)
	{
		$cat = $this->VehicleCat->SelectedItem->Text;
		$step2 = $this->Page->RentalWizard->Step2;
		$interary = $this->Page->Interary;


		//disable the frequent flyer for commercial rentals
		//also disable the baby set options
		$this->FrequentFlyerPanel->setVisible($cat=='Car');
		$step2->OptionsPanel->setVisible($cat=='Car');

		//set the appropriate images
		$interary->VehicleCatImage->setImageUrl("media/RentalWizard/$cat.jpg");
		$interary->VehicleCatImage->setAlternateText("$cat Rental");
		
		//update the vehile types.
		$step2->setVehicleTypes($cat);

		//update the vehicle list
		$type = $step2->VehicleType->Items[0]->Text;
		$step2->setVehicleList($cat, $type);
	}

}

?>