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
 
class Padoo_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action {

	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('faq/faq');
	}
	
	protected function _initAction() {
		$this->loadLayout()->_setActiveMenu('faq/items')->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}
	public function indexAction() {
		$this->_initAction()->renderLayout();
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		$model = Mage::getModel('faq/faq')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('faq_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('faq/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()){
				$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			}
			$this->_addContent($this->getLayout()->createBlock('faq/adminhtml_faq_edit'))
					->_addLeft($this->getLayout()->createBlock('faq/adminhtml_faq_edit_tabs'));
			$version = substr(Mage::getVersion(), 0, 3);
			if (($version=='1.4' || $version=='1.5') && Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
				$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			}
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('faq')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		$imagedata = array();
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('faq/faq');
			$faqGroups = $data['groups'];
			// save storeview
			$storeView = $data['stores'];
			$dataStore = "";
			foreach($storeView as $store){
				if($dataStore != "") $dataStore .=", ";
				$dataStore .= $store;
			} 
			$data['store_id'] = $dataStore;
			
			//save Groups
			$dataGroup = "";
			foreach($faqGroups as $group){
				if(!empty($dataGroup)) $dataGroup .=", ";
				$dataGroup .= $group;
			} 
			$data['group_id'] = $dataGroup;
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('faq')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('faq')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}
	public function deleteAction() {
		if ($this->getRequest()->getParam('id') > 0) {
			try {
				$model = Mage::getModel('faq/faq')->load($this->getRequest()->getParam('id'));
				$_helper = Mage::helper('faq');
				//$filePath = Mage::getBaseDir('media').DS.$_helper->updateDirSepereator($model->getFilename());
				$model->delete();
				//$this->removeFile($filePath);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	public function massDeleteAction() {
		$bannerIds = $this->getRequest()->getParam('faq');
		if (!is_array($bannerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($bannerIds as $bannerId) {
					$model = Mage::getModel('faq/faq')->load($bannerId);
					$_helper = Mage::helper('faq');
					//$filePath = Mage::getBaseDir('media').DS.$_helper->updateDirSepereator($model->getFilename());
					$model->delete();
					//$this->removeFile($filePath);
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($bannerIds)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	public function massStatusAction() {
		$bannerIds = $this->getRequest()->getParam('faq');
		if (!is_array($bannerIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
		} else {
			try {
				foreach ($bannerIds as $bannerId) {
					$banner = Mage::getSingleton('faq/faq')->load($bannerId)->setStatus($this->getRequest()->getParam('status'))->setIsMassupdate(true)->save();
				}
				$this->_getSession()->addSuccess(
						$this->__('Total of %d record(s) were successfully updated', count($bannerIds))
				);
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	public function exportCsvAction() {
		$fileName = 'faq.csv';
		$content = $this->getLayout()->createBlock('faq/adminhtml_faq_grid')->getCsv();
		$this->_sendUploadResponse($fileName, $content);
	}
	public function exportXmlAction() {
		$fileName = 'faq.xml';
		$content = $this->getLayout()->createBlock('faq/adminhtml_faq_grid')->getXml();
		$this->_sendUploadResponse($fileName, $content);
	}
	protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream') {
		$response = $this->getResponse();
		$response->setHeader('HTTP/1.1 200 OK', '');
		$response->setHeader('Pragma', 'public', true);
		$response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
		$response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
		$response->setHeader('Last-Modified', date('r'));
		$response->setHeader('Accept-Ranges', 'bytes');
		$response->setHeader('Content-Length', strlen($content));
		$response->setHeader('Content-type', $contentType);
		$response->setBody($content);
		$response->sendResponse();
		die;
	}
	protected function removeFile($file) {
		try {
			$io = new Varien_Io_File();
			$result = $io->rmdir($file, true);
		} catch (Exception $e) {}
	}
}