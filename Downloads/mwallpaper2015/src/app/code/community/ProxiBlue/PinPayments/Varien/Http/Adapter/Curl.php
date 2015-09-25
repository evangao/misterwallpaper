<?php

/**
 * HTTP CURL Adapter - add PUT
 *
 */
class ProxiBlue_PinPayments_Varien_Http_Adapter_Curl extends Varien_Http_Adapter_Curl{ 

    /**
     * Send request to the remote server
     *
     * @param string        $method
     * @param Zend_Uri_Http $url
     * @param string        $http_ver
     * @param array         $headers
     * @param string        $body
     * @return string Request as text
     */
    public function write($method, $url, $http_ver = '1.1', $headers = array(), $body = '') {
        if ($method == Zend_Http_Client::PUT) {
            // not working, cop-out and used a system call to curl. (ugh)
            curl_setopt($this->_getResource(), CURLOPT_CUSTOMREQUEST, "PUT");
            //curl_setopt($this->_getResource(), CURLOPT_PUT, true); // some version of curl allows this, rarher than the above ?
            //curl_setopt($this->_getResource(), CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT') );
            curl_setopt($this->_getResource(), CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($this->_getResource(), CURLOPT_VERBOSE, true);
        }
        return parent::write($method, $url, $http_ver, $headers, $body);
    }

}
