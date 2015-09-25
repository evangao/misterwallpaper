<?php


class Neo_Resolution_Block_Adminhtml_Resolution extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_resolution";
	$this->_blockGroup = "resolution";
	$this->_headerText = Mage::helper("resolution")->__("Resolution Manager");
	$this->_addButtonLabel = Mage::helper("resolution")->__("Add New Item");
	parent::__construct();
	
	}

}