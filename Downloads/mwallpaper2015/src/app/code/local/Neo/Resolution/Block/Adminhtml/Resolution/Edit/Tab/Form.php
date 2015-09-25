<?php
class Neo_Resolution_Block_Adminhtml_Resolution_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("resolution_form", array("legend"=>Mage::helper("resolution")->__("Item information")));

				
						$fieldset->addField("width_px", "text", array(
						"label" => Mage::helper("resolution")->__("Width in pixel "),					
						"class" => "required-entry",
						"required" => true,
						"name" => "width_px",
						));
					
						$fieldset->addField("width_cm", "text", array(
						"label" => Mage::helper("resolution")->__("Width in Centimeter"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "width_cm",
						));
					
						$fieldset->addField("height_px", "text", array(
						"label" => Mage::helper("resolution")->__("Height in pixel"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "height_px",
						));
					
						$fieldset->addField("height_cm", "text", array(
						"label" => Mage::helper("resolution")->__("Height in Centimeter"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "height_cm",
						));
									
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('resolution')->__('Status'),
						'values'   => Neo_Resolution_Block_Adminhtml_Resolution_Grid::getValueArray4(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getResolutionData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getResolutionData());
					Mage::getSingleton("adminhtml/session")->setResolutionData(null);
				} 
				elseif(Mage::registry("resolution_data")) {
				    $form->setValues(Mage::registry("resolution_data")->getData());
				}
				return parent::_prepareForm();
		}
}
