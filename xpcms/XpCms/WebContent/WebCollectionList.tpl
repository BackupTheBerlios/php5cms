<ul class="collectionList">
  <com:TRepeater ID="CollectionList" OnItemCreated="Page.CollectionList_OnItemCreated">
    <prop:ItemTemplate>
      <li class="collectionListItem">
        <div class="collectionListItemLine">
        <com:TLinkButton ID="CollectionLink" OnCommand="Page.OnWebCollectionClicked" />
        <span class="objectToolBar">
          <com:TImageButton ID="NewCollectionButton" ImageUrl="/media/ico/collection-add.png" />
          <com:TImageButton ID="NewWebPageButton" ImageUrl="/media/ico/collection-delete.png" />
          <com:TImageButton ID="EditCollectionButton" 
                            ImageUrl="/media/ico/collection-edit.png" 
                            OnClick="Page.OnEditWebCollectionClicked" />
        </span>
        </div>
        <com:TPlaceHolder ID="ChildCollections" />
      </li>
    </prop:ItemTemplate>
  </com:TRepeater>
</ul>
