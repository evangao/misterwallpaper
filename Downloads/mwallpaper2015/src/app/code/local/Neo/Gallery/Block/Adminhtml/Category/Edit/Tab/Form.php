<?php
class Neo_Gallery_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("gallery_form", array("legend"=>Mage::helper("gallery")->__("Item information")));

				
						$fieldset->addField("category_name", "text", array(
						"label" => Mage::helper("gallery")->__("category name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "category_name",
						));
									
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('gallery')->__('Category status'),
						'values'   => Neo_Gallery_Block_Adminhtml_Category_Grid::getValueArray4(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getCategoryData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCategoryData());
					Mage::getSingleton("adminhtml/session")->setCategoryData(null);
				} 
				elseif(Mage::registry("category_data")) {
				    $form->setValues(Mage::registry("category_data")->getData());
				}
				return parent::_prepareForm();
		}
}
