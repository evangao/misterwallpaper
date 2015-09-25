<?php

class Neo_Resolution_Adminhtml_ResolutionController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("resolution/resolution")->_addBreadcrumb(Mage::helper("adminhtml")->__("Resolution  Manager"),Mage::helper("adminhtml")->__("Resolution Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Resolution"));
			    $this->_title($this->__("Manager Resolution"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Resolution"));
				$this->_title($this->__("Resolution"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("resolution/resolution")->load($id);
				if ($model->getId()) {
					Mage::register("resolution_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("resolution/resolution");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Resolution Manager"), Mage::helper("adminhtml")->__("Resolution Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Resolution Description"), Mage::helper("adminhtml")->__("Resolution Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("resolution/adminhtml_resolution_edit"))->_addLeft($this->getLayout()->createBlock("resolution/adminhtml_resolution_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("resolution")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Resolution"));
		$this->_title($this->__("Resolution"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("resolution/resolution")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("resolution_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("resolution/resolution");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Resolution Manager"), Mage::helper("adminhtml")->__("Resolution Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Resolution Description"), Mage::helper("adminhtml")->__("Resolution Description"));


		$this->_addContent($this->getLayout()->createBlock("resolution/adminhtml_resolution_edit"))->_addLeft($this->getLayout()->createBlock("resolution/adminhtml_resolution_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("resolution/resolution")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Resolution was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setResolutionData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setResolutionData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("resolution/resolution");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("resolution/resolution");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'resolution.csv';
			$grid       = $this->getLayout()->createBlock('resolution/adminhtml_resolution_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'resolution.xml';
			$grid       = $this->getLayout()->createBlock('resolution/adminhtml_resolution_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
