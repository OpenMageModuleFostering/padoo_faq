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
 
class Padoo_Faq_Block_Adminhtml_Faq_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
	public function __construct() {
		parent::__construct();
		$this->setId('faq_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('faq')->__('FAQ Information'));
	}
	protected function _beforeToHtml() {
		$this->addTab('form_section', array(
			'label' => Mage::helper('faq')->__('Add FAQ'),
			'alt' => Mage::helper('faq')->__('Add FAQ'),
			'content' => $this->getLayout()->createBlock('faq/adminhtml_faq_edit_tab_form')->toHtml(),
		));        
		return parent::_beforeToHtml();
	}
}