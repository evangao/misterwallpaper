<?php

class Neo_Example_Block_Adminhtml_Examplecategory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("examplecategoryGrid");
				$this->setDefaultSort("category_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("example/examplecategory")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("category_id", array(
				"header" => Mage::helper("example")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "category_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("example")->__("Catehory Name"),
				"index" => "name",
				));
						$this->addColumn('status', array(
						'header' => Mage::helper('example')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Neo_Example_Block_Adminhtml_Examplecategory_Grid::getOptionArray5(),				
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
			$this->setMassactionIdField('category_id');
			$this->getMassactionBlock()->setFormFieldName('category_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_examplecategory', array(
					 'label'=> Mage::helper('example')->__('Remove Examplecategory'),
					 'url'  => $this->getUrl('*/adminhtml_examplecategory/massRemove'),
					 'confirm' => Mage::helper('example')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array[0]='Inactive';
			$data_array[1]='Active';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(Neo_Example_Block_Adminhtml_Examplecategory_Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}