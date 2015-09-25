<?php
class Neo_Resolution_Block_Adminhtml_Resolution_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("resolution_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("resolution")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("resolution")->__("Item Information"),
				"title" => Mage::helper("resolution")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("resolution/adminhtml_resolution_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
