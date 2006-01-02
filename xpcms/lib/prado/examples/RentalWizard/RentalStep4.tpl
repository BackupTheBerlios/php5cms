<!-- field 1 -->
<fieldset class="subform" id="termsconditions" title="Terms and Conditions">
	<legend><span class="number">1</span> Terms and Conditions</legend>
	<p>It is important that you understand theTerms and Conditions before completing your reservation.</p>
	<p>Please indicate that you accept the rental terms and conditions by clicking the check box.</p>
	<p style="text-align: right; margin-right:2em;"><a href="#">View Terms and Conditions.</a></p>
	<div class="element" title="Accept terms and conditions">
		<com:TCheckBox ID="AcceptTerms" />
		<com:TFormLabel CssClass="liability" For="AcceptTerms">
			<strong>I accept the rental terms and conditions.</strong>
			<span class="simpleRequired">*</span>
		</com:TFormLabel>
		<com:TRequiredFieldValidator 
			ControlToValidate="AcceptTerms"
			Anchor="termsconditions"
			Display="None"						
			ErrorMessage="you have not indicated acceptance of the terms and conditions"
		/>
	</div>
</fieldset>

<!-- field 2 -->
<fieldset class="subform" id="driverinfo" title="Driver Information">
	<legend><span class="number">2</span> Driver Information</legend>
	<p>Please enter the driver's first and last name.</p>
	<div class="element" title="Driver's first name">
		<com:TFormLabel For="FirstName">Driver's First Name:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="FirstName" Style="width: 17em" />
		<com:TRequiredFieldValidator
			ControlToValidate="FirstName"
			Display="None"
			Anchor="driverinfo"
			ControlCssClass="requiredInput"
			ErrorMessage="the driver's first name is required" />
	</div>
	<div class="element" title="Driver's last name">
		<com:TFormLabel For="LastName">Driver's Last Name:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="LastName" Style="width: 17em" />
		<com:TRequiredFieldValidator
			ControlToValidate="LastName"
			Display="None"
			Anchor="driverinfo"
			ControlCssClass="requiredInput"
			ErrorMessage="the driver's last name is required" />					
	</div>
</fieldset>	

<!-- field 3 -->
<fieldset class="subform" id="contactdetails" title="Contact Details">
	<legend><span class="number">3</span> Contact Details</legend>
	<p>Please enter the driver's contact details. <strong>A direct phone number is mandatory.</strong> Please enter either the home or work number including the Area Code.</p>
	<div class="element" title="Email address">
		<com:TFormLabel For="Email">Contact Email:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="Email" Style="width: 17em" />
		<com:TEmailAddressValidator
			ControlToValidate="Email"
			Display="None"
			Anchor="contactdetails"
			ControlCssClass="requiredInput"
			ErrorMessage="a valid email address is required" />					
		<com:TRequiredFieldValidator
			ControlToValidate="Email"
			Display="None"
			Anchor="contactdetails"
			ControlCssClass="requiredInput2"
			ErrorMessage="a valid email address is required" />
	</div>
	<div class="element" title="Home phone number">
		<com:TFormLabel For="HomePhone">Home Phone:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="HomePhone" />
		<com:TRequiredFieldValidator
			ControlToValidate="HomePhone"
			Display="None"
			Anchor="contactdetails"
			ControlCssClass="requiredInput"
			ErrorMessage="a home phone number is required" />
	</div>
	<div class="element" title="Work phone number">
		<com:TFormLabel For="WorkPhone">Work Phone:</com:TFormLabel>
		<com:TTextBox ID="WorkPhone" />
	</div>
	<div class="element" title="Mobile phone number">
		<com:TFormLabel For="MobilePhone">Mobile Phone:</com:TFormLabel>
		<com:TTextBox ID="MobilePhone" />
	</div>
	<p>If travelling, please enter mobile number.</p>
</fieldset>	

