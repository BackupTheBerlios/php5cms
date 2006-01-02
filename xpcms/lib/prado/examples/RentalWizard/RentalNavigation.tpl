<!-- 1st step button -->
<com:TLinkButton 
	CssClass="#$this->Parent->getActiveClass('stepguide step1',0)"
	CausesValidation="false"
	Enabled="#$this->Parent->isLinkEnabled(0)"
	title="Step 1 car rental pickup &amp; return locations &amp; dates" 
	CommandName="jumpto" CommandParameter="0" >
		<span class="num">1</span>
		<span class="title">Pick Up &amp; Return</span>
		<span class="description">Location, Date &amp; Time</span>
</com:TLinkButton>

<!-- 2nd step button -->
<com:TLinkButton 
	CssClass="#$this->Parent->getActiveClass('stepguide step2',1)"
	Enabled="#$this->Parent->isLinkEnabled(1)"
	CausesValidation="#$this->Page->RentalWizard->ActiveStepIndex == 0"
	title="Step 2 select vehicle type and class for quote" 
	CommandName="jumpto" CommandParameter="1" >
		<span class="num">2</span>
		<span class="title">Select Vehicle</span>
		<span class="description">Vehicle Class</span>
</com:TLinkButton>

<!-- 3rd step button -->
<com:TLinkButton 
	CssClass="#$this->Parent->getActiveClass('stepguide step3',2)"
	Enabled="#$this->Parent->isLinkEnabled(2)"
	CausesValidation="#$this->Page->RentalWizard->ActiveStepIndex == 1"
	title="Step 3 Vehicle rental quote price details" 
	CommandName="jumpto" CommandParameter="2" >
		<span class="num">3</span>
		<span class="title">Quote</span>
		<span class="description">Price Details</span>
</com:TLinkButton>

<!-- 4th step button -->
<com:TLinkButton 
	CssClass="#$this->Parent->getActiveClass('stepguide step4',3)"
	Enabled="#$this->Parent->isLinkEnabled(3)"
	CausesValidation="#$this->Page->RentalWizard->ActiveStepIndex == 2"
	title="Step 4 contact details &amp; payment information"
	CommandName="jumpto" CommandParameter="3" >
		<span class="num">4</span>
		<span class="title">Contact Details</span>
		<span class="description">Payment Information</span>
</com:TLinkButton>	

<!-- 5th step button -->
<com:TLinkButton 
	CssClass="#$this->Parent->getActiveClass('stepguide step5',4)"
	Enabled="#$this->Parent->isLinkEnabled(4)"
	CausesValidation="#$this->Page->RentalWizard->ActiveStepIndex == 3"
	title="Step 5 booking confirmation reservation number"
	CommandName="jumpto" CommandParameter="4" >
		<span class="num">5</span>
		<span class="title">Confirmation</span>
		<span class="description">Reservation Number</span>
</com:TLinkButton>	
<span class="stepquote">QUOTE</span>
<span class="stepbook">BOOK</span>