<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('padoo_faq'), 'group_id',
    'varchar(255) NOT NULL AFTER banner_id'
);
$installer->getConnection()->addColumn($installer->getTable('padoo_faq'), 'store_id',
    'varchar(255) NOT NULL AFTER sort_order'
);
$installer->getConnection()->addColumn($installer->getTable('padoo_faqgroup'), 'store_id',
    'varchar(255) NOT NULL AFTER cms_pages'
);
$installer->endSetup();
