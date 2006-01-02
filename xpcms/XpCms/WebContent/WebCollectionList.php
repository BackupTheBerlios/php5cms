<?php
/**
 * This is a simple <code>TControl</code> that shows up a single level of 
 * <code>WebCollection</code>-objects.
 * 
 * @package XpCms.WebContent
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $
 */
class WebCollectionList extends TControl {
    
    /**
     * 
     */
    public function setDataSource(ArrayAccess $collections) {
        $this->CollectionList->setDataSource($collections);
        $this->dataBind();
    }
}
?>
