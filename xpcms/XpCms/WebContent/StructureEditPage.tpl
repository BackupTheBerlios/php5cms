<%@Page Master="BackendLayoutPage" %>
<com:TContent ID="MainBodyContent">
  <div class="mainToolBar">
    <com:TImageButton ID="SaveWebCollection" ImageUrl="/media/ico/save.png" OnClick="Page.onClickWebCollectionSave" />
  </div>
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
    <com:TRepeater ID="AssetGroups" OnItemCreated="Page.AssetGroups_OnItemCreated">
      <prop:ItemTemplate>
        <fieldset>
          <legend><com:TLiteral ID="AssetFieldSetLegend" /></legend>
          <com:TRepeater ID="AssetObjects" OnItemCreated="Page.AssetObjects_OnItemCreated">
            <prop:ItemTemplate>
            </prop:ItemTemplate>
          </com:TRepeater>
        </fieldset>
      </prop:ItemTemplate>
    </com:TRepeater>
</com:TContent>