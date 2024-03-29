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
 
class Padoo_Faq_Model_Mysql4_Faqgroup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	public function _construct() {
		parent::_construct();
		$this->_init('faq/faqgroup');
	}
	public function getDuplicateGroupCode($groupCode) {
		$this->setConnection($this->getResource()->getReadConnection());
		$table = $this->getTable('faq/faqgroup');
		$select = $this->getSelect();
		$select->from(array('main_table' => $table), 'group_id')->where('group_code = ?', $groupCode);
		return $this;
	}
}