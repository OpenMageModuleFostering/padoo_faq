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
 
class Padoo_Faq_Block_Adminhtml_Faqgroup_Edit_Tab_Faq extends Padoo_Faq_Block_Adminhtml_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('faqLeftGrid');
		$this->setDefaultSort('banner_id');
		$this->setUseAjax(true);
	}
	public function getBannergroupData() {
		return Mage::registry('faqgroup_data');
	}
	protected function _prepareCollection() {
		$collection = Mage::getModel('faq/faq')->getCollection();
		$collection->getSelect()->order('banner_id');
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'faq_triggers') {
				$bannerIds = $this->_getSelectedBanners();
				if (empty($bannerIds)) {
					$bannerIds = 0;
				}
				if ($column->getFilter()->getValue()) {
					$this->getCollection()->addFieldToFilter('banner_id', array('in' => $bannerIds));
				} else {
					if ($bannerIds) {
						$this->getCollection()->addFieldToFilter('banner_id', array('in' => $bannerIds));
					}
				}
			} else {
				parent::_addColumnFilterToCollection($column);
			}
		}
		return $this;;
	}
	protected function _prepareColumns() {
		$this->addColumn('faq_triggers', array(
			'header_css_class' => 'a-center',
			'type' => 'checkbox',
			'values' => $this->_getSelectedBanners(),
			'align' => 'center',
			'index' => 'banner_id'
		));
		$this->addColumn('banner_id', array(
			'header' => Mage::helper('catalog')->__('ID'),
			'sortable' => true,
			'width' => '50px',
			'align' => 'center',
			'index' => 'banner_id'
		));			
		$this->addColumn('faq', array(
			'header' => Mage::helper('faq')->__('FAQ'),
			'index' => 'faq',
			'align' => 'center',
		));			
		$this->addColumn('body', array(
			'header' => Mage::helper('faq')->__('Content'),
			'index' => 'body',
			'width' => '700px',
			'align' => 'center',
		));		   
		$this->addColumn('sort_order', array(
			'header' => Mage::helper('faq')->__('Sort Order'),
			'width' => '80px',
			'index' => 'sort_order',
			'align' => 'center',
		));
		return parent::_prepareColumns();
	}
	public function getGridUrl() {
		return $this->getUrl('*/*/bannergrid', array('_current' => true));
	}
	protected function _getSelectedBanners() {
		$banners = $this->getRequest()->getPost('selected_faqs');
		if (is_null($banners)) {
			$banners = explode(',', $this->getBannergroupData()->getBannerIds());
			return (sizeof($banners) > 0 ? $banners : 0);
		}
		return $banners;
	}
}