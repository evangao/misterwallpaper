<?php 

   class Neo_Gallery_Block_Gallery extends Mage_Core_Block_Template
	{   
		
	public function getCategoryImages($categoryId)
	{
		$images = Mage::getModel('gallery/image')->getCollection()->addFieldToFilter('category',array("finset"=>$categoryId))->addFieldToFilter("status",array("eq"=>1));
		foreach ($images as $image):
			return $image->getImage();
		endforeach;

	}

	}

?>
