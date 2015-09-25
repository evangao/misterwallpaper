<?php
class Neo_Example_Block_Adminhtml_Examplecategory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("example_form", array("legend"=>Mage::helper("example")->__("Item information")));

				
				$fieldset->addField("name", "text", array(
				"label" => Mage::helper("example")->__("Catehory Name"),					
				"class" => "required-entry",
				"required" => true,
				"name" => "name",
				));
							
				 
				 
				$fieldset->addField('description', 'textarea', array(
				'label'     => Mage::helper('example')->__('Description'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'description',
				'disabled' => false,						
				'style'    => "width:600px;"
				
			      ));
				
				$fieldset->addField('status', 'select', array(
				'label'     => Mage::helper('example')->__('Status'),
				'values'   => Neo_Example_Block_Adminhtml_Examplecategory_Grid::getValueArray5(),
				'name' => 'status',					
				"class" => "required-entry",
				"required" => true,
				));		
						 

				if (Mage::getSingleton("adminhtml/session")->getExamplecategoryData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getExamplecategoryData());
					Mage::getSingleton("adminhtml/session")->setExamplecategoryData(null);
				} 
				elseif(Mage::registry("examplecategory_data")) {
				    $form->setValues(Mage::registry("examplecategory_data")->getData());
				}
				return parent::_prepareForm();
		}
}
