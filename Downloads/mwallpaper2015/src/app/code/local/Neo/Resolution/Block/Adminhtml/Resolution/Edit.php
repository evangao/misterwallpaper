<?php
	
class Neo_Resolution_Block_Adminhtml_Resolution_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "resolution";
				$this->_controller = "adminhtml_resolution";
				$this->_updateButton("save", "label", Mage::helper("resolution")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("resolution")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("resolution")->__("Save And Continue Edit"),
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
				if( Mage::registry("resolution_data") && Mage::registry("resolution_data")->getId() ){

				    return Mage::helper("resolution")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("resolution_data")->getId()));

				} 
				else{

				     return Mage::helper("resolution")->__("Add Item");

				}
		}
}