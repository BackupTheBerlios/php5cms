<div>
  <com:TRepeater ID="BackendMenu">
    <prop:ItemTemplate>
      [<a href="<%= $this->Parent->Data->getURL() %>"
          title="<%= $this->Parent->Data->getWebPage()->Description %>">
      <%= $this->Parent->Data->getWebPage()->Name %>
      </a>]
    </prop:ItemTemplate>
  </com:TRepeater>
</div>