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
 
require_once 'Mage/Adminhtml/Block/Widget/Grid.php';
class Padoo_Faq_Block_Adminhtml_Widget_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function addColumn($columnId, $column) {
		if (is_array($column))
			$this->_columns[$columnId] = $this->getLayout()->createBlock('faq/adminhtml_widget_grid_column')->setData($column)->setGrid($this);
		else
			throw new Exception(Mage::helper('adminhtml')->__('Wrong column format'));
		$this->_columns[$columnId]->setId($columnId);
		$this->_lastColumnId = $columnId;
		return $this;
	}
}

