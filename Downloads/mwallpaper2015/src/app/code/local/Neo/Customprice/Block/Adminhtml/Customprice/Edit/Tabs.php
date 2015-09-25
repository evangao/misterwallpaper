<?php
class Neo_Customprice_Block_Adminhtml_Customprice_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("customprice_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("customprice")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("customprice")->__("Item Information"),
				"title" => Mage::helper("customprice")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("customprice/adminhtml_customprice_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
