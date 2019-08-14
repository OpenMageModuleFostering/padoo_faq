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
 
class Padoo_Faq_Model_Faqgroup extends Mage_Core_Model_Abstract {
	public function _construct() {
		parent::_construct();
		$this->_init('faq/faqgroup');
	}
	public function getDataByGroup() {        
		$groupData = array();
		$bannerData = array();
		$result = array('group_data'=>$groupData,'faq_data'=>$bannerData);
		$collection = Mage::getResourceModel('faq/faqgroup_collection');
		$collection->getSelect()->where('status = 1');
		/* foreach ($collection as $record) {
			$bannerIds = $record->getBannerIds();
			$bannerModel = Mage::getModel('faq/faq');
			$bannerData = $bannerModel->getDataByBannerIds($bannerIds);
			$result = array('group_data' => $record, 'faq_data' => $bannerData);
		} */
		return $collection;
	}
}