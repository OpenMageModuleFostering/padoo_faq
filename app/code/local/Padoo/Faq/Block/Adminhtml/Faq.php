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
 
class Padoo_Faq_Block_Adminhtml_Faq extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_controller = 'adminhtml_faq';
		$this->_blockGroup = 'faq';
		$this->_headerText = Mage::helper('faq')->__('FAQ Manager');
		$this->_addButtonLabel = Mage::helper('faq')->__('Add FAQ');
		parent::__construct();
	}
}
