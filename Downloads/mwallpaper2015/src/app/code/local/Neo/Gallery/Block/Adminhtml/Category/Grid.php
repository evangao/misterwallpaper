<?php

class Neo_Gallery_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("categoryGrid");
				$this->setDefaultSort("category_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("gallery/category")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("category_id", array(
				"header" => Mage::helper("gallery")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "category_id",
				));
                
				$this->addColumn("category_name", array(
				"header" => Mage::helper("gallery")->__("category name"),
				"index" => "category_name",
				));
						$this->addColumn('status', array(
						'header' => Mage::helper('gallery')->__('Category status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Neo_Gallery_Block_Adminhtml_Category_Grid::getOptionArray4(),				
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
			$this->getMassactionBlock()->addItem('remove_category', array(
					 'label'=> Mage::helper('gallery')->__('Remove Category'),
					 'url'  => $this->getUrl('*/adminhtml_category/massRemove'),
					 'confirm' => Mage::helper('gallery')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray4()
		{
            $data_array=array(); 
			$data_array[1]='Active';
			$data_array[0]='Inactive';
            return($data_array);
		}
		static public function getValueArray4()
		{
            $data_array=array();
			foreach(Neo_Gallery_Block_Adminhtml_Category_Grid::getOptionArray4() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}
