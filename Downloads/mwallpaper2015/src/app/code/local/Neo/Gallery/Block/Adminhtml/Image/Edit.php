<?php
	
class Neo_Gallery_Block_Adminhtml_Image_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "image_id";
				$this->_blockGroup = "gallery";
				$this->_controller = "adminhtml_image";
				$this->_updateButton("save", "label", Mage::helper("gallery")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("gallery")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("gallery")->__("Save And Continue Edit"),
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
				if( Mage::registry("image_data") && Mage::registry("image_data")->getId() ){

				    return Mage::helper("gallery")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("image_data")->getId()));

				} 
				else{

				     return Mage::helper("gallery")->__("Add Item");

				}
		}
}