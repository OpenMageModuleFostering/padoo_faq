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
 
class Padoo_Faq_Block_Adminhtml_Faqgroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('faqgroup_form', array('legend' => Mage::helper('faq')->__('Item information')));
		$fieldset->addField('group_name', 'text', array(
			'label' => Mage::helper('faq')->__('FAQ Group Name'),
			'class' => 'required-entry',
			'required' => true,
			'name' => 'group_name',
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
		/* $fieldset->addField('group_code', 'text', array(
			'label' => Mage::helper('faq')->__('FAQ Group Code'),
			'class' => 'required-entry',
			'name' => 'group_code',
			'required' => true,
		));	 */				  
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('faq')->__('Status'),
			'class' => 'required-entry',
			'name' => 'status',
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
		
		/* $fieldset->addField('cms_pages', 'multiselect', array(
			'label' => Mage::helper('faq')->__('Add to Pages'),
			'name' => 'cms_pages[]',
			'values' => $this->fetchCMS(),	
		)); */
	
		if (Mage::getSingleton('adminhtml/session')->getBannergroupData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getBannergroupData());
			Mage::getSingleton('adminhtml/session')->setBannergroupData(null);
		} elseif (Mage::registry('faqgroup_data')) {
			$form->setValues(Mage::registry('faqgroup_data')->getData());
		}
		return parent::_prepareForm();
	}
	public function fetchCMS()
	{
		$cms=array();
		$cms_pages = Mage::getModel('cms/page')->getCollection();
		$cms_pages->load();
		foreach($cms_pages as $one_row)	{	
			 array_push($cms,
			 array(
			 'value' => $one_row->getPageId(),
			 'label'=>Mage::helper('adminhtml')->__($one_row->getTitle()),	  
			 )
			 );
		}
		return $cms;
	}
}