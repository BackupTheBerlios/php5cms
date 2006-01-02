<?php
require_once 'BaseTestCase.php';

require_once 'XpCms/Common/IXpCmsConstants.php';
require_once 'XpCms/Common/XpCmsConfig.php';
require_once 'XpCms/Core/Service/ContentService.php';

/*
 * Created on 28.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class ContentServiceTestCase extends BaseTestCase {
    
    /*
     * This method tries to find a single WebCollection by its alias path
     * 
     * The input values are: /project/nexd/umdoc
     *                       /project/nexd/umdoc/diagrams
     *                       /company/jobs
     */
    public function testFindWebCollectionByAliasPath() {
        
        $service = ContentService::getInstance();
        
        $aliasPath  = '/project/nexd/umldoc';
        $collection = $service->getWebCollectionByAliasPath($aliasPath);
        $this->assertNotNull($collection);
        $this->assertEquals('umldoc', $collection->getAlias());
        
        $aliasPath  = '/project/nexd/umldoc/diagrams';
        $collection = $service->getWebCollectionByAliasPath($aliasPath);
        $this->assertNotNull($collection);
        $this->assertEquals('diagrams', $collection->getAlias());
        
        $aliasPath  = '/company/jobs';
        $collection = $service->getWebCollectionByAliasPath($aliasPath);
        $this->assertNotNull($collection);
        $this->assertEquals('jobs', $collection->getAlias());
    }
    
    /*
     * Tries to find a WebCollection by an alias path that doesn't exist and with
     * an invalid input value.
     *  
     * The input values are: /to/nirvana
     *                       null
     */
    public function testDoNotFindAWebCollectionByInvalidAndNotExistingAliasPath() {
        
        $service = ContentService::getInstance();
        
        $aliasPath  = '/to/nirvana';
        $collection = $service->getWebCollectionByAliasPath($aliasPath);
        $this->assertNull($collection);
        
        try {
            $aliasPath  = null;
            $collection = $service->getWebCollectionByAliasPath($aliasPath);
            $this->fail('Expected an InvalidArgumentException');
        } catch (InvalidArgumentException $e) {}
    }
    
    /*
     * This test tries to find the /project collection in german and in english.  
     */
    public function testFindWebCollectionGermanAndEnglishByItsAliasPath() {
        
        $service = ContentService::getInstance();
        
        $aliasPath = '/project/';
        $english   = 'en_GB';
        $german    = 'de_DE';
        
        $collection1 = $service->getWebCollectionByAliasPath($aliasPath, $german);
        $this->assertNotNull($collection1);
        $this->assertEquals('project', $collection1->getAlias());
        $this->assertEquals($german, $collection1->getWebPage()->getLanguage());
        
        $collection2 = $service->getWebCollectionByAliasPath($aliasPath, $english);
        $this->assertNotNull($collection2);
        $this->assertEquals('project', $collection2->getAlias());
        $this->assertEquals($english, $collection2->getWebPage()->getLanguage());
        
        $collection3 = $service->getWebCollectionByAliasPath($aliasPath);
        $this->assertEquals($collection1->getWebPage()->getLanguage(), 
                            $collection3->getWebPage()->getLanguage());
    }
    
    /*
     * Tries to find all assets for a WebPage
     */
    public function testFindAssetGroupsForWebPage() {
        
        $service = ContentService::getInstance();
        
        $webPage = $service->getWebCollectionByAliasPath('/project/xpcms/', 'de_DE')->getWebPage();
        
        $assets = $service->getAssetGroups($webPage);
        $this->assertNotNull($assets);
        $this->assertTrue(sizeof($assets) > 0);
    }
    
    /*
     * Finds all structure groups by their public groups alias name.
     */
    public function testFindStructureGroupsAndCollectionsByGroupAlias() {
        
        $service = ContentService::getInstance();
        
        $groups = $service->getWebCollectionGroupsByAlias('CompleteWebSiteStructure');
        $this->assertNotNull($groups);
        $this->assertTrue($groups->count() > 0);
        foreach ($groups as $group) {
            $this->assertTrue($group instanceof StructureGroup);
            $this->assertNotNull($group->Groupables);
            $this->assertTrue($group->Groupables->count() > 0);
            foreach ($group->Groupables as $coll) {
                $this->assertTrue($coll instanceof WebCollection);
            }
        }
    }
    
    public function testFindCollectionsByAlias() {
        $service = ContentService::getInstance();
        
        $colls = $service->getWebCollectionsByAlias('backend_menu');
        $this->assertNotNull($colls);
        $this->assertTrue($colls->count() > 0);
        
        foreach ($colls as $coll) {
            $this->assertTrue($coll instanceof WebCollection);
        }   
    }
}
?>
