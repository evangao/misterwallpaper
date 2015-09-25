<?php

/**
 * API calls
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 **/


class ProxiBlue_PinPayments_Model_Api extends Mage_Payment_Model_Method_Abstract {

    /**
     * Talk to pin gateway
     * 
     * @param array $data
     * @param string $endPoint
     * @return object
     */
    protected function talkToGateway($data, $endPoint, $proto = Zend_Http_Client::POST) {
        $url = mage::helper('pinpayments')->getGatewayUrl() . '1/' . $endPoint;
        $secretKey = mage::getStoreConfig('payment/pinpayments/secret_api_key');
        if($proto == Zend_Http_Client::PUT) {
            $result = exec("curl {$url} -u {$secretKey}: -X PUT -d email={$data['email']} -d card_token={$data['card_token']}", $output, $return_var);
        } else {
            $curl = new ProxiBlue_PinPayments_Varien_Http_Adapter_Curl();
            $curl->setConfig(array(
                'timeout' => 15    //Timeout in no of seconds
            ));
            $curl->setConfig(array('userpwd' => mage::getStoreConfig('payment/pinpayments/secret_api_key') . ":"));
            $curl->write($proto, $url, '1.1', null, $data);
            $curlData = $curl->read();
            $result = Zend_Http_Response::extractBody($curlData);
            $curl->close();
            $result = json_decode($result);
        }
        return $result;
    }

    /**
     * Build error message string.
     * 
     * @param object $result
     * @return string
     */
    protected function buildError($result) {
        $message = $result->error_description . "\n\n";
        if (property_exists($result, 'messages')) {
            foreach ($result->messages as $messagePart) {
                if(is_array($messagePart)){
                    foreach ($messagePart as $subParts){
                        $message .= "\n" . $subParts;
                    }
                } else {
                    $message .= "\n" . $messagePart->message;
                }    
            }
        }
        return $message;
    }

    /**
     * Get one page checkout model
     *
     * @return Mage_Checkout_Model_Type_Onepage
     */
    protected function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

}