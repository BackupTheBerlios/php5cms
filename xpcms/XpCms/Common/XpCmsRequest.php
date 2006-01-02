<?php
/*
 * Created on 18.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class XpCmsRequest extends TRequest {
    
    const FORMAT_EXT_PATH = 'ext_path';
    
    const CONTENT_LANG = 'lang';
    
    public function __construct($config) {
        $extPath = (((string) $config['format']) === self::FORMAT_EXT_PATH);
        if ($extPath) {
            $config['format'] = self::FORMAT_GET;
        }
        parent::__construct($config);
    
        if ($extPath && isset($this->parameters[self::PAGE_SERVICE])) {
            $this->requestedPage = $this->requestedPage . 'Page';
            
            $this->format = self::FORMAT_EXT_PATH;
        }
    }
    
    public function constructURL($pageName = null, $getParameters=null) {
        $url = '';
        if ($this->format == self::FORMAT_EXT_PATH) {
            
            if (!is_null($pageName)) {
                $url .= '/' . $pageName; 
            }
            if (isset($getParameters['alias'])) {
                $url .= '/' . $getParameters['alias'];
                
                unset($getParameters['alias']);
            }
            if (!empty($getParameters)) {
                $query = array();
                foreach ($getParameters as $name => $value) {
                    $query[] = $name . '=' . $value;
                }
                $url .= '?' . implode('&', $query);
            }
        } else {
            $url = parent::constructURL($pageName, $getParameters);
        }
        return $url;
    }
}
?>
