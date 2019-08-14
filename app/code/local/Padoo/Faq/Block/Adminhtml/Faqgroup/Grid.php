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
 
class Padoo_Faq_Block_Adminhtml_Faqgroup_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('faqgroupGrid');
		$this->setDefaultSort('group_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	protected function _prepareCollection() {
		$collection = Mage::getModel('faq/faqgroup')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns() {
		$this->addColumn('group_id', array(
			'header' => Mage::helper('faq')->__('ID'),
			'align' => 'right',
			'width' => '50px',
			'index' => 'group_id',
		));
		$this->addColumn('group_name', array(
			'header' => Mage::helper('faq')->__('Group name'),
			'index' => 'group_name',
			'align' => 'center',
		));				
		/* $this->addColumn('group_code', array(
			'header' => Mage::helper('faq')->__('Group code'),
			'index' => 'group_code',
			'align' => 'center',
		));	 */			
		/* $this->addColumn('banner_ids', array(
			'header' => Mage::helper('faq')->__('Faqs'),
			'width' => '150px',
			'align'     =>'center',
			'index' => 'banner_ids',
		)); */
		$this->addColumn('status', array(
			'header' => Mage::helper('faq')->__('Status'),
			'align' => 'left',
			'width' => '100px',
			'index' => 'status',
			'type' => 'options',
			'options' => array(
				1 => 'Enabled',
				2 => 'Disabled',
			),
		));
		$this->addColumn('action',
				array(
					'header' => Mage::helper('faq')->__('Action'),
					'width' => '50',
					'type' => 'action',
					'getter' => 'getId',
					'actions' => array(
						array(
							'caption' => Mage::helper('faq')->__('Edit'),
							'url' => array('base' => '*/*/edit'),
							'field' => 'id'
						)
					),
					'filter' => false,
					'sortable' => false,
					'index' => 'stores',
					'is_system' => true,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('faq')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('faq')->__('XML'));
		return parent::_prepareColumns();
	}
	protected function _prepareMassaction() {
		$this->setMassactionIdField('group_id');
		$this->getMassactionBlock()->setFormFieldName('faq');
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => Mage::helper('faq')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('faq')->__('Are you sure?')
		));
		$statuses = Mage::getSingleton('faq/status')->getOptionArray();
		array_unshift($statuses, array('label' => '', 'value' => ''));
		$this->getMassactionBlock()->addItem('status', array(
			'label' => Mage::helper('faq')->__('Change status'),
			'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
			'additional' => array(
				'visibility' => array(
					'name' => 'status',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => Mage::helper('faq')->__('Status'),
					'values' => $statuses
				)
			)
		));
		return $this;
	}
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}