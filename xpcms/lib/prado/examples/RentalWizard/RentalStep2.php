<?php
/**
 * TWizard example's Car and Truck rentals.
 * @author $Author: nexd $
 * @version $Id: RentalStep2.php,v 1.1 2006/01/02 19:01:43 nexd Exp $
 * @package prado.examples
 */

/**
 * Step 2, vehicle selection.
 *
 * @author Xiang Wei Zhuo <weizhuo[at]gmail.com>
 * @version v1.0, last update on Sat Jan 29 21:55:13 EST 2005
 * @package prado.examples
 */
class RentalStep2 extends TControl
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
			$step1 = $this->Page->RentalWizard->Step1;

			//set the default vehicle category and types
			$cat = $step1->VehicleCat->Items[0]->Text;
			$this->setVehicleTypes($cat);	
			$type = $this->VehicleType->Items[0]->Text;
			$this->setVehicleList($cat, $type);
		}
	}

	/**
	 * Set the vehicle type, ID="VehicleType".
	 * @param string vehicle category
	 */
	public function setVehicleTypes($cat)
	{
		$rentals = $this->Module->getVehicleList();

		$types = $rentals->getTypes($cat);
		$this->VehicleType->setDataSource($types);
		$this->VehicleType->dataBind();
	}

	/**
	 * Set the list of vehicles for a particular category and class/type.
	 * @param string vehicle rental category
	 * @param string vehicle class
	 */
	public function setVehicleList($cat, $type) 
	{
		$rentals = $this->Module->getVehicleList();
		$vehicles = $rentals->getVehicles($cat, $type);
		$this->VehicleList->setDataSource($vehicles);
		$this->VehicleList->dataBind();
	}


	/**
	 * Change the vehicle class/type. PostBack from ID="VehicleType".
	 */
	function changeVehicleType($sender, $param) 
	{
		$step1 = $this->Page->RentalWizard->Step1;
		$cat = $step1->VehicleCat->SelectedItem->Text;
		$type = $this->VehicleType->SelectedItem->Text;

		//update the vehicle list
		$this->setVehicleList($cat, $type);
	}
}

?>