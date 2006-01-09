<%@Page Master="BackendLayoutPage" %>
<com:TContent ID="MainBodyContent">
  <ul class="groupList">
  <com:TRepeater ID="GroupList" OnItemCreated="Page.GroupList_OnItemCreated">
  <prop:ItemTemplate>
    <li class="groupListItem">
      <div class="groupListItemBorder">
        <div class="objectToolBar">
          <com:TImageButton ID="NewCollectionButton" ImageUrl="/media/ico/collection-add.png" />
        </div>
        <com:TLinkButton ID="GroupLink" />
      </div>
      <com:WebCollectionList ID="CollectionList" />
    </li>
  </prop:ItemTemplate>
  </com:TRepeater>
  </ul>
</com:TContent>