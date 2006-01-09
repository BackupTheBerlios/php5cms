<?php
/*
 * Created on 18.12.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class StructurePage extends TPage {
    
    public function onLoad($param) {
        parent::onLoad($param);
        
        if (!$this->IsPostBack) {
            
            $service = ContentService::getInstance();
            
            $groups = $service->getWebCollectionGroupsByAlias(
                        IXpCmsConstants::WEBSITE_STRUCTURE_ALIAS);

            $this->MainBodyContent->GroupList->setDataSource($groups);
            $this->dataBind();
            
        }
        
        #$this->Session->set('opened.Collections', array());
        
        if (($viewState = $this->Session->get('opened.Collections')) === null) {
            $viewState = array();
        }
        
        foreach ($viewState as $ids) {
            $this->createWebCollectionRepeater(
                    $this->findObject($ids['parentId']), $ids['childId']);
        }
    }
    
    
    public function GroupList_OnItemCreated($sender, $param) {
        $item = $param->item;

        $link = $item->GroupLink;
        $link->setEncodeText(false);
        $link->Text = '<span>'.$item->Data->Name.'</span>';       
        $link->setAttribute('title',$item->Data->Description);
        
        $item->CollectionList->setDataSource($item->Data->Groupables);
        $item->CollectionList->dataBind();
    }
    
    public function CollectionList_OnItemCreated($sender, $param) {
        
        $item = $param->item;

        $link = $item->CollectionLink;
        $link->setEncodeText(false);
        $link->Text = '<span>'.$item->Data->getWebPage()->Name.'</span>';       
        $link->setAttribute('title',$item->Data->getWebPage()->Description);
    }
    
    
    public function OnWebCollectionClicked($sender, $param) {

        $viewState = $this->Session->get('opened.Collections');
        if (is_null($viewState)) {
            $viewState = array();
        }

        $component = $sender->getParent();
        $uniqueId  = $component->getUniqueId();

        if (isset($viewState[$uniqueId])) {
            
            $closeIds = array($uniqueId);
            
            $childId = $viewState[$uniqueId]['childId'] . ':';
            
            $newViewState = $viewState;
            foreach ($viewState as $dataId => $ids) {
                $keep = true;
                foreach ($closeIds as $closeId) {
                    if (strpos($dataId, $closeId) === 0) {
                        $this->findObject($ids['childId'])->setVisible(false);
                        $closeIds[] = $ids['childId'] . ':';
                        unset($newViewState[$dataId]);
                    }
                }
            }
            $this->Session->set('opened.Collections', $newViewState);
        } else if (($compId = $this->createWebCollectionRepeater(
                    $component)) !== null) {
                        
            $viewState[$uniqueId] = array(
                'parentId' => str_replace(':', '.', $uniqueId),
                'childId'  => str_replace(':', '.', $compId));
            
            $this->Session->set('opened.Collections', $viewState);    
        }
    }
    
    /**
     * This method is called if the user clicks on the collection edit button
     * in the frontend. Then it redirects the request to the 
     * {@link StructureEditPage} with the selected <code>WebCollection</code> as
     * parameter.
     * 
     * @param TComponent $sender The clicked button.
     * @param TEventParameter $param This is not used by the method.
     */
    public function OnEditWebCollectionClicked($sender, $param) {
        
        $collectionInfo = CollectionUtil::getPageClassAndAliasPath(
                                                    $sender->getParent()->Data);
        
        $this->Application->transfer(
                'WebContent:StructureEdit', array(
                        'alias' => $collectionInfo->aliasPath));
    }
    
    
    private function createWebCollectionRepeater($component, $childId = null) {
        $collections = $component->Data->getWebCollections();
        if ($collections->count() > 0) {
            
            
            if ($childId === null) {
                if (($ids = $this->Session->get(
                            'opened.Collection.Ids')) === null) {
                    $ids = 0;
                }
                $childId = 'WebCollection' . $ids;
                
                $this->Session->set('opened.Collection.Ids', ++$ids);
            }
            
            
            $collList = $this->createComponent('WebCollectionList', $childId);
            $collList->setVisible(true);
            $collList->setDataSource($collections);

            $component->ChildCollections->addBody($collList);
            
            return $collList->getUniqueID();
        }
        return null;
    }
    
}
?>
