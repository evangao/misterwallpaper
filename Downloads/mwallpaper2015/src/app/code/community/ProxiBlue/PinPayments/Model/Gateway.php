<?php

/**
 * Payment model
 * 
 * @category   ProxiBlue
 * @package    ProxiBlue_PinPayments
 * @author     Lucas van Staden (support@proxiblue.com.au)
 **/

class ProxiBlue_PinPayments_Model_Gateway extends ProxiBlue_PinPayments_Model_Api {

    protected $_code = 'pinpayments';
    protected $_isGateway = true;
    protected $_canAuthorize = false;
    protected $_canCapture = true;
    protected $_canCapturePartial = false; // gateway does not support partial refunds :(
    protected $_canRefund = true;
    protected $_canVoid = false;
    protected $_canUseInternal = true;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canSaveCc = true;
    // cc card form block
    protected $_formBlockType = 'pinpayments/ccform';

    /**
     * Capture the payment using the token previously gathered.
     * At no point does CC info enter the server or magento db
     * 
     * @param Varien_Object $payment
     * @param type $amount
     * @return \ProxiBlue_PinPayments_Model_Gateway
     */
    public function capture(Varien_Object $payment, $amount) {

        $this->setAmount($amount)
                ->setPayment($payment);

        try {
            $description = '';
            foreach ($payment->getOrder()->getAllItems() as $item) {
                if ($item->getParentItem()) {
                    continue;
                }
                if (Mage::helper('core/string')->strlen($description . $item->getName()) > 10000) {
                    break;
                }
                $description .= $item->getName() . ', ';
            }
            $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            $data = array('amount' => $this->getAmount() * 100,
                'currency' => $currencyCode,
                'description' => $description,
                'email' => $payment->getOrder()->getCustomerEmail(),
                'ip_address' => Mage::helper('core/http')->getRemoteAddr(),
                'card_token' => $payment->getCcNumberEnc()
            );
            $result = $this->talkToGateway($data, 'charges');
            if (property_exists($result, 'error')) {
                $message = $this->buildError($result);
                Mage::throwException($message);
            } else if (property_exists($result, 'response') && property_exists($result->response, 'success') && $result->response->success === true) {
                $payment->setStatus(self::STATUS_APPROVED)
                        ->setLastTransId($result->response->token)
                        ->setTransactionId($result->response->token);
            } else {
                mage::log($result);
                mage::throwException('Invalid response from payment gateway. Please check logs for details.');
            }
        } catch (Exception $e) {
            $this->getOnepage()->getCheckout()->setGotoSection('payment');
            Mage::throwException($e->getMessage());
        }
        return $this;
    }

    /**
     * Process a refund
     * 
     * @param Varien_Object $payment
     * @param double $amount
     * @return \ProxiBlue_PinPayments_Model_Gateway
     */
    public function refund(Varien_Object $payment, $amount) {
        $this->setAmount($amount)->setPayment($payment);
        try {
            $result = $this->talkToGateway(array(), 'charges/'.$payment->getRefundTransactionId().'/refunds');
            if (property_exists($result, 'error')) {
                $message = $this->buildError($result);
                Mage::throwException($message);
            } else if (property_exists($result, 'response') && property_exists($result->response, 'success')) {
                $payment->setStatus(self::STATUS_APPROVED)
                        ->setLastTransId($result->response->token)
                        ->setRefundTransactionId($result->response->token);
            } else {
                mage::log($result);
                mage::throwException('Invalid response from payment gateway. Please check logs for details.');
            }
        } catch (Exception $e) {

            Mage::throwException($e->getMessage());
        }
        return $this;
    }

}