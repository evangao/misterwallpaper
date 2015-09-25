<?php
class Neo_Customprice_Block_Adminhtml_Customprice_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("customprice_form", array("legend"=>Mage::helper("customprice")->__("Item information")));

				
						$fieldset->addField("min", "text", array(
						"label" => Mage::helper("customprice")->__("Minimum size (sqm)"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "min",
						));
					
						$fieldset->addField("max", "text", array(
						"label" => Mage::helper("customprice")->__("Maximum zize (sqm)"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "max",
						));
					
						$fieldset->addField("price", "text", array(
						"label" => Mage::helper("customprice")->__("Price/sqm"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "price",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getCustompriceData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCustompriceData());
					Mage::getSingleton("adminhtml/session")->setCustompriceData(null);
				} 
				elseif(Mage::registry("customprice_data")) {
				    $form->setValues(Mage::registry("customprice_data")->getData());
				}
				return parent::_prepareForm();
		}
}
