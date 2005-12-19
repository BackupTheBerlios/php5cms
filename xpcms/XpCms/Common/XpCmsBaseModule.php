<?php
/*
 * Created on 13.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class XpCmsBaseModule extends TModule {

    /**
     * Global application configuration. This object holds the parameters from
     * the <code>application.spec</code> file.
     * 
     * @var XpCmsConfig $config.
     */
    protected $config;

	public function onLoad($param) {
		parent::onLoad($param);
        
        // Load the system configuration
        $this->config = XpCmsConfig::getInstance();
        
        // Load the request language.
        $lang = $this->Request->getParameter('lang');
        if ($lang === null) {
            $lang = $this->config->getStandardLanguage();
        }
		
	}	
}
?>
