<?php
	
class Neo_Example_Block_Adminhtml_Examplecategory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "category_id";
				$this->_blockGroup = "example";
				$this->_controller = "adminhtml_examplecategory";
				$this->_updateButton("save", "label", Mage::helper("example")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("example")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("example")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("examplecategory_data") && Mage::registry("examplecategory_data")->getId() ){

				    return Mage::helper("example")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("examplecategory_data")->getId()));

				} 
				else{

				     return Mage::helper("example")->__("Add Item");

				}
		}
}