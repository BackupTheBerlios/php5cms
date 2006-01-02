<!-- field 1 -->
<fieldset class="subform">
	<legend><span class="number">1</span> Price Details</legend>
	<p>Please find an estimate of the cost of your vehicle rental below.</p>
	<table>
		<tr><th width="85%">Base Rate:</th><th width="15%" class="price">Price</th></tr>
		<tr>
			<td><%= $this->Page->VehicleDetails('Name') %> for 
				<%= $this->Page->RentalQuote('Days') %> day(s) @ 
				$<%= $this->Page->RentalQuote('BaseRate') %>/day
			</td>
			<td class="price">$<%= $this->Page->RentalQuote('BasePrice') %></td>
		</tr>
		<tr><th colspan="2">Kilometre Restrictions:</th></tr>
		<tr><td colspan="2">This rental includes <%= $this->Page->RentalQuote('MaxKM') %> kilometres free per day with additional kilometres charged 
					at the rate of $<%= $this->Page->RentalQuote('KMRate') %>/km.</td></tr>
		<tr><th colspan="2">Options:</th></tr>
		<tr>
			<td>Standard Cover (this is included in your base rate).</td>
			<td class="price">$0.00</td>
		</tr>
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
</fieldset>