			<fieldset id="invoice" class="subform">			
				<legend><span class="number">1</span> Invoice</legend>
				<p>Please find copy of your vehicle rental invoice and your reservation number below.
				 You should quote this number when inquiring your rental with PRADO Down Under cars and trucks rental service.</p>
				 <p class="reservation">Reservation #: <%= $this->Page->RentalInvoice('reservation') %> </p>
				<table width="100%"  border="1" class="confirmation">
				  <tr>
				    <th scope="row" width="40%">Invoice #</th>
				    <td><%= $this->Page->RentalInvoice('invoice#') %></td>
				  </tr>				  
				  <tr>
				    <th scope="row">Invoice Date</th>
				    <td><com:TDateFormat Pattern="fulldate" /></td>
				  </tr>
				  <tr>
				    <th scope="row">Total Payable </th>
				    <td class="price">$<%= $this->Page->RentalQuote('Total') %></td>
				  </tr>
				  <tr>
				    <th scope="row"> Includes GST of </th>
				    <td  class="price">$<%= $this->Page->RentalQuote('GST') %></td>
				  </tr>
				</table>				
				<h3>Contact Details</h3>
				<table width="100%"  border="1" class="confirmation">
				  <tr>
				    <th scope="row" width="40%" >Driver's First Name </th>
				    <td><%= $this->Page->RentalWizard->Step4->FirstName->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Driver's Last Name </th>
				    <td><%= $this->Page->RentalWizard->Step4->LastName->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Contact Email</th>
				    <td><%= $this->Page->RentalWizard->Step4->Email->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Home Phone</th>
				    <td><%= $this->Page->RentalWizard->Step4->HomePhone->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Work Phone </th>
				    <td><%= $this->Page->RentalWizard->Step4->WorkPhone->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Mobile Phone</th>
				    <td><%= $this->Page->RentalWizard->Step4->MobilePhone->Text %></td>
				  </tr>
				</table>					

					
				<h3>Payment Details</h3>
				<table width="100%"  border="1" class="confirmation">
				  <tr>
				    <th scope="row" width="40%" >Card Type</th>
				    <td><%= $this->Page->RentalWizard->Step4->CardType->SelectedItem->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Credit Card Number </th>
				    <td><%= $this->Page->RentalWizard->Step4->CardNumber->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Expiry Date </th>
				    <td>
				    	<%= $this->Page->RentalWizard->Step4->ExpiryMonth->SelectedItem->Text %> /
				    	<%= $this->Page->RentalWizard->Step4->ExpiryYear->SelectedItem->Text %>
				    </td>
				  </tr>
				  <tr>
				    <th scope="row">Card Holder's Name </th>
				    <td><%= $this->Page->RentalWizard->Step4->CardFirstName->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Middle Initial </th>
				    <td><%= $this->Page->RentalWizard->Step4->CardInitial->Text %></td>
				  </tr>
				  <tr>
				    <th scope="row">Last Name </th>
				    <td><%= $this->Page->RentalWizard->Step4->CardLastName->Text %></td>
				  </tr>
				</table>				
				
				<p>To print this page, click the following link below or choose <tt>Print</tt> from your file menu.</p>
				<p class="printpage"><a href="javascript:window.print()">Print this page</a></p>
				<p>Please confirm that all the details are accurrate. If you have any questions or comments, please call 1800 xxx xxx.</p>
			</fieldset>