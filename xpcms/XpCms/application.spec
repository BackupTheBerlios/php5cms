<?xml version="1.0" encoding="utf-8"?>
<application ID="XpCMS" state="debug">

	<request default="HomePage" format="get" />

	<session enabled="true" />

  <cache enabled="true" />

  <parameter name="PersistenceType">Sql</parameter>
  <parameter name="PersistenceParam">mysql://xpcms:xpcms@localhost/xpcms</parameter>

  <alias name="XpCms" path="." />

  <using namespace="XpCms.Pages" />
  <using namespace="XpCms.Core.Domain" />
  <using namespace="XpCms.Core.Persistence" />
  
  <module ID="WebContent" class="WebContentModule">
    
  </module>

  <module ID="User" class="DataModule">
    <using namespace="BlogApp.UserModule" />
    <!--
    <secured page="EditPage" />
    -->
    <parameter name="AllowNewAccount">true</parameter>
  </module>

  <module ID="Blog" class="DataModule">
    <using namespace="BlogApp.BlogModule" />
    <!--
    <secured page="EditPage" />
    <secured page="NewPage" />
    -->
    <parameter name="AllowAllDelete">true</parameter>
  </module>

</application>