<?php   
class Neo_Example_Block_Index extends Mage_Core_Block_Template{   

    public function getCategoryImages($categoryId)
    {
            $images = Mage::getModel('example/example')->getCollection()->addFieldToFilter('categories',array("finset"=>$categoryId))->addFieldToFilter("status",array("eq"=>1));
            
            foreach ($images as $image):
                    return $image->getImage();
            endforeach;
          

    }
    public function getSliderImages($categoryId)
    {
            $images = Mage::getModel('example/example')->getCollection()->addFieldToFilter('categories',array("finset"=>$categoryId))->addFieldToFilter("status",array("eq"=>1));
            
            return $images;

    }

}