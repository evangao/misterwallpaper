<?php
class Neo_Example_Model_Mysql4_Examplecategory extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("example/examplecategory", "category_id");
    }
}