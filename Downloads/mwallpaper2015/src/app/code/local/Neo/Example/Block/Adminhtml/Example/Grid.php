<?php

class Neo_Example_Block_Adminhtml_Example_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("exampleGrid");
				$this->setDefaultSort("example_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("example/example")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("example_id", array(
				"header" => Mage::helper("example")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "example_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("example")->__("Exaple Title"),
				"index" => "name",
				));
						$this->addColumn('status', array(
						'header' => Mage::helper('example')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Neo_Example_Block_Adminhtml_Example_Grid::getOptionArray3(),				
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
			$this->setMassactionIdField('example_id');
			$this->getMassactionBlock()->setFormFieldName('example_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_example', array(
					 'label'=> Mage::helper('example')->__('Remove Example'),
					 'url'  => $this->getUrl('*/adminhtml_example/massRemove'),
					 'confirm' => Mage::helper('example')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray2()
		{
			$data_array=array();
			$data_array=array();
			$gallerycategory = Mage::getModel("example/examplecategory")->getCollection();
			foreach($gallerycategory as $category){
				$categoryId = (int)$category->getCategoryId();
				$categoryName = $category->getName();	
				$data_array[$categoryId] = $categoryName;
			}	
	    
			//$data_array[0]='First';
			//$data_array[1]='secound';
			//$data_array[2]='third';
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Neo_Example_Block_Adminhtml_Example_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray3()
		{
            $data_array=array(); 
			$data_array[0]='Inactive';
			$data_array[1]='Active';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(Neo_Example_Block_Adminhtml_Example_Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}