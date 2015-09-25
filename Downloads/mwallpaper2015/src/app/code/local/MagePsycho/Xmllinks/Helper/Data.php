<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Xmllinks
 * @author     info@magepsycho.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Xmllinks_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($field, $section = 'option', $default = null){
        $value = Mage::getStoreConfig('xmllinks/'.$section.'/'.$field);
        if(!isset($value) or trim($value) == ''){
            return $default;
        }else{
            return $value;
        }
	}

    public function log($data){
        if(is_array($data) || is_object($data)){
            $data = print_r($data, true);
        }
        Mage::log($data, null, 'xmllinks.log');
	}

	public function getUrl($route, $params = array())
    {
        return $this->_getUrl($route, $params);
    }

	public function isActive(){
		return $this->getConfig('active');
	}
}