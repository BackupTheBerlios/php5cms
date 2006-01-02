<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<com:THead Title="PRADO Down Under Car and Truck Rental - a TWizard Component Example">
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="media/RentalWizard/site.css" />
	<link rel="stylesheet" type="text/css" href="media/RentalWizard/print.css" media="print" />
</com:THead>

<body>

<h1>A TWizard Component Example</h1>
<p class="info">
This example demonstrates the advantage of splitting a large and complex form 
into smaller "step-by-step guided" forms using PRADO's TWizard component.
The example is a prototype for an online "Cars and Trucks Rental" quotation and
booking application. The targeted audience is located in Australia. For this 
example, only temporary data will be store by sever, no data will be stored permanently. 
</p>
<com:TForm ID="Form">

	<com:TWizard ID="RentalWizard"
		CssClass="wizard" 
		OnNextCommand="beforeNextStep" 
		OnJumpToCommand="beforeNextStep" 
		OnStepChanged="stepChanged" >
		
		<h2>PRADO Down Under Car and Truck Rental</h2>
		<com:TWizardTemplate Type="NavigationSideBar" CssClass="navigationSteps">			
			<com:RentalNavigation />
		</com:TWizardTemplate>		

		<!-- start wizard forms -->
		<fieldset class="form <% if($this->Page->RentalWizard->ActiveStepIndex == 5) echo 'final'; %>">		
			<legend><%= $this->Page->RentalWizard->ActiveStep->Title %></legend>
			<com:TValidationSummary 
				CssClass="validator" 
				AutoUpdate="False"
				HeaderText="<p>Your rental details could not be processed because</p>"/>
			
		<com:TWizardStep Title="Pick Up &amp; Return" CssClass="step">
		<!-- 1st step form -->
			<com:RentalStep1 ID="Step1" />			
		</com:TWizardStep>
		
		<com:TWizardStep Title="Select Vehicle" CssClass="step">
		<!-- 2nd step form -->
			<com:RentalStep2 ID="Step2" />			
		</com:TWizardStep>	

		<com:TWizardStep Title="Quote" CssClass="step">
		<!-- 3rd step form -->
			<com:RentalStep3 ID="Step3" />			
		</com:TWizardStep>
		
		<com:TWizardStep Title="Contact Details" CssClass="step">
		<!-- 4th step form -->
			<com:RentalStep4 ID="Step4" />					
		</com:TWizardStep>

		<com:TWizardStep Title="Confirmation" CssClass="step">
		<!-- 5th step form -->
			<com:RentalStep5 ID="Step5" />
		</com:TWizardStep>

		<com:TWizardStep Type="Final">
			<p>This completes the TWizard example. 
			<a href="wizard.php" title="see the example again">Would you like to see the example once more?</a></p>
		</com:TWizardStep>

		<!-- templates -->
			<com:TWizardTemplate Type="NavigationStart" CssClass="navigation">							
					<com:TButton Text="Continue >" CssClass="button" CommandName="next" title="Continue to next step"/>
			</com:TWizardTemplate>

			<com:TWizardTemplate Type="NavigationStep" CssClass="navigation">
				<com:TButton Text="< Back" CssClass="button" CausesValidation="false" CommandName="previous" title="Return to previous step"/>
				<com:TButton Text="Continue >" CssClass="button" CommandName="next" title="Continue to next step" />
			</com:TWizardTemplate>

			<com:TWizardTemplate Type="NavigationFinish" CssClass="navigation">	
				<com:TButton Text="< Back" CssClass="button" CausesValidation="false" CommandName="previous" title="Return to previous step"/>					
				<com:TButton Text="Finish" CssClass="button" CommandName="finish" title="Completion" />
			</com:TWizardTemplate>

	</fieldset>
	<!-- end wizard forms -->

	<!-- start interary list -->
		<com:InteraryList ID="Interary" />
	<!-- end interary list -->

	</com:TWizard>

</com:TForm> 

<p class="copyright">Copyrights 2005 Xiang Wei Zhuo. All right reserved.</p>

<div class="w3c" style="margin-top:2em; text-align:center">
<a href="http://validator.w3.org/check?uri=referer">
		Validate XHTML 1.0 (almost)
</a>
</div>

</body>
</html>
