<ul class="collectionList">
  <com:TRepeater ID="CollectionList" OnItemCreated="Page.CollectionList_OnItemCreated">
    <prop:ItemTemplate>
      <li class="collectionListItem">
        <div class="collectionListItemLine">
          <div class="objectToolBar">
            <com:TImageButton ID="NewCollectionButton" ImageUrl="/media/ico/collection-add.png" />
            <com:TImageButton ID="NewWebPageButton" ImageUrl="/media/ico/collection-delete.png" />
            <com:TImageButton ID="EditCollectionButton" 
                              ImageUrl="/media/ico/collection-edit.png" 
                              OnClick="Page.OnEditWebCollectionClicked" />
          </div>
          <com:TLinkButton ID="CollectionLink" OnCommand="Page.OnWebCollectionClicked" />
        </div>
        <com:TPlaceHolder ID="ChildCollections" />
      </li>
    </prop:ItemTemplate>
  </com:TRepeater>
</ul>
