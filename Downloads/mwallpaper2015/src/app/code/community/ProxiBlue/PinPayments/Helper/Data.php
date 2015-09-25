<?php

/**
 * Helper functions
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 **/

class ProxiBlue_PinPayments_Helper_Data extends Mage_Core_Helper_Abstract {
    //Gateway Base Url 
    protected $_baseUrl = 'api.pin.net.au';
    
    /**
     * Build the correct gateway url
     * @return string
     */
    public function getGatewayUrl(){
       $url =  (Mage::getStoreConfig('payment/pinpayments/test_gateway'))?'test-'.$this->_baseUrl:$this->_baseUrl;
       return 'https://'.$url."/";
    }
    
}
