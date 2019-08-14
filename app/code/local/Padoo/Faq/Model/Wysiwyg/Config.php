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
 
require_once 'Mage/Cms/Model/Wysiwyg/Config.php';
class Padoo_Faq_Model_Wysiwyg_Config extends Mage_Cms_Model_Wysiwyg_Config		{
	public function getConfig($data = array())	{
		$config = new Varien_Object();
		$config->setData(array(
			'enabled'                       => $this->isEnabled(),
			'hidden'                        => $this->isHidden(),
			'use_container'                 => false,
			'add_variables'                 => false,
			'add_widgets'                   => false,
			'no_display'                    => false,
			'translator'                    => Mage::helper('faq'),
			'files_browser_window_url'      => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
			'files_browser_window_width'    => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'),
			'files_browser_window_height'   => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height'),
			'encode_directives'             => true,
			'directives_url'                => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
			'popup_css'                     => Mage::getBaseUrl('js').'mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css',
			'content_css'                   => Mage::getBaseUrl('js').'mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css',
			'width'                         => '100%',
			'plugins'                       => array()
		));
		$config->setData('directives_url_quoted', preg_quote($config->getData('directives_url')));
		if (is_array($data)) {
			$config->addData($data);
		}
		Mage::dispatchEvent('cms_wysiwyg_config_prepare', array('config' => $config));
		return $config;
	}
}