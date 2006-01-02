<!-- field 1 -->
<fieldset class="subform" title="Vehicle Type">
	<legend><span class="number">1</span> Vehicle Type</legend>
	<p>Please select the type of vehicle you wish to rent.</p>
	<div class="element" title="Select vehicle type">
		<com:TFormLabel For="VehicleType" Text="Vehicle Type:" />
		<com:TDropDownList ID="VehicleType"  AutoPostBack="true" 
			OnSelectionChanged="changeVehicleType" />
	</div>
</fieldset>		

<!-- field 2 -->
<fieldset class="subform" >
	<legend id="selectVehicle"><span class="number">2</span> Vehicle Class <span class="simpleRequired">*</span></legend>				
	<com:RentalVehiclesList ID="VehicleList" />
	<com:TRequiredListValidator 
		ControlToValidate="VehicleList"
		MinSelection="1"
		Display="None"
		Anchor="selectVehicle"
		ErrorMessage="a vehicle has not been selected" />
</fieldset>

<!-- field 3 -->
<fieldset class="subform" title="Reduce Your Liability">
	<legend><span class="number">3</span> Reduce Your Liability</legend>
	<p>Standard Cover is included in your rental fee, and indemnifies the Hirer and Authorised Drivers for damage to the vehicle and Third Party Property, subject to the Terms and Conditions.</p>
	<p>Premium Protection is strongly recommended to reduce your liability in the event of loss or damage for a small daily fee.</p>
	<table width="95%" align="center" title="Include premium protection cover">
		<tr><td><com:TCheckBox ID="PremiumProtect" /></td>
		<td>
		<com:TFormLabel For="PremiumProtect" CssClass="liability">
			<strong>Premium Protection</strong> includes Standard Cover and provides the maximum reduction of both your Liability Fee and Single Vehicle Accident Liability Fee.
		</com:TFormLabel>
		</td></tr>
	</table>
</fieldset>

<!-- field 4 -->
<com:TPanel ID="OptionsPanel">
<fieldset class="subform" title="Options">
	<legend><span class="number">4</span> Options</legend>
	<p>Please make your choice of available options by selecting the check box and entering a quantity required where applicable.</p>
	<table width="95%" align="center">
		<tr><th width="5%">&nbsp;</th>
			<th width="80%">Option</th><th width="5%">Qty</th><th width="5%">Rate</th>
			<th width="5%">&nbsp;</th>
		</tr>
		<tr title="Include baby seats">
			<td><com:TCheckBox ID="BabySeat" /></td>
			<td><com:TFormLabel For="BabySeat">Baby Seat</com:TFormLabel></td>
			<td><com:TTextBox ID="BabySeatQty" Text="1" Style="width:3em;margin-right:1em;" />
			<td class="price">$5.00</td>
			<td nowrap="nowrap"><strong>/day</strong></td>
		</tr>
	</table>
</fieldset>
</com:TPanel>