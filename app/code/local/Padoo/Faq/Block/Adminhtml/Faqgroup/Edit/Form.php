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
 
class Padoo_Faq_Block_Adminhtml_Faqgroup_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
					'id' => 'edit_form',
					'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
					'method' => 'post',
					'enctype' => 'multipart/form-data'
						)
		);
		$form->setUseContainer(true);
		$this->setForm($form);
		$form->addField('in_faqgroup_faqs', 'hidden', array(
			'name' => 'faqgroup_faqs',
			'required' => false,
		));
		return parent::_prepareForm();
	}
}