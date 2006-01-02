<%@Page Master="BackendLayoutPage" %>
<com:TContent ID="MainBodyContent">
  <fieldset>
    <legend><com:TTranslate>Website Properties</com:TTranslate></legend>
      
      <div class="formLine">
        <com:TFormLabel For="WebCollectionAlias"><com:TTranslate>Alias:</com:TTranslate></com:TFormLabel>
        <com:TTextBox ID="WebCollectionAlias" CssClass="TextField" Width="562" />
      </div>
      
      <div class="formLine">
        <com:TFormLabel For="WebPageTitle"><com:TTranslate>Title:</com:TTranslate></com:TFormLabel>
        <com:TTextBox ID="WebPageTitle" CssClass="TextField" Width="562" />
      </div>
            
      <div class="formLine">
        <com:TFormLabel For="WebPageDescription"><com:TTranslate>Description:</com:TTranslate></com:TFormLabel>
        <com:THtmlArea ID="WebPageDescription" Width="560" Height="200" />
      </div>
  </fieldset>
<!--
<com:ButtonWithCallBack ID="Button1" Text="Do XMLHTTPRequest" />
-->
  <fieldset>
    <legend><com:TTranslate>Website Assets</com:TTranslate></legend>
    <com:TRepeater ID="AssetGroups" OnItemCreated="Page.AssetGroups_OnItemCreated">
      <prop:ItemTemplate>
        <div class="formLine">
          <com:TTextBox Text="#$this->Parent->Data->Name" />
          Manuel
        </div>
      </prop:ItemTemplate>
    </com:TRepeater>
  </fieldset>
</com:TContent>