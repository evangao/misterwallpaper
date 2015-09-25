<?php
class Neo_Gallery_Block_Adminhtml_Image_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("image_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("gallery")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("gallery")->__("Item Information"),
				"title" => Mage::helper("gallery")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("gallery/adminhtml_image_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
