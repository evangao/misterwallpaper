<?php

class Neo_Customprice_Block_Adminhtml_Customprice_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("custompriceGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("customprice/customprice")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("customprice")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("min", array(
				"header" => Mage::helper("customprice")->__("Minimum size (sqm)"),
				"index" => "min",
				));
				$this->addColumn("max", array(
				"header" => Mage::helper("customprice")->__("Maximum zize (sqm)"),
				"index" => "max",
				));
				$this->addColumn("price", array(
				"header" => Mage::helper("customprice")->__("Price/sqm"),
				"index" => "price",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_customprice', array(
					 'label'=> Mage::helper('customprice')->__('Remove Customprice'),
					 'url'  => $this->getUrl('*/adminhtml_customprice/massRemove'),
					 'confirm' => Mage::helper('customprice')->__('Are you sure?')
				));
			return $this;
		}
			

}