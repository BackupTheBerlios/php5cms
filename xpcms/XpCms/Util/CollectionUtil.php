<?php
/*
 * Created on 21.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class CollectionUtil {
    
    
    public static function getPageClassAndAliasPath(WebCollection $collection,
                                                                  &$pageClass,
                                                                  &$aliasPath) {
        
        $lang = $collection->getWebPage()->Language;
        $pageClass = $collection->getPageClass();
        $parts = array($collection->getAlias());
        
        $coll1 = $collection;
        $coll2 = $coll1->getParentCollection();
        while ($coll2 !== null) {
            
            if ($pageClass === null) {
                $pageClass = $coll1->getPageClass();
            }
            
            $coll1 = $coll2;
            $coll2 = $coll2->getParentCollection();
            
            $parts[] = $coll1->getAlias();
        }
        
        $aliasPath = implode('/', array_reverse($parts)) . '.' . $lang . '.html';
    }
    
}
?>
