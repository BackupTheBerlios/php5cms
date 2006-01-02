<?php



/*
 * Created on 28.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class AssetMapperTestCase extends BasePersistenceTestCase {

    public function testFindAssetsForAWebPageObject() {
        
        $aliasPath = array('project', 'xpcms');
        
        $wcm = $this->factory->createWebCollectionMapper();
        $webPage = $wcm->findByAliasPath($aliasPath, 'de_DE')->getWebPage();
        
        
        $amapper = $this->factory->createAssetMapper();
        $assets  = $amapper->findByWebPage($webPage->getId(), 'de_DE');
        
        $this->assertNotNull($assets);
        $this->assertTrue($assets instanceof ArrayAccess);
        
    }    
}
?>
