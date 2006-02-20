<?php
/*
 * Created on 07.01.2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetLinkView extends AbstractAssetView {

    public function onLoad($param) {
        parent::onLoad($param);
        
        $this->AssetLinkTitle->Text         = $this->asset->Title;
        $this->AssetLinkObject->NavigateUrl = $this->asset->Url;
        $this->AssetLinkObject->Text        = $this->asset->Url;
    }    
}
?>
