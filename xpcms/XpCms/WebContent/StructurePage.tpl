<%@Page Master="BackendLayoutPage" %>
<com:TContent ID="MainBodyContent">
Hello World
  <com:TRepeater ID="CollectionList">
    <prop:ItemTemplate>
    <div>
     [<a href="<%= $this->Parent->Data->getURL() %>"
          title="<%= $this->Parent->Data->getWebPage()->Description %>">
      <%= $this->Parent->Data->getWebPage()->Name %>
      </a>]
    </div>
    </prop:ItemTemplate>
  </com:TRepeater>
</com:TContent>