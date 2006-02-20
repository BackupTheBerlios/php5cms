<?php
/*
 * Created on 07.01.2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetImageView extends AbstractAssetView {
    
    
    public function onLoad($param) {
        parent::onLoad($param);

        $this->AssetImageTitle->Text = $this->asset->Title;
        $this->AssetImageObject->ImageUrl = $this->asset->Url;
    }
}
?>
