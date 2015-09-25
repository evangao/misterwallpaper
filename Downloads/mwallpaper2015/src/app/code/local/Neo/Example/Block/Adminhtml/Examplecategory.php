<?php


class Neo_Example_Block_Adminhtml_Examplecategory extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_examplecategory";
	$this->_blockGroup = "example";
	$this->_headerText = Mage::helper("example")->__("Examplecategory Manager");
	$this->_addButtonLabel = Mage::helper("example")->__("Add New Item");
	parent::__construct();
	
	}

}