<?php
$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('padoo_faq')};
CREATE TABLE {$this->getTable('padoo_faq')} (
  `banner_id` int(11) unsigned NOT NULL auto_increment,
  `faq` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `status` smallint(6) NOT NULL default '2',
  `sort_order` int(11) NOT NULL default '0',
  `created_time` DATETIME NULL,
  `update_time` DATETIME NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS {$this->getTable('padoo_faqgroup')};
CREATE TABLE {$this->getTable('padoo_faqgroup')} (
 `group_id` int(11) unsigned NOT NULL auto_increment,
 `group_name` varchar(225) NOT NULL default '',
 `status` smallint(6) NOT NULL default '2',
 `cms_pages` varchar(255) NOT NULL,
 `created_time` DATETIME NULL,
 `update_time` DATETIME NULL,
 PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();
?>