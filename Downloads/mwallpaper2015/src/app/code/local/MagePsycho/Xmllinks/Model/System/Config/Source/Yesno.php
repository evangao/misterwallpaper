<?php
class MagePsycho_Xmllinks_Model_System_Config_Source_Yesno
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label'=>Mage::helper('xmllinks')->__('Enabled')),
            array('value' => 1, 'label'=>Mage::helper('xmllinks')->__('Disabled')),
        );
    }

}