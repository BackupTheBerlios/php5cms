<!-- field 1 -->
<fieldset class="subform" title="Vehicle Category" >
	<legend><span class="number">1</span> Vehicle Category</legend>
	<p>Please select the rental vehicle category.</p>
	<div class="element" title="Select vehicle category">
		<com:TFormLabel For="VehicleCat" Text="Vehicle Category:" />
		<com:TDropDownList ID="VehicleCat" AutoPostBack="true"
			OnSelectionChanged="changeVehicleCat" />
	</div>
</fieldset>

<!-- field 2 -->
<fieldset class="subform" title="Driver's Age">
	<legend><span class="number">2</span> Driver's Age</legend>
	<p>Please select the age group of the driver on the rental date.</p>
	<div class="element" title="Select driver's age group">
		<com:TFormLabel For="DriverAgeGroup" Text="Driver's Age Group:" />
		<com:TDropDownList ID="DriverAgeGroup">
			<com:TListItem Text="25+" Value="25+" />
			<com:TListItem Text="21-24" Value="21-24" />
		</com:TDropDownList>
	</div>
</fieldset>

<!-- field 3 -->
<fieldset class="subform" id="datetime" title="Date & Time Information" >
	<legend><span class="number">3</span> Date &amp; Time Information</legend>
	<p>Please select the dates and times for pick up and return of your rental vehicle.</p>
	<div class="element" title="Pick up date (mm/dd/yyyy)" >
		<com:TFormLabel For="PickUpDate" Text="Pick Up Date:" EncodeText="false"/>
		<span class="required">*</span>
		<com:TDatePicker ID="PickUpDate" DateFormat="%m/%d/%Y" /> 
		<tt>mm/dd/yyyy</tt>
		<com:TRequiredFieldValidator
			ControlToValidate="PickUpDate"
			Display="None"
			Anchor="datetime"
			ControlCssClass="requiredInput"
			ErrorMessage="the pick up date is not valid."
			/>
		<com:TRangeValidator 
			ControlToValidate="PickUpDate"
			ValueType="Date"
			Display="None"
			MinValue="#@date('m/d/Y')"
			MaxValue="#@date('m/d/Y',strtotime('+2 year'))"
			DateFormat="%m/%d/%Y"
			Anchor="datetime"
			ControlCssClass="requiredInput2"
			ErrorMessage="#sprintf('the pick up date is before today, select a date between %s and %s.', @date('m/d/Y'), @date('m/d/Y',strtotime('+2 year')))" 
			/>
	</div>
	<div class="element" title="Pick up time">
		<com:TFormLabel For="PickUpTime" Text="Pick Up Time:" />
		<com:TDropDownList ID="PickUpTime" />
	</div>
	<div class="element" title="Return date (mm/dd/yyyy)" >
		<com:TFormLabel For="ReturnDate" Text="Return Date:" EncodeText="false"/> 
		<span class="required">*</span>
		<com:TDatePicker ID="ReturnDate" DateFormat="%m/%d/%Y" />
		<tt>mm/dd/yyyy</tt>
		<com:TRequiredFieldValidator
			ControlToValidate="ReturnDate"
			Display="None"
			Anchor="datetime"
			ControlCssClass="requiredInput"
			ErrorMessage="the return date is not valid."
			/>
		<com:TCompareValidator
			ControlToValidate="ReturnDate"
			ControlToCompare="PickUpDate"
			Display="None"
			ValueType="Date"
			Operator="GreaterThanEqual"
			DateFormat="%m/%d/%Y"
			Anchor="datetime"
			ControlCssClass="requiredInput2"
			ErrorMessage="the return date is before the pick up date."
			/>
	</div>
	<div class="element" title="Return time" >
		<com:TFormLabel For="ReturnTime" Text="Return Time:" />
		<com:TDropDownList ID="ReturnTime" />
	</div>
</fieldset>	

<!-- field 4 -->
<fieldset class="subform" id="locationinfo" title="Location Information">
	<legend><span class="number">4</span> Location Information</legend>
	<p>Please select the locations for pick up and return of your rental vehicle.</p>
	<div class="element" title="Pick up location">
		<com:TFormLabel For="PickUpLocation" Text="Pick Up Location:" />					
		<span class="required">*</span>
		<com:TDropDownList ID="PickUpLocation" />
		<com:TRangeValidator 
			ControlToValidate="PickUpLocation"
			ValueType="Integer"
			MinValue="2"
			MaxValue="183"
			Anchor="locationinfo"
			ControlCssClass="requiredInput"
			ErrorMessage="the selected pick up location is invalid" 
			Display="None"
			/>
	</div>
	<div class="element" title="Return location">
		<com:TFormLabel For="ReturnLocation" Text="Return Location:" />
		<com:TDropDownList ID="ReturnLocation" />
	</div>
</fieldset>

<!-- field 5 -->
<com:TPanel ID="FrequentFlyerPanel">
<fieldset class="subform" title="Frequent Flyer" >
	<legend><span class="number">5</span> Frequent Flyer</legend>
	<p>Please enter your frequent flyer number where applicable.</p>
	<div class="element" title="Frequent Flyer number">
		<com:TFormLabel For="FrequentFlyer" Text="Frequent Flyer #:" />
		<com:TTextBox ID="FrequentFlyer" />
	</div>
</fieldset>
</com:TPanel>