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
 
class Padoo_Faq_Block_Adminhtml_Faq_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct() {
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'faq';
		$this->_controller = 'adminhtml_faq';
		$this->_updateButton('save', 'label', Mage::helper('faq')->__('Save Item'));
		$this->_updateButton('delete', 'label', Mage::helper('faq')->__('Delete Item'));
		$this->_addButton('saveandcontinue', array(
			'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
			'onclick' => 'saveAndContinueEdit()',
			'class' => 'save',
				), -100);
		$this->_formScripts[] = "
		function saveAndContinueEdit(){
			editForm.submit($('edit_form').action+'back/edit/');
		}";
	}
	public function getHeaderText() {
		if (Mage::registry('faq_data') && Mage::registry('faq_data')->getId())
			return Mage::helper('faq')->__("Edit Question");
		else
			return Mage::helper('faq')->__('Add Question');
	}
}