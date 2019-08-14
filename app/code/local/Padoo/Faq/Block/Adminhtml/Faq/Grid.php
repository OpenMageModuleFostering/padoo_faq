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
 
class Padoo_Faq_Block_Adminhtml_Faq_Grid extends Padoo_Faq_Block_Adminhtml_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('bannerGrid');
		$this->setDefaultSort('banner_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	protected function _prepareCollection() {
		$collection = Mage::getModel('faq/faq')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns() {
		$this->addColumn('banner_id', array(
			'header' => Mage::helper('faq')->__('ID'),
			'align' => 'center',
			'width' => '30px',
			'index' => 'banner_id',
		));
		$this->addColumn('faq', array(
			'header' => Mage::helper('faq')->__('FAQ'),
			'index' => 'faq',
			'align' => 'center',
		));			
		$this->addColumn('body', array(
			'header' => Mage::helper('faq')->__('Content'),
			'index' => 'body',
			'width' => '750px',
			'align' => 'center',
		));			
		$this->addColumn('sort_order', array(
			'header' => Mage::helper('faq')->__('Sort Order'),
			'index' => 'sort_order',
			'width' => '100px',
			'align' => 'center',
		));
		$this->addColumn('status', array(
			'header' => Mage::helper('faq')->__('Status'),
			'align' => 'left',
			'width' => '80px',
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
					'width' => '80',
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
		$this->setMassactionIdField('banner_id');
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