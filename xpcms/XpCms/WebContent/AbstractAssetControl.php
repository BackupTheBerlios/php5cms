<?php
/*
 * Created on 07.01.2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AbstractAssetControl extends TWebControl {
    
    protected $asset;
    
    public function getAsset() {
        return $this->asset;
    }
    
    public function setAsset(AbstractAsset $asset) {
        $this->asset = $asset;
    }
    
    
}
?>
