<?php

class Neo_Gallery_Block_Adminhtml_Image_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("imageGrid");
				$this->setDefaultSort("image_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("gallery/image")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("image_id", array(
				"header" => Mage::helper("gallery")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    	"type" => "number",
				"index" => "image_id",
				));

				$this->addColumn("name", array(
				"header" => Mage::helper("gallery")->__("Title"),
				"index" => "name",
				));	
                
				$this->addColumn('status', array(
				'header' => Mage::helper('gallery')->__('Status of image'),
				'index' => 'status',
				'type' => 'options',
				'options'=>Neo_Gallery_Block_Adminhtml_Image_Grid::getOptionArray2(),				
				));
						
							
		 $this->addRssList('gallery/adminhtml_rss_rss/image', Mage::helper('gallery')->__('RSS'));
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
			$this->setMassactionIdField('image_id');
			$this->getMassactionBlock()->setFormFieldName('image_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_image', array(
					 'label'=> Mage::helper('gallery')->__('Remove Image'),
					 'url'  => $this->getUrl('*/adminhtml_image/massRemove'),
					 'confirm' => Mage::helper('gallery')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
			$data_array=array();
			$gallerycategory = Mage::getModel("gallery/category")->getCollection();
			foreach($gallerycategory as $category){
				$categoryId = (int)$category->getCategoryId();
				$categoryName = $category->getCategoryName();	
				$data_array[$categoryId] = $categoryName;
			}
             
			//$data_array[0]='Category 1';
			//$data_array[1]='category 2';
			//$data_array[2]='category 3';
			//$data_array[3]='category 4';
            return($data_array);
		}
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(Neo_Gallery_Block_Adminhtml_Image_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[1]='Active';
			$data_array[0]='Inactive';
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Neo_Gallery_Block_Adminhtml_Image_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}
