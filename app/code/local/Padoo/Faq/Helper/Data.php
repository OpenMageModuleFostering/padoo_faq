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
 
class Padoo_Faq_Helper_Data extends Mage_Core_Helper_Abstract {
	protected static $egridImgDir = null;
	protected static $egridImgURL = null;
	protected static $egridImgThumb = null;
	protected static $egridImgThumbWidth = null;
	protected $_allowedExtensions = Array();
	public function __construct() {
		self::$egridImgDir = Mage::getBaseDir('media') . DS;
		self::$egridImgURL = Mage::getBaseUrl('media');
		self::$egridImgThumb = "thumb/";
		self::$egridImgThumbWidth = 100;
	}
	
	
	public function sendMailToStore($itemId){
		$object = Mage::getModel('faq/faq')->load($itemId);
		$customer_email = 'services@padoosoft.com';
		$customer_name  = 'Guest';
		$message 		= $object->getFaq();
		$templateId = Mage::getStoreConfig('faq/options/mail_to_store_template');        

		$mailSubject = $this->__('Faq Notification !');

		
		 // $sender can be of type string or array. You can set identity of
		 // diffrent Store emails (like 'support', 'sales', etc.) found
		 // in "System->Configuration->General->Store Email Addresses"
		 
		$sender = Array(
			'name' 	=> $customer_name,
			'email' => $customer_email
		);

		
		// In case of multiple recipient use array here.
		
		$email = Mage::getStoreConfig('faq/options/recipient_email');
		
		$vars = Array(
			'subject'			=> 'New Faq was sended.',
			'customer_name'		=> $customer_name,
			'message'			=> $message,
		 ); 
		
		// This is optional 
		$storeId = Mage::app()->getStore()->getId();

		$translate = Mage::getSingleton('core/translate');
		Mage::getModel('core/email_template')
			->setTemplateSubject($mailSubject)
			->sendTransactional($templateId, $sender, $email, null, $vars, $storeId);
		$translate->setTranslateInline(true);
	}
	
	public function getFaqUrl(){
		return $this->_getUrl('faq');
	}
}