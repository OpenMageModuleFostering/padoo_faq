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
 
class Padoo_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('faq_form', array('legend' => Mage::helper('faq')->__('Item information')));
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false, 'add_widgets' => false,'files_browser_window_url'=>$this->getBaseUrl().'admin/cms_wysiwyg_images/index/'));
		$version = substr(Mage::getVersion(), 0, 3);
		$groups = array(array('value' => '', 'label' => 'Select an Group'));
		$collection = Mage::getModel('faq/faqgroup')->getCollection();
		foreach ($collection as $group) {
			$groups[] = array('value' => $group->getGroupId(), 'label' => $group->getGroupName());
		}
		
		
		$fieldset->addField('group_id', 'multiselect', array(
			'label'     => Mage::helper('faq')->__('Groups'),
			'name'      => 'groups[]',
			'required'  => true,
			'values'    => $groups,
		));
		
		if (!Mage::app()->isSingleStoreMode()) {
			$fieldset->addField('store_id', 'multiselect', array(
				'name' => 'stores[]',
				'label' => Mage::helper('faq')->__('Store View'),
				'title' => Mage::helper('faq')->__('Store View'),
				'required' => true,
				'values' => Mage::getSingleton('adminhtml/system_store')
							 ->getStoreValuesForForm(false, true),
			));
		}
		else {
			$fieldset->addField('store_id', 'hidden', array(
				'name' => 'stores[]',
				'value' => Mage::app()->getStore(true)->getId()
			));
		}
		
		$fieldset->addField('faq', 'editor', array(
			'name' 		=> 'faq',
			'label' 	=> Mage::helper('faq')->__('Question'),
			'title'     => Mage::helper('faq')->__('Question'),
			'style'     => 'width:500px; height:300px;',
			'state'     => 'html',
			'wysiwyg'   => false,
			'required'  => true,
		));
		
		$fieldset->addField('body', 'editor', array(
			'name'      => 'body',
			'label'     => Mage::helper('faq')->__('Answer'),
			'title'     => Mage::helper('faq')->__('Answer'),
			'style'     => 'width:500px; height:300px;',
			'state'     => 'html',
			'wysiwyg'   => true,
			'required'  => true,
		));		  
		$fieldset->addField('sort_order', 'text', array(
			'label' => Mage::helper('faq')->__('Sort Order'),	
			'style'    => 'width:600px;',
			'name' => 'sort_order',
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('faq')->__('Status'),
			'class' => 'required-entry',
			'name' => 'status',			
			'style'    => 'width:600px;',
			'values' => array(
				array(
					'value' => 1,
					'label' => Mage::helper('faq')->__('Enabled'),
				),
				array(
					'value' => 2,
					'label' => Mage::helper('faq')->__('Disabled'),
				),
			),
		));
		if (Mage::getSingleton('adminhtml/session')->getBannerData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
			Mage::getSingleton('adminhtml/session')->setBannerData(null);
		} else if (Mage::registry('faq_data')) {
			$form->setValues(Mage::registry('faq_data')->getData());
		}
		return parent::_prepareForm();
	}
}