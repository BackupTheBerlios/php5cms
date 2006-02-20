<?php
/*
 * Created on 08.01.2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AbstractAssetView extends AbstractAssetControl {
    
    public function onLoad($param) {
        parent::onLoad($param);
        
        $this->AssetAlias->Text = $this->asset->Alias;
    }
    
}
?>
