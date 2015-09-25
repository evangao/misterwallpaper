<?php

/**
 * Save Card controller
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 **/

class ProxiBlue_PinPayments_CardController extends Mage_Core_Controller_Front_Action {
    
    /**
     * Add product to shopping cart action
     */
    public function saveAction() {
        try {
            if (!$this->getRequest()->isPost() && !mage::getSingleton('customer/session')->isLoggedIn()) {
                return;
            }
            $result = array();
            $data = $this->getRequest()->getPost('payment', array());
            if($data['method'] !='pinpayments'){
                return;
            }
            $pinCustomerModel = mage::getModel('pinpayments/customer');
            $pinCustomerModel->save($data['cc_number_enc']);
        } catch (Exception $e) {
            Mage::logException($e);
        }    
    }
    
    /**
     * Add product to shopping cart action
     */
    public function getAction() {
        try {
            if (!$this->getRequest()->isPost() && !mage::getSingleton('customer/session')->isLoggedIn()) {
                return;
            }
            $result = array();
            $data = $this->getRequest()->getPost('payment', array());
            if($data['method'] !='pinpayments'){
                return;
            }
            $pinCustomerModel = mage::getModel('pinpayments/customer');
            $cardToken = array('response' => $pinCustomerModel->getCustomerTokenCard());
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($cardToken));
        } catch (Exception $e) {
            Mage::logException($e);
        } 
        return $this;
    }


}
