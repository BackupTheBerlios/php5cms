<?php
/**
 * This module is used by the frontend to retrieve and store all possible 
 * content objects from/in storage.
 * 
 * @package XpCms.WebContent
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $
 */
class WebContentModule extends TModule {
	
    /**
     * This method returns a single <code>WebCollection</code> for the given
     * <code>$aliasPath</code> parameter. The alias path is the way from the
     * root to the requested <code>WebCollection</code>. It looks similar to
     * the shown path in most desktop file explorer applications.
     * 
     * <code>/home/manuel/Document</code> 
     * 
     * @param string $aliasPath The alias path to the requested collection.
     * @return WebCollection The found <code>WebCollection</code>-object
     * 
     * @throws WebCollectionNotFoundException If the given $aliasPath doesn't
     *                                        point to an existing collection.
     * @throws WebContentException If any unknow Exception occured.
     */
    public function getWebCollection($aliasPath) {
        
        $contentService = ContentService::getInstance();
        try {
            
            $webColl = $contentService->getWebCollectionByAliasPath($aliasPath);
            if ($webColl === null) {
                throw new WebCollectionNotFoundException($aliasPath);
            }
            return $webColl;
        } catch (Exception $e) {
            throw new WebContentException($e->getMessage());
        }
    }
    
    public function getWebPageAssets(WebPage $webPage) {
        
        $contentService = ContentService::getInstance();
        try {
            $assetGroups = $contentService->getAssetGroups($webPage);
            return $assetGroups;
        } catch (Exception $e) {
            throw new WebContentException($e->getMessage());
        }
    }
}

/**
 * Standard Exception of WebContentModule.
 * 
 * Standard Exception that will be thrown if an unexpected error occured.
 * 
 * @package XpCms.WebContent
 * @author Manuel Pichler <manuel.pichler@xplib.de> 
 */
class WebContentException extends TException {
}

/**
 * Exception that says a requested <code>WebCollection</code> doesn't exist.
 * 
 * This Exception will be thrown if the frontend asks for a special 
 * <code>WebCollection</code> that doesn't exist. Reasons could be invalid
 * identifiers, alias paths or something similar.
 * 
 * @package XpCms.WebContent
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 */
class WebCollectionNotFoundException extends WebContentException {
    
    /**
     * Constructor that takes a used and not valid
     * <code>WebCollection</code>-identifier as argument.
     * 
     * @param string $identifier Invalid identifier.
     */
    public function __construct($identifier) {
        parent::__construct(sprintf(
            'Cannot find the WebCollection for the given identifier [%s].', 
                $identifier));
    }
}
?>
