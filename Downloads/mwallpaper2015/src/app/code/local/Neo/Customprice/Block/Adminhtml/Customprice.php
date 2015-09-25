<?php


class Neo_Customprice_Block_Adminhtml_Customprice extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_customprice";
	$this->_blockGroup = "customprice";
	$this->_headerText = Mage::helper("customprice")->__("Customprice Manager");
	$this->_addButtonLabel = Mage::helper("customprice")->__("Add New Item");
	parent::__construct();
	
	}

}