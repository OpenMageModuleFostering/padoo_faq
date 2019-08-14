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
 
class Padoo_Faq_Model_Faq extends Mage_Core_Model_Abstract {
	public function _construct() {
		parent::_construct();
		$this->_init('faq/faq');
	}
	public function getAllAvailBannerIds(){
		$collection = Mage::getResourceModel('faq/faq_collection')->getAllIds();
		return $collection;
	}
	public function getAllBanners() {
		$collection = Mage::getResourceModel('faq/faq_collection');
		$collection->getSelect()->where('status = ?', 1);
		$data = array();
		foreach ($collection as $record) {
			$data[$record->getId()] = array('value' => $record->getId(), 'label' => $record->getfilename());
		}
		return $data;
	}
	
	public function validate()
	{
		$_category= $_POST['category'];
		$data = $_POST['faq'];
		$errors = array();
		$helper = Mage::helper('faq');
		if($_category =='---Select one---'){
			$errors[] = $helper->__('Grooup Name is a required field');
		}
		if (!Zend_Validate::is($data['question'], 'NotEmpty')) {
			$errors[] = $helper->__('Question is a required field');
		}
		if (empty($errors)) {
			return true;
		}
		return $errors;
	}
}