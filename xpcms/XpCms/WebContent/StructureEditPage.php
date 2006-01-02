<?php
using('System.Web.Services');

/**
 * Edit page for <code>WebCollection</code>s and WebPage</code>s.
 * 
 * This page displays the edit mask for a <code>WebCollection</code>-object and 
 * its <code>WebPage</code>.
 * 
 * @package XpCms.WebContent
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $ 
 */
class StructureEditPage extends TCallbackPage {

    
    /**
     * Loads the requested <code>WebCollection</code>-object and binds the 
     * values to the edit controls.
     * 
     * @param TEventParameter $param
     */
    public function onLoad($param) {
        parent::onLoad($param);
        
        if (!$this->IsPostBack) {
            $alias = $this->Request->getParameter('alias');
            
            $webColl = $this->Module->getWebCollection($alias);
            $webPage = $webColl->getWebPage();
            
            $content = $this->MainBodyContent; 
            
            $content->WebCollectionAlias->Text = $webColl->getAlias();
            $content->WebPageTitle->Text       = $webPage->getName();
            $content->WebPageDescription->Text = $webPage->getDescription();
            
            $assets = $this->Module->getWebPageAssets($webPage);
            
            $content->AssetGroups->setDataSource($assets);
            $content->AssetGroups->dataBind();
        }
    }
    
    public function AssetGroups_OnItemCreated($sender, $param) {
        
    }
    
    public function checkCollectionAlias($sender, $param) {
       if($this->IsCallback)
       {
           $result = $sender->renderResult(array('hello', 'world'));
           $this->CallbackResponse->data = $result;
       }
    }
}

// A component that can do XMLHTTPRequest
class ButtonWithCallBack extends TButton implements ICallbackEventHandler
{
    function onInit($param)
    {   
        //set the onclick attribute with js
        $this->appendJavascriptEvent('onclick', $this->getCallbackScript());
 
        //register this as a candidate for call back
        $this->Page->registerCallbackCandidate($this);
       
        parent::onInit($param);
    }
    
    //get the call back javascript
    protected function getCallbackScript()
    {
        $js = "javascript:%s; return false;";
        
        $args = $this->getID();
        $callback = $this->Page->getCallbackReference(
                            $this, $args, 'ButtonWithCallBack_UpdateUI');            
            
        return sprintf($js, $callback);
    }   
 
    //handle the call back event
    public function raiseCallbackEvent($param)
    {
        $fp = fopen('/tmp/file', 'aw');
        fwrite($fp, time() . ": hello " . $param . "\n");
        fclose($fp);
        return "hello {$param}";
    }
    
    
    //add the call back javascript handler
    public function onPreRender($param)
    {       
        $script = '
            function ButtonWithCallBack_UpdateUI(result)
            {
                alert(result);
            }
        ';
        
        $this->Page->registerEndScript(get_class($this),$script);
        
        parent::onPreRender($param);
    }
}
?>
