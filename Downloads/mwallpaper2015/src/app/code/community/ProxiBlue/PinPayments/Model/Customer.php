<?php

/**
 * Customer model
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 * */
class ProxiBlue_PinPayments_Model_Customer extends ProxiBlue_PinPayments_Model_Api {

    protected $_code = 'pinpayments';
    protected $_customer = null;

    public function __construct() {
        parent::__construct();
        $customerId = mage::getSingleton('customer/session')->getId();
        $customer = mage::getModel('customer/customer')->load($customerId);
        if (is_object($customer) || $customer->getId()) {
            $this->_customer = $customer;
        }
    }

    /**
     * Capture the payment using the token previously gathered.
     * At no point does CC info enter the server or magento db
     * 
     * @param Varien_Object $payment
     * @param type $amount
     * @return \ProxiBlue_PinPayments_Model_Gateway
     */
    public function save($token) {
        try {
            if (!is_null($this->_customer)) {
                $data = array('email' => $this->_customer->getEmail(),
                    'card_token' => $token
                );

                $call = 'customers';
                $proto = Zend_Http_Client::POST;
                if (($this->getCustomerToken())) {
                    $call .= '/' . $this->getCustomerToken();
                    $proto = Zend_Http_Client::PUT;
                }

                $result = $this->talkToGateway($data, $call, $proto);
                if (property_exists($result, 'error')) {
                    $message = $this->buildError($result);
                    Mage::throwException($message);
                } else if (property_exists($result, 'response') && property_exists($result->response, 'token')) {
                    $this->_customer->setData('pinpayments_token', $result->response->token);
                    $this->_customer->save();
                } else {
                    mage::log($result);
                    mage::throwException('Invalid response from payment gateway. Please check logs for details.');
                }
            }
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
        }
        return $this;
    }

    public function getCustomerToken() {
        if (!is_null($this->_customer)) {
            return $this->_customer->getData('pinpayments_token');
        }
        return false;
    }

    public function getCustomerTokenCard() {
        if (!is_null($this->_customer)) {
            if (($this->getCustomerToken())) {
                $call = 'customers/' . $this->getCustomerToken();
                $proto = Zend_Http_Client::GET;
                $result = $this->talkToGateway(array(), $call, $proto);
                if (property_exists($result, 'error')) {
                    $message = $this->buildError($result);
                    Mage::throwException($message);
                } else if (property_exists($result, 'response') && property_exists($result->response, 'token')) {
                    return $result->response->card;
                } else {
                    mage::log($result);
                    mage::throwException('Invalid response from payment gateway. Please check logs for details.');
                }
            }
        }
        return false;
    }

}