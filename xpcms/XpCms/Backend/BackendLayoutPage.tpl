<html>
  <com:THead>
    <title>Backend</title>
    <link href="/media/xpcms.css" rel="stylesheet" />
  </com:THead>
  <body>
    <h1 style="margin:5px 20px 0px 0px;text-align:right;">XpCms</h1>
    <com:TForm>
    <com:ModuleMenu ID="Dummy" />
    <div id="mainContent">
      <div class="contentBoxHeaderLeft"></div>
      <div class="contentBoxHeaderRight"></div>
      <div class="contentBoxHeaderCenter"></div>
      <div class="contentBoxBody">
        <com:TContentPlaceHolder ID="MainBodyContent" />      
      </div>
      <div id="contentBoxStatusLeft"></div>
      <div id="contentBoxStatusRight"></div>
      <div id="contentBoxStatusCenter"></div>
    </div>
    <div id="mainContentHelp">
      <div class="contentBoxHeaderLeft"></div>
      <div class="contentBoxHeaderRight"></div>
      <div class="contentBoxHeaderCenter"><com:TTranslate>Help</com:TTranslate></div>
      <div class="contentBoxBody"><com:TLiteral ID="MainContentHelp" /></div>
    </div>
    </com:TForm>
  </body>
</html>