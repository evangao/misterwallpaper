<?php
/**
 * Credit Card Payment Form
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 **/

class ProxiBlue_PinPayments_Block_CCForm extends Mage_Payment_Block_Form_Cc {

    /**
     * Constructor
     */
    protected function _construct() {
        parent::_construct();
        $this->setTemplate('pinpayments/ccform.phtml');
    }
    
    /**
     * Get the pin.js url
     * @return string
     */
    public function getPinJsUrl(){
        return mage::helper('pinpayments')->getGatewayUrl() . 'pin.js';
        
    }
    
    /**
     * Payment JS url
     * @return string
     */
    public function getPaymentJsUrl(){
        return $this->getSkinUrl('/js/pinpayments.js');
    }
    
    /**
     * Get Public key
     * @return string
     */
    public function getPubApiKey(){
        return mage::getStoreConfig('payment/pinpayments/pub_api_key');
        
    }
    
    /**
     * Payment form cc image url
     * @return string
     */
    public function getCCImageUrl(){
        return $this->getSkinUrl('images/pinpayments/');
    }
    
    /**
     * Can Save Enabled
     * @return string
     */
    public function canSave(){
        $cansave = mage::getStoreConfig('payment/pinpayments/can_save');
        $isLoggedIn = mage::getSingleton('customer/session')->isLoggedIn();
        if($cansave && $isLoggedIn) {
            return true;
        }
        return false;
        
    }
    
    /**
     * Has Saved Card?
     * @return string
     */
    public function hasCustomerToken(){
        $pinCustomer = mage::getModel('pinpayments/customer');
        return $pinCustomer->getCustomerToken();
    }
    
    public function getCustomerTokenCard() {
        $pinCustomer = mage::getModel('pinpayments/customer');
        return $pinCustomer->getCustomerTokenCard();
    }

}
