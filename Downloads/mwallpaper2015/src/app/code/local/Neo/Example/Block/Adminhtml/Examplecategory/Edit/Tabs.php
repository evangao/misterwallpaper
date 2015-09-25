<?php
class Neo_Example_Block_Adminhtml_Examplecategory_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("examplecategory_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("example")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("example")->__("Item Information"),
				"title" => Mage::helper("example")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("example/adminhtml_examplecategory_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
