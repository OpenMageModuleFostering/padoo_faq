<?php
	class Padoo_Faq_Block_Adminhtml_Faqgroup_Edit_Tab_Gridfaq extends Mage_Adminhtml_Block_Widget_Container {
		public function __construct() {
			parent::__construct();
			$this->setTemplate('padoofaq/faqs.phtml');
		}
		public function getTabsHtml() {
			return $this->getChildHtml('faqs');
		}
		protected function _prepareLayout() {
			$this->setChild('faqs', $this->getLayout()->createBlock('faq/adminhtml_faqgroup_edit_tab_faq', 'faqgroup.grid.faq'));
			return parent::_prepareLayout();
		}
		public function getBannergroupData() {
			return Mage::registry('faqgroup_data');
		}
		public function getBannersJson() {
			$banners = explode(',', $this->getBannergroupData()->getBannerIds());
			if (!empty($banners) && isset($banners[0]) && $banners[0] != '') {
				$data = array();
				foreach ($banners as $element) {
					$data[$element] = $element;
				}
				return Zend_Json::encode($data);
			}
			return '{}';
		}
	}
?>