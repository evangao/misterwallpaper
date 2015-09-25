<?php
class Neo_Gallery_Adminhtml_GallerybackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Manage Gallary"));
	   $this->renderLayout();
    }
}