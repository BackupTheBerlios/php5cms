<?php
abstract class DLLIteratorItem {
	
	private $nextItem = null;
	
	private $prevItem = null;
	
	public function getNextItem() {
		return $this->nextItem;
	}
	
	public function setNextItem(DLLIteratorItem $nextItem) {
		if ($nextItem !== null) {
			if (($prev = $nextItem->getPrevItem()) !== null) {
				$prev->setNextItem($nextItem->getNextItem());
			}
			$nextItem->setPrevItem($this);
			$nextItem->setNextItem($this->nextItem);
		}
		
		$this->nextItem = $nextItem;
	}
	
	public function getPrevItem() {
		return $this->prevItem;
	}
	
	public function setPrevItem(DLLIteratorItem $prevItem) {
		
	}	
}
?>
