<?php

/**
 * Faq - Magento Extension
 *
 * @package Faq
 * @category Padoo
 * @copyright Copyright 2015 Padoo. 
 */
 
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$configValuesMap = array(
  'faq/options/mail_to_store_template' => 'faq_options_mail_to_store_template',
);

foreach ($configValuesMap as $configPath=>$configValue) {
    $installer->setConfigData($configPath, $configValue);
}

