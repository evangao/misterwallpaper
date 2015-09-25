<?php


class Neo_Gallery_Block_Adminhtml_Image extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_image";
	$this->_blockGroup = "gallery";
	$this->_headerText = Mage::helper("gallery")->__("Image Manager");
	$this->_addButtonLabel = Mage::helper("gallery")->__("Add New Item");
	parent::__construct();
	
	}

}