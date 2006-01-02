<?php
/*
 * Created on 29.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetLink extends AbstractAsset {
    
    protected $url;
    protected $title;
    protected $description;
    protected $clicks;
    
    public function __construct() {
        parent::__construct(array(
            'Url'         => array('name' => 'url', 'type' => 'string'),
            'Title'       => array('name' => 'title', 'type' => 'string'),
            'Description' => array('name' => 'description', 'type' => 'string'),
            'Clicks'      => array('name' => 'clicks', 'type' => 'integer')));
        
    }
    
    
}
?>
