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
 
class Padoo_Faq_SubmitController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		if (!Mage::getStoreConfig('faq/general/enable')) $this->_redirect('no-route');
		$this->loadLayout();
		$this->renderLayout();
	}
	public function saveAction() {
		if (!Mage::getStoreConfig('faq/general/enable')) $this->_redirect('no-route');
		$faq_disable = 2;
		$storeId = Mage::app()->getStore(true)->getId();
		$data = $this->getRequest()->getPost();
		$faqData = $_POST['faq'];
		$_category= $faqData['category'];
        if (!empty($data)) {
            $session = Mage::getSingleton('core/session', array('name'=>'faq_frontend'));
            /* @var $session Mage_Core_Model_Session */
			$faqitem = Mage::getModel('faq/faq');
			$validate = $faqitem->validate();
			$formId = 'padoo_faq';
			if ($validate === true) {
				$captchaModel = Mage::helper('captcha')->getCaptcha($formId);
				if ($captchaModel->isRequired()) {
					$word = $this->_getCaptchaString($this->getRequest(), $formId);
					if (!$captchaModel->isCorrect($word)) {
						Mage::getSingleton('core/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
						$this->_redirectReferer('');
						return;
					}
				}
			
				try {
					$faqitem->setGroupId($faqData['category']);
					$faqitem->setFaq($faqData['question']);
					$faqitem->setStatus($faq_disable);
					$faqitem->setStoreId($storeId);
					$faqitem->setCreatedTime(now());
					$faqitem->setUpdateTime(now());
					$faqitem->save();
					
					$itemId = $faqitem->getBannerId(); 
					//send email to store 
					if(Mage::getStoreConfig('faq/options/enable_notification')){
						Mage::helper('faq')->sendMailToStore($itemId);
					}
					
					$session->addSuccess($this->__('Your question has been accepted'));
				}catch (Exception $e) {
					$session->setFormData($faqData);
					$session->addError($this->__('Unable to post question. Please, try again later !'));
				}
			}else {
				try{
					$session->setFormData($faqData);
				}catch(Exception $e){
					Mage::log($e->getMessage());
				}                  
				if (is_array($validate)) {                   
					foreach ($validate as $errorMessage) {
						$session->addError($errorMessage);
					}                 
				}
				else {
					$session->addError($this->__('Unable to post question. Please, try again later !'));
				}
			}	
        }

        if ($redirectUrl = Mage::getSingleton('core/session')->getRedirectUrl(true)) {
            $this->_redirectUrl($redirectUrl);
            return;
        }
        $this->_redirectReferer();		
	}
	
	protected function _getCaptchaString($request, $formId)
    {
        $captchaParams = $request->getPost(Mage_Captcha_Helper_Data::INPUT_NAME_FIELD_VALUE);
        return $captchaParams[$formId];
    }
}