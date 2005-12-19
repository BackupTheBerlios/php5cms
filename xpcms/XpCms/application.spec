<?xml version="1.0" encoding="utf-8"?>
<application ID="XpCMS" state="debug">

	<request class="XpCmsRequest" default="HomePage" format="ext_path" />

	<session enabled="true" />

  <cache enabled="true" />

  <parameter name="alias">
    <alias name="backend_menu" value="backend" />
    <alias name="website_structure" value="web_site" />
  </parameter>
  
  <parameter name="persistence">
    <persistence name="content" type="Sql" dsn="mysql://xpcms:xpcms@localhost/xpcms" />
  </parameter>
  
  <parameter name="language">
    <standard lang="de_DE" />
    <available lang="de_DE,en_GB" />
  </parameter>
  
  <using namespace="System.Web" />
  <using namespace="System.Web.UI" />
  <using namespace="System.Web.UI.WebControls" />

  <alias name="XpCms" path="." />

  <using namespace="XpCms.Common" />
  <using namespace="XpCms.Pages" />
  <using namespace="XpCms.Core.Domain" />
  <using namespace="XpCms.Core.Persistence" />
  <using namespace="XpCms.Core.Service" />
  
  <module ID="WebContent" class="WebContentModule">
    <using namespace="XpCms.WebContent" />
    <using namespace="XpCms.Backend" />
  </module>
  
  <module ID="Backend" class="BackendModule">
    <using namespace="XpCms.Backend" />  
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