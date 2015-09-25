<?php
class Neo_Gallery_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Gallary"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("gallary", array(
                "label" => $this->__("Gallery"),
                "title" => $this->__("Gallery")
		   ));

      $this->renderLayout(); 
	  
    }

    public function displayImagesAction()
    {
        $categoryId = $this->getRequest()->getParam('cat');
	$catName = Mage::getModel('gallery/category')->load($categoryId)->getCategoryName();

	 $this->loadLayout(); 	
	$this->getLayout()->getBlock("head")->setTitle($this->__("Gallary"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("gallary", array(
                "label" => $this->__("Gallery"),
                "title" => $this->__("Gallery"),
		"link"  => Mage::getBaseUrl()."gallery"
		   ));

	$breadcrumbs->addCrumb("gallarycategory", array(
                "label" => $this->__($catName),
                "title" => $this->__($catName)
		   ));

      $this->renderLayout();
	

    }	
    
    public function galleryAction()
    {
	$this->loadLayout()->renderLayout();
	    
    
    }
    
    public function catImagesAction()
    {
	$this->loadLayout()->renderLayout();

    }
    
    public function fotoliaImageAction()
    {
	$this->loadLayout()->renderLayout();

    }
    
    
    public function fotoliaAction()
    {
	
	$this->loadLayout()->renderLayout();
    }
	
	public function showAction()
    {
      Mage::register('gallery_show', 'gallery_show');
	  $this->loadLayout()->renderLayout();
    }
    
}
