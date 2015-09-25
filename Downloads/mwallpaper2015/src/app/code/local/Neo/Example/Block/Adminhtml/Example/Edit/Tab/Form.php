<?php
class Neo_Example_Block_Adminhtml_Example_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("example_form", array("legend"=>Mage::helper("example")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("example")->__("Exaple Title"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
									
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('example')->__('Image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						 $fieldset->addField('categories', 'multiselect', array(
						'label'     => Mage::helper('example')->__('Select Examples Category'),
						'values'   => Neo_Example_Block_Adminhtml_Example_Grid::getValueArray2(),
						'name' => 'categories',					
						"class" => "required-entry",
						"required" => true,
						));				
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('example')->__('Status'),
						'values'   => Neo_Example_Block_Adminhtml_Example_Grid::getValueArray3(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getExampleData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getExampleData());
					Mage::getSingleton("adminhtml/session")->setExampleData(null);
				} 
				elseif(Mage::registry("example_data")) {
				    $form->setValues(Mage::registry("example_data")->getData());
				}
				return parent::_prepareForm();
		}
}
