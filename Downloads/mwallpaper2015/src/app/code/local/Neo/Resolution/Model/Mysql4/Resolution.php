<?php
class Neo_Resolution_Model_Mysql4_Resolution extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("resolution/resolution", "id");
    }
}