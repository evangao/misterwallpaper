<?php 

 class Neo_Orderprocess_Model_Observer
 {
    public function setCustomPrice(Varien_Event_Observer $obs)
	{
	 
	 
		
	  $item = $obs->getQuoteItem();
	  $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
	 // $product=$item->getProduct();
	  
	  $helper = Mage::helper('catalog/product_configuration');
	  $options = $helper->getCustomOptions($item);
	  
	  if($options[3]['value'] =="custom"){
	   $price = (float)Mage::getSingleton('core/session')->getCustomPrice();
	   
	   $item->setCustomPrice($price);
	   $item->setOriginalCustomPrice($price);
	   // Enable super mode on the product.
	   $item->getProduct()->setIsSuperMode(true);
	  }
		
	} 
 }
 
 ?>