<?php
class Neo_Example_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Examples"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("examples", array(
                "label" => $this->__("Examples"),
                "title" => $this->__("Examples")
		   ));

      $this->renderLayout(); 
	  
    }
    public function displayImagesAction()
    {
        $categoryId = $this->getRequest()->getParam('cat');
	$catName = Mage::getModel('example/examplecategory')->load($categoryId)->getName();

	 $this->loadLayout(); 	
	$this->getLayout()->getBlock("head")->setTitle($this->__("Examples"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("gallary", array(
                "label" => $this->__("Examples"),
                "title" => $this->__("Examples"),
		"link"  => Mage::getBaseUrl()."examples"
		   ));

	$breadcrumbs->addCrumb("examplecategory", array(
                "label" => $this->__($catName),
                "title" => $this->__($catName)
		   ));

      $this->renderLayout();
	

    }	
    
    
}