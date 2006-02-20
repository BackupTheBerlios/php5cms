<?php
/*
 * Created on 07.01.2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetTextView extends AbstractAssetView {
    
    public function onLoad($param) {
        parent::onLoad($param);
        
        $this->AssetTextTitle->Text   = $this->asset->Title;
        $this->AssetTextContent->Text = $this->asset->Content; 
    }
}
?>
