<?php 

   class Neo_Gallery_Block_CatImages extends Mage_Core_Block_Template{   
	public function getImages($categoryId)
	{
		$images = Mage::getModel('gallery/image')->getCollection()->addFieldToFilter('category',array("finset"=>$categoryId))->addFieldToFilter("status",array("eq"=>1));
		return $images;
	}

}

?>
