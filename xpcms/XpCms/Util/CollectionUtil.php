<?php
/*
 * Created on 21.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class CollectionUtil {
    
    
    public static function getPageClassAndAliasPath(WebCollection $collection) {
        
        $lang      = $collection->getWebPage()->Language;
        $parts     = array($collection->getAlias());
        $pageClass = $collection->getPageClass();
        
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
        
        return new CollectionInfo($pageClass, $aliasPath);
    }
    
}

/**
 * This structure is used to return the alias path and an associated prado
 * <code>TPage</code>-class for a <code>WebCollection</code>.
 * 
 * @package XpCms.Util
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.2 $  
 */
class CollectionInfo {
    
    /**
     * The name of the <code>TPage</code>-class.
     * 
     * @var string $pageClass 
     */
    public $pageClass = null;
    
    /**
     * The alias path for the <code>WebCollection</code>.
     * 
     * @var string $aliasPath
     */
    public $aliasPath = null;
    
    /**
     * Simple constructor that takes the <code>TPage</code>-class name and the
     * alias path as argument. Both parameters can also be <code>null</code>.
     * 
     * @param string $pageClass The name of the <code>TPage</code>-class.
     * @param string $aliasPath The path for the <code>WebCollection</code>.
     */
    public function __construct($pageClass = null, $aliasPath = null) {
        $this->pageClass = $pageClass;
        $this->aliasPath = $aliasPath;
    }
}
?>
