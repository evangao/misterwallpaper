<?php
class Neo_Gallery_Model_Mysql4_Image extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("gallery/image", "image_id");
    }
}