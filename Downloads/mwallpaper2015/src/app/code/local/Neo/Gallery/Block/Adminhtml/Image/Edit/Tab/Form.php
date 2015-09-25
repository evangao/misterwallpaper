<?php
class Neo_Gallery_Block_Adminhtml_Image_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("gallery_form", array("legend"=>Mage::helper("gallery")->__("Item information")));

						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("gallery")->__("Image Title"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));		
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('gallery')->__('Upload Image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						 $fieldset->addField('category', 'multiselect', array(
						'label'     => Mage::helper('gallery')->__('Select Category'),
						'values'   => Neo_Gallery_Block_Adminhtml_Image_Grid::getValueArray1(),
						'name' => 'category',					
						"class" => "required-entry",
						"required" => true,
						));				
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('gallery')->__('Status of image'),
						'values'   => Neo_Gallery_Block_Adminhtml_Image_Grid::getValueArray2(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));
						
					

				if (Mage::getSingleton("adminhtml/session")->getImageData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getImageData());
					Mage::getSingleton("adminhtml/session")->setImageData(null);
				} 
				elseif(Mage::registry("image_data")) {
				    $form->setValues(Mage::registry("image_data")->getData());
				}
				return parent::_prepareForm();
		}
}
