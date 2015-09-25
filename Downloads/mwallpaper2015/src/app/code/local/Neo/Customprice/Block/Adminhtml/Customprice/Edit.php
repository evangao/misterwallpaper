<?php
	
class Neo_Customprice_Block_Adminhtml_Customprice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "customprice";
				$this->_controller = "adminhtml_customprice";
				$this->_updateButton("save", "label", Mage::helper("customprice")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("customprice")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("customprice")->__("Save And Continue Edit"),
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
				if( Mage::registry("customprice_data") && Mage::registry("customprice_data")->getId() ){

				    return Mage::helper("customprice")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("customprice_data")->getId()));

				} 
				else{

				     return Mage::helper("customprice")->__("Add Item");

				}
		}
}