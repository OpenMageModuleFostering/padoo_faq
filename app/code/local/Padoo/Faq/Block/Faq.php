<?php
/**
 * Padoosoft Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0).
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to obtain it through the world-wide-web, please send
 * an email to support@mage-addons.com so we can send you a copy immediately.
 *
 * @category   Padoo
 * @package    Padoo_FAQ
 * @author     PadooSoft Team
 * @copyright  Copyright (c) 2010-2012 Padoo Co. (http://mage-addons.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Padoo_Faq_Block_Faq extends Mage_Core_Block_Template {
	public $_groupId;
	public function _prepareLayout() {
		if($this->getRequest()->getParam('id')){
			$this->_groupId = $this->getRequest()->getParam('id');
		}else{
			$groups 		= $this->getGroups();
			foreach($groups as $group){
				if($this->groupHasData($group->getGroupId())){
					$this->_groupId = $group->getGroupId();
					break;
				}
			}
		}
		
		return parent::_prepareLayout();
	}
	
	
	public function getWkfaq() {
		if (!$this->hasData('faq')) {
			$this->setData('faq', Mage::registry('faq'));
		}
		return $this->getData('faq');
	}
	
	public function getGroups(){
		$storeId = Mage::app()->getStore(true)->getId();
		$collection = Mage::getModel('faq/faqgroup')->getCollection()->setOrder('group_name','ASC');
		$collection->getSelect()->where('status = ?',1);
		$data = array();
		foreach ($collection as $record) {
			$stores 	= $record->getStoreId();
			if(strpos($stores,$storeId) !== false || strpos($stores,0) !== false || $stores == 0 ){
				$data[$record->getId()] = $record;
			}
		}
		return $data;
	}
	
	public function getDataByGroup(){
		$storeId = Mage::app()->getStore(true)->getId();
		$collection = Mage::getModel('faq/faqgroup')->getCollection()->setOrder('group_name','ASC');
		$collection->getSelect()->where('status = ?',1);
		if($this->_groupId){
			$collection->getSelect()->where('group_id = ?',$this->_groupId);
		}
		$data = array();
		foreach ($collection as $record) {
			$stores 	= $record->getStoreId();
			if(strpos($stores,$storeId) !== false || strpos($stores,0) !== false || $stores == 0 ){
				$data[$record->getId()] = $record;
			}
		}
		return $data;
	}

	public function groupHasData($groupId = 0){
		$checked = false;
		$storeId = Mage::app()->getStore(true)->getId();
		$collection = Mage::getModel('faq/faq')->getCollection();
		$collection->getSelect()->where('status = ?',1);
		$data = array();
		foreach ($collection as $record) {
			$stores 	= $record->getStoreId();
			if(strpos($stores,$storeId) !== false || strpos($stores,0) !== false || $stores == 0 ){
				$arrGroups = explode(',',$record->getGroupId());
				if(in_array($groupId,$arrGroups)){
					$checked = true;
					break;
				}
			}
		}
		return $checked;
	}
	
	public function getFaqs(){
		$storeId = Mage::app()->getStore(true)->getId();
		$collection = Mage::getModel('faq/faq')->getCollection()->setOrder('sort_order','ASC');
		$collection->getSelect()->where('status = ?',1);
		$data = array();
		foreach ($collection as $record) {
			$stores 	= $record->getStoreId();
			if(strpos($stores,$storeId) !== false || strpos($stores,0) !== false || $stores == 0 ){
				$data[$record->getId()] = $record;
			}
		}
		return $data;
	}
	protected function checkDir($directory) {
		if (!is_dir($directory)) {
			umask(0);
			mkdir($directory, 0777,true);
			return true;
		}
	}
}