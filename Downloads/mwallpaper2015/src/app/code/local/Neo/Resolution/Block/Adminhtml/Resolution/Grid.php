<?php

class Neo_Resolution_Block_Adminhtml_Resolution_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("resolutionGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("resolution/resolution")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("resolution")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("width_px", array(
				"header" => Mage::helper("resolution")->__("Width in pixel "),
				"index" => "width_px",
				));
				$this->addColumn("width_cm", array(
				"header" => Mage::helper("resolution")->__("Width in Centimeter"),
				"index" => "width_cm",
				));
				$this->addColumn("height_px", array(
				"header" => Mage::helper("resolution")->__("Height in pixel"),
				"index" => "height_px",
				));
				$this->addColumn("height_cm", array(
				"header" => Mage::helper("resolution")->__("Height in Centimeter"),
				"index" => "height_cm",
				));
						$this->addColumn('status', array(
						'header' => Mage::helper('resolution')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Neo_Resolution_Block_Adminhtml_Resolution_Grid::getOptionArray4(),				
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
			$this->getMassactionBlock()->addItem('remove_resolution', array(
					 'label'=> Mage::helper('resolution')->__('Remove Resolution'),
					 'url'  => $this->getUrl('*/adminhtml_resolution/massRemove'),
					 'confirm' => Mage::helper('resolution')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray4()
		{
            $data_array=array(); 
			$data_array[0]='Inactive';
			$data_array[1]='Active';
            return($data_array);
		}
		static public function getValueArray4()
		{
            $data_array=array();
			foreach(Neo_Resolution_Block_Adminhtml_Resolution_Grid::getOptionArray4() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}