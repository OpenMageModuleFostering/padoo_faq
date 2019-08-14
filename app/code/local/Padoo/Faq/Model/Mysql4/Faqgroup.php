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
 
class Padoo_Faq_Model_Mysql4_Faqgroup extends Mage_Core_Model_Mysql4_Abstract {
	public function _construct() {
		$this->_init('faq/faqgroup', 'group_id');
	}
	public function _beforeSave(Mage_Core_Model_Abstract $object) {
		$isDataValid = true;
		$id = $object->getId();
		//$groupCode = $object->getGroupCode();
		$groupCollection = Mage::getModel('faq/faqgroup')->getCollection();
		/* if ($id == '' || $id == 0) {
			if ($groupCode == '') {
				throw new Exception('Banner Group code can\'t be blank !!');
			} else {
				$groupInfo = $groupCollection->getDuplicateGroupCode($groupCode);
				if ($groupInfo->count() > 0) {
					$isDataValid = false;
				}
				if ($isDataValid === false) {
					throw new Exception("Banner Group Code already exists !!");
				}
			}
		} */
	}
}