<com:TPanel 
	CssClass="interary" 
	title="Your Interary"
	Visible="#$this->Page->RentalWizard->ActiveStepIndex < 5">

	<h4>Your Interary</h4>
	
	<com:TPanel 
		CssClass="item" 
		Style="border: 0 none" 
		Visible="#$this->Page->RentalWizard->ActiveStepIndex == 0" >

		<p>As you progress through this process a summary of your vehicle rental information will be displayed.</p>
		<p>Changes to your rental choices can be made at any time during this process.</p>				

	</com:TPanel>
	
	<!-- pickup and return details -->
	<com:TPanel 
		CssClass="item"
		Visible="#$this->Page->RentalWizard->ActiveStepIndex > 0" >

		<table>
			<tr><th>Driver's Age:</th>
				<td><%= $this->Page->RentalWizard->Step1->DriverAgeGroup->SelectedValue %></td>
			</tr>
			<tr><th>Pick Up:</th>
				<td>
				<%= $this->Page->RentalWizard->Step1->PickUpTime->SelectedItem->Text %> <br />
				<com:TDateFormat Pattern="fulldate">
					<%= $this->Page->RentalWizard->Step1->PickUpDate->Text %>
				</com:TDateFormat><br />
				<%= $this->Page->RentalWizard->Step1->PickUpLocation->SelectedItem->Text %>
				</td>
			</tr>
			<tr><th>Return:</th>
				<td>
				<%= $this->Page->RentalWizard->Step1->ReturnTime->SelectedItem->Text %> <br />
				<com:TDateFormat Pattern="fulldate">
					<%= $this->Page->RentalWizard->Step1->ReturnDate->Text %>
				</com:TDateFormat><br />
				<% $location = $this->Page->RentalWizard->Step1->PickUpLocation->SelectedItem;
				   $return = $this->Page->RentalWizard->Step1->ReturnLocation->SelectedItem;
					if($return->Value < 2){ echo $location->Text; }else{ echo $return->Text; }
				%>
				</td>
			</tr>
		</table>

	</com:TPanel>


	<!-- rental type pic -->
	<com:TPanel 
		CssClass="item"
		Visible="#$this->Page->RentalWizard->ActiveStepIndex <= 1"	>
		
		<p class="image" ><com:TImage ID="VehicleCatImage" ImageUrl="media/RentalWizard/Car.jpg" AlternateText="Car rental" /></p>
	
	</com:TPanel>
	

	<!-- selected rental vehicle details -->
	<com:TPanel 
		CssClass="item" 
		Visible="#$this->Page->RentalWizard->ActiveStepIndex > 1" >
		<table>
			<tr><th>Vehicle:</th>
				<td><%= $this->Page->VehicleDetails('Name') %></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><img src="media/RentalWizard/cars/<%= $this->Page->VehicleDetails('Image') %>" Alt="Car Image" 
						title="<%= $this->Page->VehicleDetails('Name') %>" />
				</td>
			<tr>
				<th>Class:</th><td><%= $this->Page->VehicleDetails('Type') %></td>
			</tr>
			<tr>
				<th>Description:</th>
				<td><%= $this->Page->VehicleDetails('Description') %></td>
			</tr>
		</table>
	</com:TPanel>

	<!-- rental cost details -->
	<com:TPanel 
		CssClass="item" 
		Visible="#$this->Page->RentalWizard->ActiveStepIndex > 2" >
		<table>
			<tr><th>Base Rate:</th><th class="price">Price</th></tr>
			<tr>
				<td>Economy Hyundai Getz (similar) Manual & Air for 
					<%= $this->Page->RentalQuote('Days') %> day(s) @ 
					$<%= $this->Page->RentalQuote('BaseRate') %>/day
				</td>
				<td class="price">$<%= $this->Page->RentalQuote('BasePrice') %></td>
			</tr>
			<tr><th colspan="2">Kilometre Restrictions:</th></tr>
			<tr><td colspan="2">This rental includes <%= $this->Page->RentalQuote('MaxKM') %> kilometres free per day with additional kilometres charged 
						at the rate of $<%= $this->Page->RentalQuote('KMRate') %>/km.</td></tr>
			<com:TPlaceHolder
				Visible="#$this->Page->RentalWizard->Step2->PremiumProtect->Checked || $this->Page->RentalWizard->Step2->BabySeat->Checked" >
			<tr><th colspan="2">Options:</th></tr>
			</com:TPlaceHolder>
			<com:TPlaceHolder 
				Visible="#$this->Page->RentalWizard->Step2->PremiumProtect->Checked" >
			<tr>
				<td>Premium Protection Cover for <%= $this->Page->RentalQuote('Days') %> day(s) 
					@ $<%= $this->Page->RentalQuote('CoverRate') %>/day.</td>
				<td class="price">$<%= $this->Page->RentalQuote('Cover') %></td>
			</tr>
			</com:TPlaceHolder>
			<com:TPlaceHolder 
				Visible="#$this->Page->RentalWizard->Step2->BabySeat->Checked" >
			<tr>
				<td><%= $this->Page->RentalWizard->Step2->BabySeatQty->Text %> *
					Baby Seat for <%= $this->Page->RentalQuote('Days') %> day(s) @ $5.00/day
					(max charge $33.00 each).
				</td>
				<td class="price">$<%= $this->Page->RentalQuote('BabySeat') %></td>
			</tr>
			</com:TPlaceHolder>
			<tr><th colspan="2">Taxes &amp; Fees:</th></tr>
			<tr>
				<td>Vehicle Registration Recovery Fee</td>
				<td class="price">$<%= $this->Page->RentalQuote('Duty1') %></td>
			</tr>		
			<tr>
				<td>Stamp Duty Recovery Fee</td>
				<td class="price">$<%= $this->Page->RentalQuote('Duty2') %></td>
			</tr>										
			<tr>
				<th class="price">Total Price:</th>
				<th class="price">$<%= $this->Page->RentalQuote('Total') %></th>
			</tr>		
			<tr>
				<td class="price">Includes GST of:</td>
				<td class="price">$<%= $this->Page->RentalQuote('GST') %></td>
			</tr>							
		</table>	
	</com:TPanel>

</com:TPanel>