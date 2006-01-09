<?xml version="1.0" encoding="utf-8"?>
<application ID="XpCMS" state="debug">

	<request class="XpCmsRequest" default="HomePage" format="ext_path" />

	<session enabled="true" />

  <cache enabled="true" />

  <vsmanager enabled="true" />
  
  	<globalization class="XpCmsGlobalization"
                 defaultCharset="ISO-8859-1" 
                 defaultCulture="en-GB">
    <translation type="XLIFF" source="XpCms/messages" autosave="true" />
  </globalization>
      
  
  <parameter name="alias">
    <alias name="backend_menu" value="backend" />
    <alias name="website_structure" value="web_site" />
    <alias name="CompleteWebSiteStructure" value="complete_web_site_structure" />
    <alias name="WebPageAssetGroups" value="web_page_asset_groups" />
  </parameter>
  
  <parameter name="persistence">
    <persistence name="content" type="Creole" dsn="mysql://xpcms:xpcms@localhost/xpcms" />
  </parameter>
  
  <parameter name="language">
    <standard lang="de_DE" />
    <available lang="de_DE,en_GB" />
  </parameter>
  
  <using namespace="System.I18N" />
  <using namespace="System.Web" />
  <using namespace="System.Web.UI" />
  <using namespace="System.Web.UI.WebControls" />
  
  <alias name="ThirdParty" path="../lib/ThirdParty" />

  <alias name="XpCms" path="." />

  <using namespace="XpCms.Common" />
  <using namespace="XpCms.Pages" />
  <using namespace="XpCms.Core.Domain" />
  <using namespace="XpCms.Core.Persistence" />
  <using namespace="XpCms.Core.Service" />
  <using namespace="XpCms.Util" />
  
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

</application>