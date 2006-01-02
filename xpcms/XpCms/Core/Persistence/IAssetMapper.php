<?php
/**
 * This interface represents the access layer to all available and stored 
 * asset types.
 * 
 * @package XpCms.Core.Persistence
 * @author Manuel Pichler <manuel.pichler@xplib.de>
 * @version $Revision: 1.1 $ 
 */
interface IAssetMapper extends IConfigurable {
    
    /**
     * This method returns all <code>AbstractAsset</code>-objects for the given
     * <code>$id</code>. The different asset types are returned in their
     * <code>StructureGroup</code>-objects. So you have a structure like this:
     * 
     * <pre>
     *   ArrayAccess {
     *     StructureGroup {
     *       ImageAsset {}
     *       ImageAsset {}
     *     }
     *     StructureGroup {
     *       TextAsset {}
     *       TextAsset {}
     *     }
     *   }
     * </pre> 
     * 
     * If the given <code>$id</code> doesn't contain any assets an empty
     * <code>ArrayAccess</code>-object will be returned.
     * 
     * @param integer $id The context <code>WebPage</code> identifier for the
     *                    asset query.
     * @param string $locale The language of the requested assets.
     * @param mixed $status The status of the <code>AbstractAsset</code>-objects
     *                      This is an optional parameter.
     * @return ArrayAccess An <code>ArrayAccess</code>-object that contains all
     *                     <code>AbstractAsset</code>s in their 
     *                     <code>StructureGroup</code>s.
     */
    public function findByWebPage($id, $locale, $status = 1);
}
?>