<!-- field 4 -->
<fieldset id="paymentdetails" class="subform">
	<legend><span class="number">4</span> Payment Details</legend>
	<p>Credit Card details are required to secure the booking. Full payment is required on collection of the vehicle. <strong>Important</strong> - the Credit Card holder must be present at the time of vehicle pick up and return and must hold a valid drivers license for the type of vehicle being rented. Deposits for Commercial Vehicle bookings may be debited prior to vehicle collection.</p>
	<div class="element" title="Credit card type">
		<com:TFormLabel For="CardType">Card Type:</com:TFormLabel>
		<span class="required">*</span>
		<com:TDropDownList ID="CardType">
			<com:TListItem Text="American Express" />
			<com:TListItem Text="Bank Card" />
			<com:TListItem Text="Dinners" />
			<com:TListItem Text="Mastercard" />
			<com:TListItem Text="Visa" />
		</com:TDropDownList>
	</div>
	<div class="element" title="Credit card number (xxxx xxxx xxxx xxxx)">
		<com:TFormLabel For="CardNumber">Credit Card Number:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="CardNumber" 
			Text="1111 2222 3333 4444"
			Style="width: 17em" />
		<com:TRegularExpressionValidator
			ControlToValidate="CardNumber"
			Display="None"
			Anchor="paymentdetails"
			ControlCssClass="requiredInput"
			RegularExpression="^\d{4}(\s|-)*\d{4}(\s|-)*\d{4}(\s|-)*\d{4}(\s)*$"
			ErrorMessage="the credit number doesn't seem to be valid" />							
		<com:TRequiredFieldValidator
			ControlToValidate="CardNumber"
			Display="None"
			Anchor="paymentdetails"
			ControlCssClass="requiredInput2"
			ErrorMessage="a valid credit card number is required" />			
	</div>
	<div class="element" title="Credit card expiry date">
		<com:TFormLabel For="ExpiryMonth">Expiry Date:</com:TFormLabel>
		<span class="required">*</span>
		<com:TDropDownList ID="ExpiryMonth">
			<com:TListItem Text="01" /><com:TListItem Text="02" /><com:TListItem Text="03" />
			<com:TListItem Text="04" /><com:TListItem Text="05" /><com:TListItem Text="06" />
			<com:TListItem Text="07" /><com:TListItem Text="08" /><com:TListItem Text="09" />
			<com:TListItem Text="10" /><com:TListItem Text="11" /><com:TListItem Text="12" />
		</com:TDropDownList>
		<com:TDropDownList ID="ExpiryYear" />
	</div>
	<div class="element" title="Credit card holder's first name">
		<com:TFormLabel For="CardFirstName">Card Holder's First Name:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="CardFirstName" Style="width: 17em"/>
		<com:TRequiredFieldValidator
			ControlToValidate="CardFirstName"
			Display="None"
			Anchor="paymentdetails"
			ControlCssClass="requiredInput"
			ErrorMessage="the credit card holder's first name was not entered" />
	</div>
	<div class="element" title="Credit card holder's middle initial">
		<com:TFormLabel For="CardInitial">Middle Initial:</com:TFormLabel>
		<com:TTextBox ID="CardInitial" />
	</div>
	<div class="element" title="Credit card holder's last name">
		<com:TFormLabel For="CardInitial">Last Name:</com:TFormLabel>
		<span class="required">*</span>
		<com:TTextBox ID="CardLastName" />
		<com:TRequiredFieldValidator
			ControlToValidate="CardLastName"
			Display="None"
			Anchor="paymentdetails"
			ControlCssClass="requiredInput"
			ErrorMessage="the credit card holder's last name was not entered" />					
	</div>				
	<p>Please enter a purchase order # or reference # if applicable.</p>
	<div class="element" title="Purchase order or reference number">
		<com:TFormLabel For="OrderRef">Purchase Order / Ref #:</com:TFormLabel>
		<com:TTextBox ID="OrderRef" />
	</div>								
</fieldset>				