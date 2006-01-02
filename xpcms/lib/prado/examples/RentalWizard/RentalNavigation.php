<?php

class RentalNavigation extends TControl
{
	/**
	 * Deterime the class attribute values for the navigational steps.
	 * @param string the current class attribute value
	 * @param int the step index to check
	 * @return string appends " active" to $class parameter if the 
	 * navigation step should be active.
	 */
	public function getActiveClass($class, $index)
	{
		$current = $this->Page->RentalWizard->ActiveStepIndex;
		if($index <= $current)
			return $class.' active';
		else
			return $class;
	}

	/**
	 * Determine if the navigational step link should be active or otherwise.
	 * @param int the navigation step index.
	 * @return boolean true if the link should be enabled, false otherwise. 
	 */
	public function isLinkEnabled($index)
	{
		$current = $this->Page->RentalWizard->ActiveStepIndex;
		return $index != $current && $index <= $current+1;
	}

}

?>