<?php
/*
 * Created on 29.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetText extends AbstractAsset {
    
    protected $title;
    
    protected $content;
    
    public function __construct() {
        parent::__construct(array(
            'Title'   => array('name' => 'title', 'type' => 'text'),
            'Content' => array('name' => 'content', 'type' => 'text')));
        
    }
    
}
?>
