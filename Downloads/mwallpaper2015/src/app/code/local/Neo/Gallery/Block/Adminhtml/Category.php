<?php


class Neo_Gallery_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_category";
	$this->_blockGroup = "gallery";
	$this->_headerText = Mage::helper("gallery")->__("Category Manager");
	$this->_addButtonLabel = Mage::helper("gallery")->__("Add New Item");
	parent::__construct();
	
	}

}