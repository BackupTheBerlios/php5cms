<%@Page Master="BackendLayoutPage" %>
<com:TContent ID="MainBodyContent">
  <ul class="groupList">
  <com:TRepeater ID="GroupList" OnItemCreated="Page.GroupList_OnItemCreated">
  <prop:ItemTemplate>
    <li class="groupListItem">
      <div class="groupListItemBorder">
        <com:TLinkButton ID="GroupLink" />
        <span class="objectToolBar">
          <com:TImageButton ID="NewCollectionButton" ImageUrl="/media/ico/collection-add.png" />
        </span>
      </div>
      <com:WebCollectionList ID="CollectionList" />
    </li>
  </prop:ItemTemplate>
  </com:TRepeater>
  </ul>
</com:TContent>